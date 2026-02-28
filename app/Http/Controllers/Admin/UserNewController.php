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

            if ($request->search) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'LIKE', "%{$request->search}%")
                        ->orWhere('email', 'LIKE', "%{$request->search}%")
                        ->orWhere('phone', 'LIKE', "%{$request->search}%");
                });
            }

            $users = $query->latest()->paginate(10);
            return response()->json($users);
        }

        return view('admin.users.index');
    }

    // Toggle Status Method
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'success' => true,
            'is_active' => $user->is_active,
            'message' => 'Status updated successfully'
        ]);
    }

    public function export(Request $request)
    {
        $query = User::withCount('orders');

        // Checkbox IDs Filter
        if ($request->filled('ids')) {
            $ids = explode(',', $request->ids);
            $query->whereIn('id', $ids);
        }

        // Same search filter as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->latest()->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users_' . now()->format('Ymd_His') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($users) {
            $handle = fopen('php://output', 'w');

            // Column headings
            fputcsv($handle, [
                'ID',
                'Name',
                'Email',
                'Phone',
                'Status', // Added Status Column
                'Total Orders',
                'Joined Date',
            ]);

            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone ?? '',
                    $user->is_active ? 'Active' : 'Inactive', // Status output
                    $user->orders_count,
                    $user->created_at?->format('d M Y, H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function show($id)
    {
        $user = User::withCount('orders')->with([
            'orders.items.category',
            'orders.qrCodes'
        ])->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function generateCard($id)
    {
        $qr = QrCode::with('category')->findOrFail($id);

        $category = strtolower($qr->category->name ?? 'default');

        $imagePath = ltrim(str_replace('storage/', '', $qr->qr_image_path), '/');
        $fullPath = storage_path('app/public/' . $imagePath);

        $base64 = null;
        $isSvg = false;

        if (file_exists($fullPath)) {
            $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            $data = file_get_contents($fullPath);

            if ($extension === 'svg') {
                $isSvg = true;
                $base64 = base64_encode($data);
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

        $cleanPath = trim($qr->qr_image_path);
        $qrPath = public_path($cleanPath);
        $categoryName = strtolower($qr->category->name ?? 'default');

        $templateName = match ($categoryName) {
            'car' => 'car_template.png',
            'bike' => 'bike_template.png',
            'children', 'kids' => 'children_template.png',
            default => 'qwickreach_bg.png',
        };

        $templatePath = public_path("assets/templates/{$templateName}");

        if (!file_exists($qrPath)) {
            \Log::error("QR File Missing even after trim: [" . $qrPath . "]");
            return back()->with('error', "Bhai, QR file server par nahi mili.");
        }

        try {
            $img = Image::make($templatePath);
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
