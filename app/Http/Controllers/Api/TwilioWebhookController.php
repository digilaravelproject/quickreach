<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CallMaskingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TwilioWebhookController extends Controller
{
    protected $callMaskingService;

    public function __construct(CallMaskingService $callMaskingService)
    {
        $this->callMaskingService = $callMaskingService;
    }

    /**
     * Handle Twilio status callback
     */
    public function callback(Request $request)
    {
        try {
            Log::info('Twilio callback received', $request->all());

            $data = [
                'call_sid' => $request->input('CallSid'),
                'call_status' => $request->input('CallStatus'),
                'from' => $request->input('From'),
                'to' => $request->input('To'),
                'duration' => $request->input('CallDuration'),
            ];

            $this->callMaskingService->handleCallCallback($data);

            return response()->xml('<?xml version="1.0" encoding="UTF-8"?><Response></Response>');
        } catch (\Exception $e) {
            Log::error('Twilio callback error: ' . $e->getMessage());
            return response()->xml('<?xml version="1.0" encoding="UTF-8"?><Response></Response>');
        }
    }

    /**
     * Handle Exotel status callback
     */
    public function exotelCallback(Request $request)
    {
        try {
            Log::info('Exotel callback received', $request->all());

            $data = [
                'call_sid' => $request->input('CallSid'),
                'call_status' => $request->input('Status'),
                'from' => $request->input('From'),
                'to' => $request->input('To'),
                'duration' => $request->input('CallDuration'),
                'recording_url' => $request->input('RecordingUrl'),
            ];

            $this->callMaskingService->handleCallCallback($data);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Exotel callback error: ' . $e->getMessage());
            return response()->json(['error' => 'Callback processing failed'], 500);
        }
    }
}
