<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Exception;

class CallMaskingService
{
    protected $twilio;
    protected $twilioNumber;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->twilioNumber = config('services.twilio.phone_number');

        $this->twilio = new Client($sid, $token);
    }

    /**
     * Initiate a masked call between scanner and owner
     */
    public function initiateMaskedCall(string $scannerNumber, string $ownerNumber): array
    {
        try {
            // Create a TwiML response that connects the call
            $twiml = $this->generateCallTwiml($ownerNumber);

            // Initiate the call to the scanner
            $call = $this->twilio->calls->create(
                $scannerNumber,
                $this->twilioNumber,
                [
                    'twiml' => $twiml,
                    'statusCallback' => route('api.twilio.callback'),
                    'statusCallbackMethod' => 'POST',
                    'statusCallbackEvent' => ['initiated', 'ringing', 'answered', 'completed']
                ]
            );

            return [
                'success' => true,
                'call_sid' => $call->sid,
                'status' => $call->status,
                'message' => 'Call initiated successfully'
            ];
        } catch (Exception $e) {
            Log::error('Call masking failed: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to initiate call: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Generate TwiML for connecting the call
     */
    private function generateCallTwiml(string $ownerNumber): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
                <Response>
                    <Say voice="alice" language="en-IN">Connecting you to the owner. Please wait.</Say>
                    <Dial timeout="30" callerId="' . $this->twilioNumber . '">
                        <Number>' . $ownerNumber . '</Number>
                    </Dial>
                </Response>';
    }

    /**
     * Alternative: Using Exotel for India-specific requirements
     */
    public function initiateExotelCall(string $scannerNumber, string $ownerNumber): array
    {
        $exotelSid = config('services.exotel.sid');
        $exotelToken = config('services.exotel.token');
        $exotelNumber = config('services.exotel.phone_number');

        try {
            $url = "https://api.exotel.com/v1/Accounts/{$exotelSid}/Calls/connect.json";

            $postData = [
                'From' => $scannerNumber,
                'To' => $ownerNumber,
                'CallerId' => $exotelNumber,
                'StatusCallback' => route('api.exotel.callback'),
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_USERPWD, $exotelSid . ':' . $exotelToken);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                $result = json_decode($response, true);
                return [
                    'success' => true,
                    'call_sid' => $result['Call']['Sid'] ?? null,
                    'status' => $result['Call']['Status'] ?? 'initiated',
                    'message' => 'Call initiated successfully via Exotel'
                ];
            }

            throw new Exception('Exotel API returned status code: ' . $httpCode);
        } catch (Exception $e) {
            Log::error('Exotel call failed: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to initiate call via Exotel: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Handle call status callback
     */
    public function handleCallCallback(array $data): void
    {
        Log::info('Call callback received', $data);

        // Store call logs, update statistics, etc.
    }
}
