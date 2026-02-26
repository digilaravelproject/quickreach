<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrRegistration;
use Illuminate\Http\Request;

class QrRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = QrRegistration::with(['qrCode', 'user']);

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

    public function edit(QrRegistration $registration)
    {
        return view('admin.registrations.edit', compact('registration'));
    }

    public function update(Request $request, QrRegistration $registration)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'is_active' => 'boolean'
        ]);

        $registration->update($request->all());

        return redirect()->route('admin.registrations.index')->with('success', 'User updated successfully!');
    }

    public function destroy(QrRegistration $registration)
    {
        $registration->delete();
        return response()->json(['success' => true]);
    }
}
