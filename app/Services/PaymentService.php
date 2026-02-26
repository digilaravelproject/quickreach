<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\QrCode;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentService
{
    protected $razorpay;

    public function __construct()
    {
        $keyId = config('services.razorpay.key_id');
        $keySecret = config('services.razorpay.key_secret');

        $this->razorpay = new Api($keyId, $keySecret);
    }

    /**
     * Create a new order for payment
     */
    public function createOrder(int $userId, int $categoryId, float $amount): array
    {
        try {
            $orderId = 'ORD' . strtoupper(Str::random(12));

            // Create Razorpay order
            $razorpayOrder = $this->razorpay->order->create([
                'receipt' => $orderId,
                'amount' => $amount * 100, // Convert to paise
                'currency' => 'INR',
                'notes' => [
                    'user_id' => $userId,
                    'category_id' => $categoryId,
                ]
            ]);

            // Create payment record in database
            $payment = Payment::create([
                'user_id' => $userId,
                'order_id' => $orderId,
                'amount' => $amount,
                'discount_amount' => 0,
                'final_amount' => $amount,
                'status' => 'pending',
                'payment_gateway' => 'razorpay',
                'payment_details' => [
                    'razorpay_order_id' => $razorpayOrder->id,
                    'category_id' => $categoryId,
                ]
            ]);

            return [
                'success' => true,
                'order_id' => $orderId,
                'razorpay_order_id' => $razorpayOrder->id,
                'amount' => $amount,
                'currency' => 'INR',
                'payment' => $payment,
            ];
        } catch (Exception $e) {
            Log::error('Payment order creation failed: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify payment signature
     */
    public function verifyPayment(string $orderId, string $paymentId, string $signature): array
    {
        try {
            $payment = Payment::where('order_id', $orderId)->firstOrFail();
            $razorpayOrderId = $payment->payment_details['razorpay_order_id'];

            // Verify signature
            $attributes = [
                'razorpay_order_id' => $razorpayOrderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature
            ];

            $this->razorpay->utility->verifyPaymentSignature($attributes);

            // Fetch payment details from Razorpay
            $razorpayPayment = $this->razorpay->payment->fetch($paymentId);

            // Update payment record
            $payment->update([
                'transaction_id' => $paymentId,
                'status' => 'completed',
                'payment_method' => $this->mapPaymentMethod($razorpayPayment->method),
                'payment_details' => array_merge($payment->payment_details ?? [], [
                    'razorpay_payment_id' => $paymentId,
                    'razorpay_signature' => $signature,
                    'payment_method' => $razorpayPayment->method,
                    'payment_captured' => $razorpayPayment->captured,
                ]),
                'completed_at' => now(),
            ]);

            // Assign QR code to user
            $categoryId = $payment->payment_details['category_id'];
            $qrCode = $this->assignQrCodeToUser($payment->user_id, $categoryId);

            if ($qrCode) {
                $payment->update(['qr_code_id' => $qrCode->id]);
            }

            return [
                'success' => true,
                'payment' => $payment->fresh(),
                'qr_code' => $qrCode,
                'message' => 'Payment verified successfully'
            ];
        } catch (Exception $e) {
            Log::error('Payment verification failed: ' . $e->getMessage());

            // Mark payment as failed
            if (isset($payment)) {
                $payment->update([
                    'status' => 'failed',
                    'failure_reason' => $e->getMessage()
                ]);
            }

            return [
                'success' => false,
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Handle payment webhook
     */
    public function handleWebhook(array $payload): void
    {
        try {
            $event = $payload['event'];

            switch ($event) {
                case 'payment.authorized':
                    $this->handlePaymentAuthorized($payload['payload']['payment']['entity']);
                    break;

                case 'payment.captured':
                    $this->handlePaymentCaptured($payload['payload']['payment']['entity']);
                    break;

                case 'payment.failed':
                    $this->handlePaymentFailed($payload['payload']['payment']['entity']);
                    break;
            }
        } catch (Exception $e) {
            Log::error('Webhook handling failed: ' . $e->getMessage());
        }
    }

    /**
     * Assign QR code to user after successful payment
     */
    private function assignQrCodeToUser(int $userId, int $categoryId): ?QrCode
    {
        $qrCode = QrCode::where('category_id', $categoryId)
            ->where('status', 'available')
            ->first();

        if ($qrCode) {
            $qrCode->update([
                'user_id' => $userId,
                'status' => 'assigned',
                'assigned_at' => now(),
            ]);
        }

        return $qrCode;
    }

    /**
     * Map Razorpay payment method to our enum
     */
    private function mapPaymentMethod(string $method): string
    {
        return match ($method) {
            'upi' => 'upi',
            'card' => 'card',
            'netbanking' => 'netbanking',
            'wallet' => 'wallet',
            default => 'upi',
        };
    }

    /**
     * Handle payment authorized event
     */
    private function handlePaymentAuthorized(array $paymentData): void
    {
        $payment = Payment::where('transaction_id', $paymentData['id'])->first();

        if ($payment) {
            $payment->update(['status' => 'processing']);
        }
    }

    /**
     * Handle payment captured event
     */
    private function handlePaymentCaptured(array $paymentData): void
    {
        $payment = Payment::where('transaction_id', $paymentData['id'])->first();

        if ($payment && $payment->status !== 'completed') {
            $payment->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        }
    }

    /**
     * Handle payment failed event
     */
    private function handlePaymentFailed(array $paymentData): void
    {
        $payment = Payment::where('transaction_id', $paymentData['id'])->first();

        if ($payment) {
            $payment->update([
                'status' => 'failed',
                'failure_reason' => $paymentData['error_description'] ?? 'Payment failed'
            ]);
        }
    }
}
