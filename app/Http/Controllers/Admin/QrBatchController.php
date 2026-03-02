<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\QrBatch;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class QrBatchController extends Controller
{
    /**
     * Batches ki list — AJAX support ke saath (Alpine.js)
     */
    public function index(Request $request)
    {
        $query = QrBatch::with(['category'])
            ->withCount([
                'qrCodes',
                'qrCodes as available_count' => fn($q) => $q->where('status', 'available'),
                'qrCodes as assigned_count'  => fn($q) => $q->where('status', 'assigned'),
                'qrCodes as registered_count' => fn($q) => $q->where('status', 'registered'),
            ]);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->where('batch_code', 'like', '%' . $request->search . '%');
        }

        $batches = $query->latest()->paginate(15);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($batches);
        }

        $categories = Category::active()->ordered()->get();

        return view('admin.qr-batches.index', compact('categories'));
    }

    /**
     * Ek batch ke andar ke saare QR codes dikhao (AJAX support)
     */
    public function show(Request $request, QrBatch $qrBatch)
    {
        $qrBatch->load('category');

        $query = QrCode::with(['category', 'registration'])
            ->where('qr_batch_id', $qrBatch->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('qr_code', 'like', '%' . $request->search . '%');
        }

        $qrCodes = $query->latest()->paginate(10);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($qrCodes);
        }

        return view('admin.qr-batches.show', compact('qrBatch'));
    }

    /**
     * Ek batch ke saare QR codes ZIP mein download karo
     */
    public function download(QrBatch $qrBatch)
    {
        $qrCodes = $qrBatch->qrCodes;

        if ($qrCodes->isEmpty()) {
            return redirect()->back()->with('error', 'Is batch mein koi QR codes nahi hain.');
        }

        $tempDir = storage_path('app/temp/qr_exports');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zipFileName = $qrBatch->batch_code . '_' . time() . '.zip';
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

        return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
    }

    /**
     * Batch delete (sirf tab jab saare QR codes available hon)
     */
    public function destroy(QrBatch $qrBatch)
    {
        // Check: koi assigned/registered QR toh nahi?
        $blockedCount = $qrBatch->qrCodes()
            ->whereIn('status', ['assigned', 'registered'])
            ->count();

        if ($blockedCount > 0) {
            $message = "Ye batch delete nahi ho sakta. {$blockedCount} QR code(s) assigned ya registered hain.";

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => $message], 422);
            }

            return redirect()->back()->with('error', $message);
        }

        // Saare QR images delete karo
        foreach ($qrBatch->qrCodes as $qrCode) {
            if ($qrCode->qr_image_path) {
                Storage::disk('public')->delete($qrCode->qr_image_path);
            }
            $qrCode->delete();
        }

        $qrBatch->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => 'Batch successfully deleted!']);
        }

        return redirect()->route('admin.qr-batches.index')
            ->with('success', 'Batch aur uske saare QR codes delete ho gaye!');
    }
}
