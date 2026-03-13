<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FraudDetection;
use Illuminate\Http\Request;

class FraudDetectionController extends Controller
{
    /**
     * Display a list of fraud detections grouped by owner number.
     */
    public function index(Request $request)
    {
        $query = FraudDetection::query()
            ->leftJoin('qr_codes', 'qr_codes.qr_code', '=', 'fraud_detections.qr_code_id');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('fraud_detections.qr_code_id', 'like', "%{$search}%")
                    ->orWhere('fraud_detections.to_number', 'like', "%{$search}%");
            });
        }

        $fraudDetections = $query
            ->selectRaw('fraud_detections.qr_code_id, fraud_detections.to_number, fraud_detections.type, qr_codes.id as qr_id, qr_codes.status as qr_status, MIN(fraud_detections.call_started_at) AS initiation_time, COUNT(*) AS total_calls')
            ->groupBy('fraud_detections.qr_code_id', 'fraud_detections.to_number', 'fraud_detections.type', 'qr_codes.id', 'qr_codes.status')
            ->orderByDesc('initiation_time')
            ->paginate(25);

        return view('admin.fraud-detections.index', compact('fraudDetections'));
    }
}
