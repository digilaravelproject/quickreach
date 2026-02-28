<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\QrRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserQrRegistrationController extends Controller
{
    /**
     * Show the dynamic registration form based on category
     */
    public function showRegistrationForm($qrCodeId)
    {
        // die('cxc');
        $qrCode = QrCode::with('category')->findOrFail($qrCodeId);

        // Check if already registered
        $existing = QrRegistration::where('qr_code_id', $qrCodeId)->first();
        if ($existing) {
            return Auth::check()
                ? redirect()->route('user.my-qrs')->with('info', 'This QR Code is already registered.')
                : redirect()->route('qr.scan', $qrCode->qr_code)->with('info', 'This QR Code is already registered.');
        }

        $categorySlug = strtolower($qrCode->category->slug ?? $qrCode->category->name);

        return view('user.register-qr', compact('qrCode', 'categorySlug'));
    }

    /**
     * Store the registration details
     */
    public function storeRegistration(Request $request, $qrCodeId)
    {
        $qrCode = QrCode::with('category')->findOrFail($qrCodeId);
        $categorySlug = strtolower($qrCode->category->slug ?? $qrCode->category->name);

        // Validation Rules (full_address added here)
        $rules = [
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'full_address' => 'nullable|string', // <-- ADDED THIS
            'friend_family_1' => 'nullable|string|max:15',
            'friend_family_2' => 'nullable|string|max:15',
            'emergency_note' => 'nullable|string|max:500',
        ];

        // Dynamic Validation
        if (str_contains($categorySlug, 'pet')) {
            $rules['breed'] = 'nullable|string';
            $rules['age'] = 'nullable|string';
            $rules['colour'] = 'nullable|string';
            $rules['photo'] = 'nullable|image|mimes:jpeg,png,jpg|max:2048';
        } elseif (str_contains($categorySlug, 'car') || str_contains($categorySlug, 'bike')) {
            $rules['make'] = 'required|string';
            $rules['model'] = 'required|string';
            $rules['vehicle_no'] = 'required|string';
        } elseif (str_contains($categorySlug, 'child')) {
            $rules['child_name'] = 'required|string';
            $rules['child_age'] = 'required|string';
        }

        $validated = $request->validate($rules);

        // File Upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('qr_photos', 'public');
        }

        // Category Data
        $categoryData = [];
        $dynamicFields = ['breed', 'age', 'colour', 'make', 'model', 'vehicle_no', 'child_name', 'child_age'];
        foreach ($dynamicFields as $field) {
            if ($request->has($field)) {
                $categoryData[$field] = $request->input($field);
            }
        }

        $userId = Auth::check() ? Auth::id() : null;

        // Create Registration (full_address saved here)
        QrRegistration::create([
            'qr_code_id' => $qrCode->id,
            'user_id' => $userId,
            'full_name' => $request->input('full_name'),
            'mobile_number' => $request->input('mobile_number'),
            'full_address' => $request->input('full_address'), // <-- FIXED HERE
            'friend_family_1' => $request->input('friend_family_1'),
            'friend_family_2' => $request->input('friend_family_2'),
            'category_data' => $categoryData,
            'emergency_note' => $request->input('emergency_note'),
            'photo_path' => $photoPath,
            'is_active' => true,
        ]);

        // Update QR Code Status
        $qrCode->update(['status' => 'registered', 'user_id' => $userId]);

        // Redirect appropriately
        if (Auth::check()) {
            return redirect()->route('user.my-qrs')->with('success', 'QR Tag registered successfully!');
        } else {
            return redirect()->route('qr.register-success', ['qrCode' => $qrCode->id]);
        }
    }

    public function success($qrCodeId)
    {
        $qrCode = QrCode::with('category')->findOrFail($qrCodeId);
        return view('scanner.register-success', compact('qrCode'));
    }
}
