<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\QrScan;
use App\Models\QrRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrScanController extends Controller
{
    /**
     * Main QR Scan Handler
     * Check qr_registrations table for registration
     */
    public function scan(Request $request, string $code)
    {

        // QR Code fetch karo
        $qrCode = QrCode::with(['category'])
            ->where('qr_code', $code)
            ->firstOrFail();

        // Scan log karo
        $this->logScan($qrCode, $request);
        if ($qrCode->status === 'available') {
            return view('scanner.not-active', compact('qrCode'))
                ->with('info', 'This tag is available for purchase.');
        }


        $registration = QrRegistration::where('qr_code_id', $qrCode->id)->first();

        if (!$registration) {

            return redirect()->route('user.register-qr', $qrCode->id)
                ->with('info', 'Please register your QR code to activate it.');
        }

        if ($registration) {

            $ownerDetails = $registration;

            if (Auth::check() && Auth::id() === $qrCode->user_id) {

                return redirect()->route('user.my-qrs')
                    ->with('info', 'This is your registered QR code.');
            }

            return view('scanner.contact-owner', compact('qrCode', 'ownerDetails'));
        }
        return view('scanner.not-active', compact('qrCode'));
    }

    /**
     * WhatsApp link create karo
     */
    public function initiateWhatsApp(QrCode $qrCode)
    {
        // Registration check karo
        $registration = QrRegistration::where('qr_code_id', $qrCode->id)->first();

        if (!$registration) {
            return redirect()->back()->with('error', 'This QR code is not registered yet.');
        }

        // WhatsApp message
        $message = "Hi! I found your {$qrCode->category->name} with QR code {$qrCode->qr_code}. I would like to return it to you.";

        // Mobile format karo
        $mobile = preg_replace('/[^0-9]/', '', $registration->mobile_number);

        // India specific prefix check
        if (strlen($mobile) === 10) {
            $mobile = '91' . $mobile;
        }

        // WhatsApp link
        $whatsappLink = "https://wa.me/{$mobile}?text=" . urlencode($message);

        // Log karo
        $this->logScan($qrCode, request(), 'whatsapp');

        // Redirect to WhatsApp
        return redirect()->away($whatsappLink);
    }

    /**
     * Emergency contacts fetch karo
     */
    public function emergencyContact(Request $request, QrCode $qrCode)
    {
        // Registration check karo
        $registration = QrRegistration::where('qr_code_id', $qrCode->id)->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'This QR code is not registered yet.'
            ], 400);
        }

        // Emergency contacts nikalo
        $emergencyContacts = $registration->emergency_contacts ?? [];

        if (empty($emergencyContacts)) {
            return response()->json([
                'success' => false,
                'message' => 'No emergency contacts available.'
            ], 400);
        }

        // Log karo
        $this->logScan($qrCode, $request, 'emergency_view');

        return response()->json([
            'success' => true,
            'emergency_contacts' => $emergencyContacts
        ]);
    }

    /**
     * Call initiate (abhi simple response)
     */
    public function initiateCall(Request $request, QrCode $qrCode)
    {
        $request->validate([
            'scanner_number' => 'required|string|regex:/^[0-9]{10}$/'
        ]);

        // Registration check karo
        $registration = QrRegistration::where('qr_code_id', $qrCode->id)->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'This QR code is not registered yet.'
            ], 400);
        }

        // Log karo
        $this->logScan($qrCode, $request, 'call');

        // Temporary response - API integration baad me
        return response()->json([
            'success' => true,
            'message' => 'Owner will be notified. Please use WhatsApp for instant contact.',
        ]);
    }

    /**
     * Emergency call (abhi simple response)
     */
    public function initiateEmergencyCall(Request $request, QrCode $qrCode)
    {
        $request->validate([
            'scanner_number' => 'required|string|regex:/^[0-9]{10}$/',
            'emergency_number' => 'required|string|regex:/^[0-9]{10}$/'
        ]);

        // Registration check karo
        $registration = QrRegistration::where('qr_code_id', $qrCode->id)->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'This QR code is not registered yet.'
            ], 400);
        }

        // Log karo
        $this->logScan($qrCode, $request, 'emergency_call');

        // Temporary response - API integration baad me
        return response()->json([
            'success' => true,
            'message' => 'Emergency contacts have been notified.',
        ]);
    }

    /**
     * Scan log karo database me
     */
    private function logScan(QrCode $qrCode, Request $request, string $action = 'view'): void
    {
        QrScan::create([
            'qr_code_id' => $qrCode->id,
            'scanner_ip' => $request->ip(),
            'scanner_user_agent' => $request->userAgent(),
            'action_taken' => $action,
            'scanned_at' => now()
        ]);
    }
}
