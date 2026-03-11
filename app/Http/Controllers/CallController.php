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
    
    public function addOwnerMobileNoInSession($id)
    {
        $qrCode = QrCode::with('owner')->find($id);
    
        if ($qrCode && $qrCode->owner) {
    
            Cache::put('owner_call_number', $qrCode->owner->mobile_number, now()->addMinute());
            
            $caller_number = '919999999999';
            
            // $caller_number = request()->caller_number;
            
            // if ($caller_number) {
    
            //     $caller_number = preg_replace('/\D/', '', $caller_number);
        
            //     if (!str_starts_with($caller_number, '91') && strlen($caller_number) == 10) {
            //         $caller_number = '91' . $caller_number;
            //     }
            // }

            // Save call initiated record
            $fraud = FraudDetection::create([
                'from_number' => $caller_number,
                'qr_code_id' => $qrCode->qr_code,
                'type' => 'normal_call',
                'call_started_at' => now()
            ]);

            // Store ID in cache to update later
            Cache::put('fraud_detection_id', $fraud->id, now()->addMinute());
    
            return response()->json([
                'status' => true,
                'msg' => $qrCode->owner->mobile_number . ' mobile number stored',
                'virtual_no' => env('MSG91_CALLER_ID'),
            ]);
            
            $this->getOwnerMobileNo();
        }
    
        return response()->json([
            'status' => false,
            'msg' => 'mobile number not found',
        ]);
    }
    
    public function addOwnerEmegMobileNoInSession($id=null, $k=null, Request $request)
    {
        $qrCode = QrCode::with('owner')->find($id);
    
        if ($qrCode && $qrCode->owner) {
            
            $eme_mobile = $qrCode->owner->{'friend_family_'.$k};
    
            Cache::put('owner_call_number', $eme_mobile, now()->addMinute());
            
            $emeg_caller_number = '919999999999';
            
            // $emeg_caller_number = request()->emeg_caller_number;
            
            // if ($emeg_caller_number) {
    
            //     $emeg_caller_number = preg_replace('/\D/', '', $emeg_caller_number);
        
            //     if (!str_starts_with($emeg_caller_number, '91') && strlen($emeg_caller_number) == 10) {
            //         $emeg_caller_number = '91' . $emeg_caller_number;
            //     }
            // }

            // Save call initiated record
            $fraud = FraudDetection::create([
                'from_number' => $emeg_caller_number,
                'qr_code_id' => $qrCode->qr_code,
                'type' => 'emergency_call',
                'call_started_at' => now()
            ]);

            // Store ID in cache to update later
            Cache::put('fraud_detection_id', $fraud->id, now()->addMinute());
    
            return response()->json([
                'status' => true,
                'msg' => $eme_mobile . ' mobile number stored',
                'virtual_no' => env('MSG91_CALLER_ID'),
            ]);
            
            $this->getOwnerMobileNo();
        }
    
        return response()->json([
            'status' => false,
            'msg' => 'mobile number not found',
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
                    'to_number' => $ownerMobile,
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