<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emergency;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Emergency::query();
            if ($request->search) {
                $query->where('title', 'like', '%' . $request->search . '%');
            }
            return response()->json($query->orderBy('sort_order', 'asc')->paginate(15));
        }
        return view('admin.emergencies.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable', // CKEditor ka HTML content yahan aayega
        ]);

        Emergency::create($data); // Data database mein save ho jayega
        return back()->with('success', 'Emergency Content Added!');
    }

    public function update(Request $request, Emergency $emergency)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable',
        ]);

        $emergency->update($data); // Purana data update ho jayega
        return back()->with('success', 'Emergency Content Updated!');
    }

    public function destroy(Emergency $emergency)
    {
        $emergency->delete();
        return back()->with('success', 'Deleted successfully!');
    }
}
