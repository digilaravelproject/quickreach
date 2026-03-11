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
        if (!in_array($qrCode->status, ['available', 'inactive'])) {
            $message = 'Sirf available ya inactive QR code ka status toggle ho sakta hai.';

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => $message], 422);
            }

            return redirect()->back()->with('error', $message);
        }

        $qrCode->status = $qrCode->status === 'inactive' ? 'available' : 'inactive';
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
     * 2×3 grid HTML file download — 6 cards per A4 Portrait page.
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
     * Single card HTML snippet — A4 portrait 2×3 grid ke liye size tune kiya
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
  <div class="blob blob-blue"></div>
  <div class="blob blob-purple"></div>
  <div class="blob blob-pink"></div>

  <div class="brand">Qwick<span class="reach">Reach</span></div>
  <div class="tagline">SCAN · CALL · CONNECT</div>

  <div class="qr-outer">
    <div class="qr-glow-ring"></div>
    <div class="qr-wrapper">' . $imgTag . '</div>
    <div class="qr-corner"></div>
  </div>

  <div class="scan-btn">
    <div class="scan-label">SCAN TO</div>
    <div class="contact-text">CONTACT OWNER</div>
    <div class="qr-code-text">' . $code . '</div>
  </div>

  <div class="features">
    <div class="fi">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502
             1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0
             011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1
             C9.716 21 3 14.284 3 6V5z"/>
      </svg>
      <span>No App Needed</span>
    </div>
    <div class="fd"></div>
    <div class="fi">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955
             11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29
             9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
      </svg>
      <span>100% Secure</span>
    </div>
    <div class="fd"></div>
    <div class="fi">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542
             7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
      </svg>
      <span>Private &amp; Safe</span>
    </div>
  </div>
</div>';
    }

    /**
     * 2×3 grid wala full HTML.
     * A4 Portrait — 6 cards per page, auto page-break.
     */
    private function buildGridHtml(array $cards, string $batchCode): string
    {
        $totalCards = count($cards);
        $batchSafe  = htmlspecialchars($batchCode);

        // 6 cards per page
        $chunks    = array_chunk($cards, 6);
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

  /* ===== A4 PORTRAIT PAGE ===== */
  /*
     A4 = 210mm × 297mm
     Usable (minus 10mm margin each side) = 190mm × 277mm
     2 cols × 3 rows grid
  */
  .page {
    background: white;
    width: 210mm;
    min-height: 297mm;
    margin: 0 auto 28px auto;
    padding: 10mm;
    border-radius: 8px;
    box-shadow: 0 6px 28px rgba(0,0,0,0.12);
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: repeat(3, 1fr);
    gap: 8mm;
  }

  /* ===== CARD ===== */
  .card {
    border-radius: 20px;
    position: relative;
    overflow: hidden;
    padding: 18px 16px 14px;
    background: linear-gradient(145deg, #f0f0ff 0%, #e8e4ff 40%, #f5f0ff 70%, #ffffff 100%);
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 6px 20px rgba(100,80,200,0.18);
  }

  /* ---- blobs ---- */
  .blob { position:absolute; border-radius:50%; filter:blur(28px); opacity:0.5; pointer-events:none; }
  .blob-blue   { width:90px; height:90px; background:radial-gradient(circle,#7b9fff,#4f6ef7); top:55%; left:-22px; }
  .blob-purple { width:80px; height:80px; background:radial-gradient(circle,#c084fc,#9333ea); top:50%; right:-18px; }
  .blob-pink   { width:70px; height:70px; background:radial-gradient(circle,#f9a8d4,#ec4899); bottom:36px; left:50%; transform:translateX(-50%); opacity:0.25; }

  /* ---- brand ---- */
  .brand   { font-size:22px; font-weight:900; color:#1a1a2e; letter-spacing:-0.5px; position:relative; z-index:2; line-height:1; }
  .reach   { color:#7c3aed; }
  .tagline { font-size:7px; font-weight:700; letter-spacing:3px; color:#8888aa; margin-bottom:10px; position:relative; z-index:2; }

  /* ---- QR ---- */
  .qr-outer    { position:relative; display:inline-block; z-index:2; margin-bottom:10px; }
  .qr-glow-ring {
    position:absolute; inset:-5px; border-radius:16px;
    background:linear-gradient(135deg,#60a5fa,#818cf8,#a855f7,#ec4899);
    opacity:0.8; filter:blur(5px); z-index:-1;
  }
  .qr-wrapper  {
    background:#fff; padding:10px; border-radius:14px;
    display:inline-flex; align-items:center; justify-content:center;
    border:1.5px solid rgba(139,92,246,0.25);
  }
  .qr-wrapper img { width:110px; height:110px; display:block; }
  .no-qr       { font-size:9px; color:red; }
  .qr-corner   {
    position:absolute; bottom:-6px; right:-6px;
    width:16px; height:16px;
    border-right:2.5px solid #7c3aed; border-bottom:2.5px solid #7c3aed;
    border-radius:0 0 4px 0;
  }

  /* ---- scan btn ---- */
  .scan-btn {
    position:relative; z-index:2; width:100%; margin-bottom:10px;
    background:linear-gradient(90deg,#2d1b6e 0%,#4c1d95 40%,#7c2d9e 75%,#9333ea 100%);
    border-radius:50px; padding:8px 12px 9px; color:white;
  }
  .scan-label {
    font-size:6.5px; font-weight:700; letter-spacing:2.5px; color:rgba(255,255,255,0.7);
    display:flex; align-items:center; justify-content:center; gap:6px; margin-bottom:2px;
  }
  .scan-label::before, .scan-label::after { content:""; flex:1; height:0.5px; background:rgba(255,255,255,0.3); }
  .contact-text { font-size:14px; font-weight:900; color:#fff; letter-spacing:1px; }
  .qr-code-text { font-size:7.5px; font-weight:700; color:rgba(255,255,255,0.65); letter-spacing:2px; margin-top:3px; text-align:center; }

  /* ---- features ---- */
  .features {
    position:relative; z-index:2; width:100%;
    display:flex; justify-content:space-around; align-items:center;
    padding-top:6px; border-top:1px solid rgba(120,100,200,0.15);
  }
  .fi  { display:flex; flex-direction:column; align-items:center; gap:2px; font-size:7px; font-weight:700; color:#666688; line-height:1.3; }
  .fi svg { width:13px; height:13px; color:#7c3aed; }
  .fd  { width:1px; height:22px; background:rgba(120,100,200,0.2); }

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
      padding: 10mm;
      box-shadow: none;
      border-radius: 0;
      gap: 7mm;
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
    <p>Total ' . $totalCards . ' QR Cards &nbsp;·&nbsp; 2×3 Grid &nbsp;·&nbsp; 6 cards per A4 Portrait page</p>
  </div>
  <button class="btn-print" onclick="window.print()">🖨️ Print / Save as PDF</button>
</div>

' . $pagesHtml . '

</body>
</html>';
    }
}
