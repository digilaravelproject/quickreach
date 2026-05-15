<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\QrBatch;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                'qrCodes as available_count'   => fn($q) => $q->where('status', 'available'),
                'qrCodes as assigned_count'    => fn($q) => $q->where('status', 'assigned'),
                'qrCodes as registered_count'  => fn($q) => $q->where('status', 'registered'),
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
     * Toggle QR code status between available ↔ inactive
     * Sirf available aur inactive QR codes pe kaam karta hai
     */
    public function toggleInactive(QrCode $qrCode)
    {
        if (!in_array($qrCode->status, ['registered', 'inactive'])) {
            $message = 'Sirf available ya inactive QR code ka status toggle ho sakta hai.';

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => $message], 422);
            }

            return redirect()->back()->with('error', $message);
        }

        $qrCode->status = $qrCode->status === 'inactive' ? 'registered' : 'inactive';
        $qrCode->save();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => 'Status updated!',
                'status'  => $qrCode->status,
            ]);
        }

        return redirect()->back()->with('success', 'QR code status update ho gaya!');
    }

    /**
     * 4×4 grid HTML file download — 16 cards per A4 Portrait page.
     * Browser mein open → Ctrl+P → Save as PDF
     */
    public function download(QrBatch $qrBatch)
    {
        $qrCodes = $qrBatch->qrCodes;

        if ($qrCodes->isEmpty()) {
            return redirect()->back()->with('error', 'Is batch mein koi QR codes nahi hain.');
        }

        // Har QR code ke liye data prepare karo
        $cards = [];
        foreach ($qrCodes as $qrCode) {
            $base64    = null;
            $isSvg     = false;
            $imagePath = ltrim(str_replace('storage/', '', $qrCode->qr_image_path ?? ''), '/');
            $fullPath  = storage_path('app/public/' . $imagePath);

            if (!empty($qrCode->qr_image_path) && file_exists($fullPath)) {
                $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                $data      = file_get_contents($fullPath);

                if ($extension === 'svg') {
                    $isSvg  = true;
                    $base64 = base64_encode($data);
                } else {
                    $mimeMap = [
                        'png'  => 'image/png',
                        'jpg'  => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'gif'  => 'image/gif',
                        'webp' => 'image/webp',
                    ];
                    $mime   = $mimeMap[$extension] ?? 'image/' . $extension;
                    $base64 = 'data:' . $mime . ';base64,' . base64_encode($data);
                }
            }

            $cards[] = [
                'base64' => $base64,
                'isSvg'  => $isSvg,
                'code'   => $qrCode->qr_code ?? 'QR-' . $qrCode->id,
            ];
        }

        $html     = $this->buildGridHtml($cards, $qrBatch->batch_code);
        $fileName = $qrBatch->batch_code . '_cards_' . time() . '.html';

        return response($html, 200, [
            'Content-Type'        => 'text/html; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    /**
     * Single card view (existing generateCard route ke liye)
     */
    public function generateCard($id)
    {
        $qr = QrCode::with('category')->findOrFail($id);

        $category  = strtolower($qr->category->name ?? 'default');
        $imagePath = ltrim(str_replace('storage/', '', $qr->qr_image_path), '/');
        $fullPath  = storage_path('app/public/' . $imagePath);

        $base64 = null;
        $isSvg  = false;

        if (file_exists($fullPath)) {
            $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            $data      = file_get_contents($fullPath);

            if ($extension === 'svg') {
                $isSvg  = true;
                $base64 = base64_encode($data);
            } else {
                $mimeMap = [
                    'png'  => 'image/png',
                    'jpg'  => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'gif'  => 'image/gif',
                    'webp' => 'image/webp',
                ];
                $mime   = $mimeMap[$extension] ?? 'image/' . $extension;
                $base64 = 'data:' . $mime . ';base64,' . base64_encode($data);
            }
        } else {
            abort(404, 'QR Image Not Found: ' . $fullPath);
        }

        return view('admin.qr.card_template', compact('qr', 'category', 'base64', 'isSvg'));
    }

    /**
     * Batch delete (sirf tab jab saare QR codes available hon)
     */
    public function destroy(QrBatch $qrBatch)
    {
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

    // =========================================================
    //  PRIVATE HELPERS
    // =========================================================

    /**
     * Minimal card — sirf QR image + QR code number.
     * 4×4 grid (16 per A4 Portrait page) ke liye size tune kiya.
     *
     * Card usable area  : ~43mm wide × ~62mm tall
     * QR image          : 38mm × 38mm
     * Code label below  : ~8mm
     * Padding (1.5mm)   : baaki space
     */
    private function buildCardSnippet(array $card): string
    {
        $base64 = $card['base64'];
        $isSvg  = $card['isSvg'];
        $code   = htmlspecialchars($card['code']);

        if ($isSvg && $base64) {
            $imgTag = '<img src="data:image/svg+xml;base64,' . $base64 . '" alt="QR">';
        } elseif ($base64) {
            $imgTag = '<img src="' . $base64 . '" alt="QR">';
        } else {
            $imgTag = '<span class="no-qr">QR Not Found</span>';
        }

        return '
<div class="card">
  <div class="qr-wrapper">' . $imgTag . '</div>
  <div class="qr-code-text">' . $code . '</div>
</div>';
    }

    /**
     * 4×4 grid wala full HTML.
     * A4 Portrait — 16 cards per page, auto page-break.
     *
     * Layout math (1.5mm gap):
     *   Usable width  = 210mm − 2×8mm padding       = 194mm
     *   Col width     = (194mm − 3×1.5mm) / 4        ≈ 47.4mm
     *   Usable height = 297mm − 2×8mm padding        = 281mm
     *   Row height    = (281mm − 3×1.5mm) / 4        ≈ 68.9mm
     *   QR img        = 38mm × 38mm  (fits comfortably)
     */
    private function buildGridHtml(array $cards, string $batchCode): string
    {
        $totalCards = count($cards);
        $batchSafe  = htmlspecialchars($batchCode);

        // 16 cards per page (4 cols × 4 rows)
        $chunks    = array_chunk($cards, 16);
        $pagesHtml = '';

        foreach ($chunks as $chunk) {
            $pagesHtml .= '<div class="page">';
            foreach ($chunk as $card) {
                $pagesHtml .= $this->buildCardSnippet($card);
            }
            $pagesHtml .= '</div>';
        }

        return '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>QR Cards — ' . $batchSafe . ' (' . $totalCards . ' cards)</title>
<style>
  *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

  body {
    background: #e5e7eb;
    font-family: "Segoe UI", Arial, sans-serif;
    padding: 24px;
  }

  /* ===== TOP BAR (screen only) ===== */
  .topbar {
    background: linear-gradient(90deg, #4c1d95, #7c3aed);
    color: white;
    padding: 16px 28px;
    border-radius: 14px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 8px 24px rgba(124,58,237,0.35);
  }
  .topbar h1  { font-size:18px; font-weight:800; }
  .topbar p   { font-size:12px; opacity:0.75; margin-top:3px; }
  .btn-print  {
    background: white; color: #7c3aed;
    padding: 11px 28px; border-radius: 50px; cursor: pointer;
    font-weight: 800; border: none; font-size:13px;
    letter-spacing:1px; text-transform:uppercase;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    white-space: nowrap;
  }
  .btn-print:hover { background:#f3e8ff; }

  /* ===== A4 PORTRAIT PAGE — 4×4 grid ===== */
  /*
     A4            = 210mm × 297mm
     Padding       = 8mm each side
     Usable        = 194mm × 281mm
     Gap           = 1.5mm
     Col width     = (194 - 3×1.5) / 4  ≈ 47.4mm
     Row height    = (281 - 3×1.5) / 4  ≈ 68.9mm
  */
  .page {
    background: white;
    width: 210mm;
    min-height: 297mm;
    margin: 0 auto 28px auto;
    padding: 8mm;
    border-radius: 8px;
    box-shadow: 0 6px 28px rgba(0,0,0,0.12);
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: repeat(4, 1fr);
    gap: 1.5mm;
  }

  /* ===== CARD — minimal: QR image + code number ===== */
  .card {
    border: 1px solid #d1d5db;
    border-radius: 6px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2mm 1.5mm 2mm;
    background: #ffffff;
    gap: 0.5mm;
  }

  /* ---- QR image ---- */
  .qr-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38mm;
    height: 38mm;
    flex-shrink: 0;
  }
  .qr-wrapper img {
    width: 38mm;
    height: 38mm;
    display: block;
  }
  .no-qr { font-size:7px; color:red; text-align:center; }

  /* ---- QR code number ---- */
  .qr-code-text {
    font-size: 7.5px;
    font-weight: 700;
    color: #374151;
    letter-spacing: 0.8px;
    text-align: center;
    word-break: break-all;
    line-height: 1.3;
  }

  /* ===== PRINT ===== */
  @media print {
    @page {
      size: A4 portrait;
      margin: 0;
    }

    body { background:white; padding:0; }

    .topbar { display:none !important; }

    .page {
      width: 210mm;
      height: 297mm;
      min-height: unset;
      margin: 0;
      padding: 8mm;
      box-shadow: none;
      border-radius: 0;
      gap: 1.5mm;
      page-break-after: always;
      break-after: page;
    }
    .page:last-child {
      page-break-after: avoid;
      break-after: avoid;
    }

    .card {
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
  }
</style>
</head>
<body>

<div class="topbar">
  <div>
    <h1>📦 ' . $batchSafe . '</h1>
    <p>Total ' . $totalCards . ' QR Cards &nbsp;·&nbsp; 4×4 Grid &nbsp;·&nbsp; 16 cards per A4 Portrait page</p>
  </div>
  <button class="btn-print" onclick="window.print()">🖨️ Print / Save as PDF</button>
</div>

' . $pagesHtml . '

</body>
</html>';
    }
}