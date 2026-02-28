<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrRegistration;
use Illuminate\Http\Request;

class QrRegistrationController extends Controller
{
    public function index(Request $request)
    {
        // 🌟 YAHAN UPDATE KIYA HAI: 'qrCode.category' add kiya hai taaki JS table ko category ka data mil sake
        $query = QrRegistration::with(['qrCode.category', 'user']);

        // Search logic
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('mobile_number', 'like', "%{$search}%")
                    ->orWhereHas('qrCode', fn($qr) => $qr->where('qr_code', 'like', "%{$search}%"));
            });
        }

        $registrations = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return response()->json($registrations);
        }

        return view('admin.registrations.index');
    }

    public function export(Request $request)
    {
        $query = QrRegistration::with(['qrCode.category']);

        // Same search logic as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('mobile_number', 'like', "%{$search}%")
                    ->orWhereHas('qrCode', fn($qr) => $qr->where('qr_code', 'like', "%{$search}%"));
            });
        }

        $registrations = $query->latest()->get();

        // CSV headers
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="registrations_' . now()->format('Ymd_His') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($registrations) {
            $handle = fopen('php://output', 'w');

            // Column headings (Added Emergency Note and Category Data)
            fputcsv($handle, [
                'ID',
                'Full Name',
                'Mobile Number',
                'QR Code',
                'QR Category',
                'Friend / Family 1',
                'Friend / Family 2',
                'Full Address',
                'Emergency Note',
                'Category Data',
                'Status',
                'Registered At',
            ]);

            foreach ($registrations as $reg) {
                // Category JSON data ko string me convert karna CSV ke liye
                $catData = '';
                if (!empty($reg->category_data)) {
                    $parts = [];
                    foreach ($reg->category_data as $k => $v) {
                        $parts[] = ucfirst(str_replace('_', ' ', $k)) . ': ' . $v;
                    }
                    $catData = implode(' | ', $parts);
                }

                fputcsv($handle, [
                    $reg->id,
                    $reg->full_name,
                    $reg->mobile_number,
                    $reg->qrCode->qr_code   ?? 'DELETED',
                    $reg->qrCode->category->name ?? '',
                    $reg->friend_family_1   ?? '',
                    $reg->friend_family_2   ?? '',
                    $reg->full_address      ?? '',
                    $reg->emergency_note    ?? '',
                    $catData,
                    $reg->is_active ? 'Active' : 'Disabled',
                    $reg->created_at?->format('d M Y, H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function edit(QrRegistration $registration)
    {
        return view('admin.registrations.edit', compact('registration'));
    }

    public function update(Request $request, QrRegistration $registration)
    {
        // Naye fields ka validation
        $request->validate([
            'full_name'       => 'required|string|max:255',
            'mobile_number'   => 'required|string|max:15',
            'friend_family_1' => 'nullable|string|max:15',
            'friend_family_2' => 'nullable|string|max:15',
            'full_address'    => 'nullable|string',
            'emergency_note'  => 'nullable|string|max:500',
            'is_active'       => 'boolean'
        ]);

        $registration->update($request->all());

        return redirect()->route('admin.registrations.index')->with('success', 'Registration updated successfully!');
    }

    public function destroy(QrRegistration $registration)
    {
        $registration->delete();
        return response()->json(['success' => true]);
    }
}
