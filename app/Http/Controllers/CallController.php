<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\QrCode;
use App\Models\FraudDetection;
use App\Models\CallLog;
use Illuminate\Support\Facades\Cache;

class CallController extends Controller
{
    // Step 1: Frontend se call aata hai - Owner ko call karo
    public function callOwner(Request $request, $qrId)
    {
        $qrCode = QrCode::with('owner')->findOrFail($qrId);

        $callerMobile = $request->input('caller_number');

        // Agar emergency contact number aaya toh use karo, warna owner ka number
        $agentMobile = $request->input('agent_number')
            ?? $qrCode->owner->mobile_number;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('BONVOICE_API_TOKEN'),
            'Content-Type'  => 'application/json',
        ])->post(env('BONVOICE_BASE_URL') . '/click-to-call', [
            'did'      => env('BONVOICE_DID'),
            'agent'    => $agentMobile,
            'customer' => $callerMobile,
        ]);

        CallLog::create([
            'qr_id'    => $qrId,
            'caller'   => $callerMobile,
            'agent'    => $agentMobile,
            'status'   => $response->successful() ? 'initiated' : 'failed',
            'response' => $response->body(),
        ]);

        return response()->json([
            'success' => $response->successful(),
            'message' => $response->successful() ? 'Call connecting...' : 'Call failed'
        ]);
    }

    // Step 2: Bonvoice Webhook - Incoming call pe agent route karo
    public function callRouting(Request $request)
    {
        $did    = $request->input('did');
        $caller = $request->input('from');

        // QR code se owner dhundo jiska DID match kare
        $qrCode = QrCode::whereHas('owner', function ($q) use ($did) {
            $q->where('did_number', $did);
        })->with('owner')->first();

        if ($qrCode) {
            return response()->json([
                'status'      => '1',
                'destination' => $qrCode->owner->mobile_number,
            ]);
        }

        // Fallback
        return response()->json([
            'status'      => '1',
            'destination' => env('DEFAULT_AGENT'),
        ]);
    }
    
    /**
     * Format mobile number to 91XXXXXXXXXX
     */
    private function formatMobileNumber($mobile)
    {
        $mobile = preg_replace('/\D/', '', $mobile);

        if (!str_starts_with($mobile, '91') && strlen($mobile) == 10) {
            $mobile = '91' . $mobile;
        }

        return $mobile;
    }

    private function logFraudCall($from, $to, $qrCodeId, $type)
    {
        $from = $this->formatMobileNumber($from);
        $to   = $this->formatMobileNumber($to);

        $monthlyCount = FraudDetection::where('qr_code_id', $qrCodeId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $fraudFlag = ($monthlyCount >= 5) ? 1 : 0;

        $fraud = FraudDetection::create([
            'from_number' => $from,
            'to_number' => $to,
            'qr_code_id' => $qrCodeId,
            'type' => $type,
            'call_started_at' => now(),
            'fraud' => $fraudFlag
        ]);

        Cache::put('fraud_detection_id', $fraud->id, now()->addMinute());

        return $to;
    }

    public function addOwnerMobileNoInSession($id)
    {
        $qrCode = QrCode::with('owner')->find($id);

        if (!$qrCode || !$qrCode->owner) {
            return response()->json([
                'status' => false,
                'msg' => 'Mobile number not found',
            ]);
        }

        $ownerMobile = $this->formatMobileNumber($qrCode->owner->mobile_number);

        Cache::put('owner_call_number', $ownerMobile, now()->addMinute());

        $callerNumber = '919999999999';

        $this->logFraudCall(
            $callerNumber,
            $ownerMobile,
            $qrCode->qr_code,
            'normal_call'
        );

        return response()->json([
            'status' => true,
            'msg' => $ownerMobile . ' mobile number stored',
            'virtual_no' => env('MSG91_CALLER_ID'),
        ]);
    }

    public function addOwnerEmegMobileNoInSession($id = null, $k = null)
    {
        $qrCode = QrCode::with('owner')->find($id);

        if (!$qrCode || !$qrCode->owner) {
            return response()->json([
                'status' => false,
                'msg' => 'Mobile number not found',
            ]);
        }

        $emeMobile = $qrCode->owner->{'friend_family_'.$k};

        if (!$emeMobile) {
            return response()->json([
                'status' => false,
                'msg' => 'Emergency mobile number not found',
            ]);
        }

        $emeMobile = $this->formatMobileNumber($emeMobile);

        Cache::put('owner_call_number', $emeMobile, now()->addMinute());

        $callerNumber = '919999999999';

        $this->logFraudCall(
            $callerNumber,
            $emeMobile,
            $qrCode->qr_code,
            'emergency_call'
        );

        return response()->json([
            'status' => true,
            'msg' => $emeMobile . ' mobile number stored',
            'virtual_no' => env('MSG91_CALLER_ID'),
        ]);
    }

    public function getOwnerMobileNo()
    {
        $ownerMobile = Cache::get('owner_call_number');
    
        if ($ownerMobile) {
    
            $ownerMobile = preg_replace('/\D/', '', $ownerMobile);
    
            if (!str_starts_with($ownerMobile, '91') && strlen($ownerMobile) == 10) {
                $ownerMobile = '91' . $ownerMobile;
            }

            // Get fraud record id
            $fraudId = Cache::get('fraud_detection_id');

            if ($fraudId) {

                FraudDetection::where('id', $fraudId)->update([
                    'call_ended_at' => now()
                ]);
            }
    
            return response()->json([
                'destination' => $ownerMobile
            ]);
        }
    
        return response()->json([
            'status' => false,
            'msg' => 'mobile number not found',
        ]);
    }
}