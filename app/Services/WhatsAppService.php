<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class WhatsAppService
{
    protected $apiUrl;
    protected $apiToken;
    protected $businessPhoneId;

    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.api_url');
        $this->apiToken = config('services.whatsapp.api_token');
        $this->businessPhoneId = config('services.whatsapp.business_phone_id');
    }

    /**
     * Send WhatsApp message to owner
     */
    public function sendMessageToOwner(string $ownerNumber, string $message, array $context = []): array
    {
        try {
            $url = "{$this->apiUrl}/{$this->businessPhoneId}/messages";

            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $this->formatPhoneNumber($ownerNumber),
                'type' => 'text',
                'text' => [
                    'body' => $message
                ]
            ];

            $response = Http::withToken($this->apiToken)
                ->post($url, $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message_id' => $response->json('messages.0.id'),
                    'message' => 'WhatsApp message sent successfully'
                ];
            }

            throw new Exception('WhatsApp API error: ' . $response->body());
        } catch (Exception $e) {
            Log::error('WhatsApp message failed: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to send WhatsApp message: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Send template message (for notifications)
     */
    public function sendTemplateMessage(string $recipientNumber, string $templateName, array $parameters = []): array
    {
        try {
            $url = "{$this->apiUrl}/{$this->businessPhoneId}/messages";

            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $this->formatPhoneNumber($recipientNumber),
                'type' => 'template',
                'template' => [
                    'name' => $templateName,
                    'language' => [
                        'code' => 'en'
                    ],
                    'components' => $this->buildTemplateComponents($parameters)
                ]
            ];

            $response = Http::withToken($this->apiToken)
                ->post($url, $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message_id' => $response->json('messages.0.id'),
                    'message' => 'Template message sent successfully'
                ];
            }

            throw new Exception('WhatsApp API error: ' . $response->body());
        } catch (Exception $e) {
            Log::error('WhatsApp template message failed: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to send template message: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create WhatsApp link for direct chat
     */
    public function createWhatsAppLink(string $phoneNumber, string $prefilledMessage = ''): string
    {
        $formattedNumber = $this->formatPhoneNumber($phoneNumber);
        $encodedMessage = urlencode($prefilledMessage);

        return "https://wa.me/{$formattedNumber}?text={$encodedMessage}";
    }

    /**
     * Send emergency notification to multiple contacts
     */
    public function sendEmergencyNotification(array $contacts, array $itemDetails): array
    {
        $results = [];

        $message = "🚨 EMERGENCY ALERT 🚨\n\n";
        $message .= "Someone has found your {$itemDetails['category']} and is trying to return it.\n\n";
        $message .= "Item: {$itemDetails['category']}\n";
        $message .= "QR Code: {$itemDetails['qr_code']}\n";
        $message .= "Time: " . now()->format('d M Y, h:i A') . "\n\n";
        $message .= "Please contact the finder as soon as possible.";

        foreach ($contacts as $contact) {
            $result = $this->sendMessageToOwner($contact['number'], $message);
            $results[] = [
                'contact' => $contact,
                'result' => $result
            ];
        }

        return $results;
    }

    /**
     * Format phone number for WhatsApp API
     */
    private function formatPhoneNumber(string $number): string
    {
        // Remove all non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $number);

        // Add country code if not present (assuming India +91)
        if (!str_starts_with($number, '91') && strlen($number) === 10) {
            $number = '91' . $number;
        }

        return $number;
    }

    /**
     * Build template components from parameters
     */
    private function buildTemplateComponents(array $parameters): array
    {
        if (empty($parameters)) {
            return [];
        }

        return [
            [
                'type' => 'body',
                'parameters' => array_map(function ($param) {
                    return [
                        'type' => 'text',
                        'text' => $param
                    ];
                }, $parameters)
            ]
        ];
    }
}
