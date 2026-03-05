<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\QrCode;
use App\Models\QrRegistration;
use App\Models\CallLog;

class CallController extends Controller
{
    public function callOwner(Request $request, $qrId)
    {
        // 1. Find QR Code
        $qrCode = QrCode::findOrFail($qrId);

        // 2. Find Owner Registration
        $registration = QrRegistration::where('qr_code_id', $qrCode->id)->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Owner registration not found',
            ], 404);
        }

        // 3. Get Numbers
        $callerMobile = trim($request->input('caller_number')); 
        $agentMobile  = trim($request->input('agent_number')) ?: $registration->mobile_number;

        // 4. Clean and Format Numbers (Ensure 91 prefix)
        $formatNumber = function($number) {
            $clean = preg_replace('/\D/', '', $number);
            // If it's 10 digits, add 91
            if (strlen($clean) === 10) {
                return '91' . $clean;
            }
            // If it starts with 0 and then 10 digits
            if (strlen($clean) === 11 && str_starts_with($clean, '0')) {
                return '91' . substr($clean, 1);
            }
            // If it's already 12 digits starting with 91, leave it
            return $clean;
        };

        $destination  = $formatNumber($callerMobile);
        $destinationB = $formatNumber($agentMobile);

        Log::info('MSG91 CTC Request', [
            'qr_id'        => $qrId,
            'destination'  => $destination,
            'destinationB' => $destinationB,
        ]);

        // 5. MSG91 Click-to-Call API
        try {
            $response = Http::withHeaders([
                'authkey'      => config('services.msg91.auth_key'),
                'accept'       => 'application/json',
                'content-type' => 'application/json',
            ])->post('https://control.msg91.com/api/v5/voice/call/ctc', [
                'caller_id'    => config('services.msg91.caller_id'),
                'destination'  => $destination,
                'destinationB' => [$destinationB],
            ]);

            $responseData = $response->json();

            Log::info('MSG91 CTC Response', [
                'http_status' => $response->status(),
                'body'        => $response->body(),
            ]);

            // MSG91 returns 'type' => 'success' on success
            $isSuccess = $response->successful() && isset($responseData['type']) && $responseData['type'] === 'success';

            // 6. Create Call log
            CallLog::create([
                'qr_id'    => $qrId,
                'caller'   => $destination,
                'agent'    => $destinationB,
                'status'   => $isSuccess ? 'initiated' : 'failed',
                'response' => $response->body(),
            ]);

            return response()->json([
                'success' => $isSuccess,
                'message' => $isSuccess
                    ? 'Call aa rahi hai aapke number pe!'
                    : 'Call failed: ' . ($responseData['message'] ?? 'API Error'),
                'debug'   => $responseData,
            ]);

        } catch (\Exception $e) {
            Log::error('MSG91 Exception', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function callRouting(Request $request)
    {
        $did = $request->input('did');
        $registration = QrRegistration::where('did_number', $did)->first();

        if ($registration) {
            return response()->json([
                'status'      => '1',
                'destination' => $registration->mobile_number,
            ]);
        }

        return response()->json([
            'status'      => '1',
            'destination' => config('services.msg91.default_agent'),
        ]);
    }
}