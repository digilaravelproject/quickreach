<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\QrRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserQrRegistrationController extends Controller
{
    /**
     * Show the dynamic registration form based on category
     */
    public function showRegistrationForm($qrCodeId)
    {
        $qrCode = QrCode::with('category')->findOrFail($qrCodeId);

        // Check if already registered
        $existing = QrRegistration::where('qr_code_id', $qrCodeId)->first();
        if ($existing) {
            return Auth::check()
                ? redirect()->route('user.my-qrs')->with('info', 'This QR Code is already registered.')
                : redirect()->route('qr.scan', $qrCode->qr_code)->with('info', 'This QR Code is already registered.');
        }

        $categorySlug = strtolower($qrCode->category->slug ?? $qrCode->category->name);

        // If logged-in user, pass their info to pre-fill
        $authUser = Auth::user();

        return view('user.register-qr', compact('qrCode', 'categorySlug', 'authUser'));
    }

    /**
     * Store the registration details
     */
    public function storeRegistration(Request $request, $qrCodeId)
    {
        $qrCode = QrCode::with('category')->findOrFail($qrCodeId);
        $categorySlug = strtolower($qrCode->category->slug ?? $qrCode->category->name);

        // Validation Rules
        $rules = [
            'full_name'      => 'required|string|max:255',
            'mobile_number'  => 'required|string|max:15',
            'full_address'   => 'nullable|string',
            'friend_family_1' => 'nullable|string|max:15',
            'friend_family_2' => 'nullable|string|max:15',
            'emergency_note' => 'nullable|string|max:500',
        ];

        // Email/Password only required for guests
        if (!Auth::check()) {
            $rules['email']    = 'required|email|unique:users,email';
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        // Dynamic Validation
        if (str_contains($categorySlug, 'pet')) {
            $rules['breed']  = 'nullable|string';
            $rules['age']    = 'nullable|string';
            $rules['colour'] = 'nullable|string';
            $rules['photo']  = 'nullable|image|mimes:jpeg,png,jpg|max:2048';
        } elseif (str_contains($categorySlug, 'car') || str_contains($categorySlug, 'bike')) {
            $rules['make']       = 'required|string';
            $rules['model']      = 'required|string';
            $rules['vehicle_no'] = 'required|string';
        } elseif (str_contains($categorySlug, 'child')) {
            $rules['child_name'] = 'required|string';
            $rules['child_age']  = 'required|string';
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

        // Get or Create User
        if (Auth::check()) {
            // Logged-in user — use existing user
            $user   = Auth::user();
            $userId = $user->id;
        } else {
            // Guest — create new user account
            $user = User::create([
                'name'      => $request->input('full_name'),
                'email'     => $request->input('email'),
                'password'  => Hash::make($request->input('password')),
                'phone'     => $request->input('mobile_number'),
                'is_admin'  => false,
                'is_active' => true,
            ]);
            $userId = $user->id;
        }

        // Create Registration
        QrRegistration::create([
            'qr_code_id'      => $qrCode->id,
            'user_id'         => $userId,
            'full_name'       => $request->input('full_name'),
            'mobile_number'   => $request->input('mobile_number'),
            'full_address'    => $request->input('full_address'),
            'friend_family_1' => $request->input('friend_family_1'),
            'friend_family_2' => $request->input('friend_family_2'),
            'category_data'   => $categoryData,
            'emergency_note'  => $request->input('emergency_note'),
            'photo_path'      => $photoPath,
            'is_active'       => true,
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

    /**
     * AJAX: Check if email already exists (for popup trigger)
     */
    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $exists = User::where('email', $request->input('email'))->exists();
        return response()->json(['exists' => $exists]);
    }
}
