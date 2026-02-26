<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UserNewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();

            // Filter logic
            if ($request->search) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'LIKE', "%{$request->search}%")
                        ->orWhere('email', 'LIKE', "%{$request->search}%")
                        ->orWhere('phone', 'LIKE', "%{$request->search}%");
                });
            }

            // Sirf regular users dikhane ke liye (agar admin role filter karna ho)
            $users = $query->latest()->paginate(10);
            return response()->json($users);
        }

        return view('admin.users.index');
    }
    public function show($id)
    {
        $user = User::withCount('orders')->with([
            'orders.items.category', // Kis category ke kitne items hain
            'orders.qrCodes'         // Download ke liye QR codes
        ])->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function generateCard($id)
    {
        $qr = QrCode::with('category')->findOrFail($id);

        $category = strtolower($qr->category->name ?? 'default');

        // Remove 'storage/' prefix if already present
        $imagePath = ltrim(str_replace('storage/', '', $qr->qr_image_path), '/');

        $fullPath = storage_path('app/public/' . $imagePath);

        $base64 = null;
        $isSvg = false;

        if (file_exists($fullPath)) {
            $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            $data = file_get_contents($fullPath);

            if ($extension === 'svg') {
                $isSvg = true;
                $base64 = base64_encode($data); // raw base64, we'll embed inline
            } else {
                $mimeMap = [
                    'png'  => 'image/png',
                    'jpg'  => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'gif'  => 'image/gif',
                    'webp' => 'image/webp',
                ];
                $mime = $mimeMap[$extension] ?? 'image/' . $extension;
                $base64 = 'data:' . $mime . ';base64,' . base64_encode($data);
            }
        } else {
            abort(404, 'QR Image Not Found: ' . $fullPath);
        }

        return view('admin.qr.card_template', compact('qr', 'category', 'base64', 'isSvg'));
    }

    public function downloadCard($id)
    {
        $qr = QrCode::with('category')->findOrFail($id);

        // 1. TRIM use karein space hatane ke liye
        $cleanPath = trim($qr->qr_image_path);

        $qrPath = public_path($cleanPath);
        $categoryName = strtolower($qr->category->name ?? 'default');

        // Background Template Selection
        $templateName = match ($categoryName) {
            'car' => 'car_template.png',
            'bike' => 'bike_template.png',
            'children', 'kids' => 'children_template.png',
            default => 'qwickreach_bg.png',
        };

        $templatePath = public_path("assets/templates/{$templateName}");

        // 2. Logging for Debugging
        if (!file_exists($qrPath)) {
            \Log::error("QR File Missing even after trim: [" . $qrPath . "]"); // Brackets se space dikh jayega
            return back()->with('error', "Bhai, QR file server par nahi mili.");
        }

        try {
            $img = Image::make($templatePath);

            // SVG handling
            $qrRaw = file_get_contents($qrPath);
            $qrCode = Image::make($qrRaw)->resize(540, 540);

            $img->insert($qrCode, 'center', 0, -65);

            return $img->encode('png')->download("QwickReach_" . trim($qr->qr_code) . ".png");
        } catch (\Exception $e) {
            \Log::error("Download Error: " . $e->getMessage());
            return response()->download($qrPath, trim($qr->qr_code) . ".svg");
        }
    }
}
