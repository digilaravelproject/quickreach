<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HowItWork; // Model name as per your migration
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HowItWorksController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = HowItWork::query();

            // Search Filter Logic
            if ($request->search) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('step_order', 'like', '%' . $request->search . '%');
            }

            return response()->json($query->orderBy('step_order', 'asc')->paginate(10));
        }
        return view('admin.how-it-works.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'step_order' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('steps', 'public');
        }

        HowItWork::create($data);
        return back()->with('success', 'Step added successfully!');
    }

    public function update(Request $request, $id)
    {
        $step = HowItWork::findOrFail($id);
        $data = $request->validate([
            'step_order' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            if ($step->image_path) {
                Storage::disk('public')->delete($step->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('steps', 'public');
        }

        $step->update($data);
        return back()->with('success', 'Step updated successfully!');
    }

    public function destroy($id)
    {
        $step = HowItWork::findOrFail($id);
        if ($step->image_path) {
            Storage::disk('public')->delete($step->image_path);
        }
        $step->delete();
        return response()->json(['success' => true]);
    }
}
