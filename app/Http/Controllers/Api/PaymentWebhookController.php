<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Handle Razorpay webhook
     */
    public function razorpay(Request $request)
    {
        try {
            // Verify webhook signature
            $webhookSecret = config('services.razorpay.webhook_secret');
            $webhookSignature = $request->header('X-Razorpay-Signature');
            $webhookBody = $request->getContent();

            $expectedSignature = hash_hmac('sha256', $webhookBody, $webhookSecret);

            if ($webhookSignature !== $expectedSignature) {
                Log::warning('Invalid Razorpay webhook signature');
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            // Process webhook
            $payload = $request->all();
            $this->paymentService->handleWebhook($payload);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Razorpay webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Handle Paytm webhook
     */
    public function paytm(Request $request)
    {
        try {
            Log::info('Paytm webhook received', $request->all());

            // Paytm webhook processing logic
            // TODO: Implement Paytm verification and processing

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Paytm webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }
}
