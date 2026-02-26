<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\QrCode;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class QrCodeController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }


    /**
     * Display listing of QR codes (Supports AJAX for Alpine.js)
     */
    public function index(Request $request)
    {
        $query = QrCode::with(['category', 'registration']);

        // Filters
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('qr_code', 'like', '%' . $request->search . '%');
        }

        $qrCodes = $query->latest()->paginate(10);

        // AJAX response for Alpine.js table load
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($qrCodes);
        }

        $categories = Category::active()->ordered()->get();
        return view('admin.qr-codes.index', compact('categories'));
    }

    /**
     * Show form to generate bulk QR codes
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.qr-codes.create', compact('categories'));
    }

    /**
     * Generate bulk QR codes
     */
    public function store(Request $request)
    {

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'quantity'    => 'required|integer|min:1|max:1000',
        ]);

        try {
            $qrCodes = $this->qrCodeService->generateBulkQrCodes(
                $request->category_id,
                $request->quantity
            );

            return redirect()
                ->route('admin.qr-codes.index')
                ->with('success', count($qrCodes) . ' QR codes generated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to generate QR codes: ' . $e->getMessage());
        }
    }

    /**
     * Show single QR code details
     */
    /**
     * Show single QR code details
     */
    public function show(QrCode $qrCode)
    {
        // Load relations - user relation hata diya kyunki wo admin hai
        $qrCode->load([
            'category',
            'registration', // Sirf registration chahiye
            'scans'
        ])->loadCount('scans');

        return view('admin.qr-codes.show', compact('qrCode'));
    }

    /**
     * Update QR code status
     */
    public function updateStatus(Request $request, QrCode $qrCode)
    {
        $request->validate([
            'status' => 'required|in:available,assigned,registered,inactive'
        ]);

        $qrCode->update(['status' => $request->status]);

        return redirect()
            ->back()
            ->with('success', 'QR code status updated successfully!');
    }

    /**
     * Download QR codes as ZIP
     */
    public function downloadBulk(Request $request)
    {
        $request->validate([
            'qr_code_ids'   => 'required|array',
            'qr_code_ids.*' => 'exists:qr_codes,id'
        ]);

        $qrCodes = QrCode::whereIn('id', $request->qr_code_ids)->get();

        $tempDir = storage_path('app/temp/qr_exports');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zipFileName = 'qr_codes_' . time() . '.zip';
        $zipFilePath = $tempDir . '/' . $zipFileName;

        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            foreach ($qrCodes as $qrCode) {
                if ($qrCode->qr_image_path && Storage::disk('public')->exists($qrCode->qr_image_path)) {
                    $imagePath = Storage::disk('public')->path($qrCode->qr_image_path);
                    $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                    $zip->addFile($imagePath, $qrCode->qr_code . '.' . $extension);
                }
            }
            $zip->close();
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    /**
     * Export QR codes as CSV
     */
    public function exportCsv(Request $request)
    {
        $query = QrCode::with(['category', 'user']);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $qrCodes = $query->get();
        $filename = 'qr_codes_' . time() . '.csv';

        return response()->streamDownload(function () use ($qrCodes) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['QR Code', 'Category', 'Status', 'User Name', 'User Email', 'Assigned At', 'Registered At', 'Created At']);

            foreach ($qrCodes as $qrCode) {
                fputcsv($handle, [
                    $qrCode->qr_code,
                    $qrCode->category->name ?? 'N/A',
                    $qrCode->status,
                    $qrCode->user->name ?? 'N/A',
                    $qrCode->user->email ?? 'N/A',
                    $qrCode->assigned_at?->format('Y-m-d H:i:s') ?? 'N/A',
                    $qrCode->registered_at?->format('Y-m-d H:i:s') ?? 'N/A',
                    $qrCode->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    /**
     * Delete Single QR code (AJAX friendly)
     */
    public function destroy(QrCode $qrCode)
    {
        if ($qrCode->status !== 'available') {
            return response()->json(['error' => 'Only available QR codes can be deleted!'], 422);
        }

        if ($qrCode->qr_image_path) {
            Storage::disk('public')->delete($qrCode->qr_image_path);
        }

        $qrCode->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => 'QR Code deleted successfully']);
        }

        return redirect()->route('admin.qr-codes.index')->with('success', 'QR code deleted successfully!');
    }

    /**
     * Bulk delete QR codes (AJAX friendly)
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'qr_code_ids'   => 'required|array',
            'qr_code_ids.*' => 'exists:qr_codes,id'
        ]);

        $qrCodes = QrCode::whereIn('id', $request->qr_code_ids)
            ->where('status', 'available')
            ->get();

        $count = 0;
        foreach ($qrCodes as $qrCode) {
            if ($qrCode->qr_image_path) {
                Storage::disk('public')->delete($qrCode->qr_image_path);
            }
            $qrCode->delete();
            $count++;
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => $count . ' QR codes deleted successfully!']);
        }

        return redirect()->back()->with('success', $count . ' QR codes deleted successfully!');
    }
}
