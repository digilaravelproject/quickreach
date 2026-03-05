<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UseCaseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = UseCase::query();
            if ($request->search) {
                $query->where('title', 'like', '%' . $request->search . '%');
            }
            return response()->json($query->orderBy('id', 'desc')->paginate(10));
        }
        return view('admin.use-cases.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($request->hasFile('icon_image')) {
            $data['icon_image'] = $request->file('icon_image')->store('use-cases', 'public');
        }

        UseCase::create($data);
        return back()->with('success', 'Use Case added successfully!');
    }

    public function update(Request $request, UseCase $useCase)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($request->hasFile('icon_image')) {
            // Purani image delete karein
            if ($useCase->icon_image) {
                Storage::disk('public')->delete($useCase->icon_image);
            }
            $data['icon_image'] = $request->file('icon_image')->store('use-cases', 'public');
        }

        $useCase->update($data);
        return back()->with('success', 'Use Case updated successfully!');
    }

    public function destroy(UseCase $useCase)
    {
        if ($useCase->icon_image) {
            Storage::disk('public')->delete($useCase->icon_image);
        }
        $useCase->delete();

        // Agar AJAX se delete kar rahe hain toh JSON, warna Redirect
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Use Case deleted!');
    }
}
