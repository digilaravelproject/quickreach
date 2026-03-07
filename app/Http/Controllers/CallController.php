<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\QrCode;
use App\Models\CallLog;

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
}