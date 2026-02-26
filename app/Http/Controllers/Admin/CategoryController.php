<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    // App\Http\Controllers\Admin\CategoryController.php

    public function index(Request $request)
    {
        $query = Category::withCount('qrCodes');

        // Search Filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Status Filter
        if ($request->filled('status')) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $status);
        }

        $categories = $query->orderBy('sort_order', 'asc')->paginate(20);

        // Agar AJAX request hai toh JSON bhejo
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($categories);
        }

        return view('admin.categories.index');
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'price' => 'required|numeric|min:0',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // 2MB Max
        ]);

        $iconPath = null;
        if ($request->hasFile('icon')) {
            // Unique name generate karke storage mein save karein
            $fileName = time() . '_' . $request->name . '.' . $request->icon->extension();
            $request->icon->move(public_path('uploads/categories'), $fileName);
            $iconPath = 'uploads/categories/' . $fileName;
        }

        Category::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'icon' => $iconPath, // Path save hoga database mein
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }



    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'price' => 'required|numeric|min:0',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? $category->sort_order,
        ];

        if ($request->hasFile('icon')) {
            // Purani image delete karein agar exist karti hai
            if ($category->icon && File::exists(public_path($category->icon))) {
                File::delete(public_path($category->icon));
            }

            // Nayi image upload
            $fileName = time() . '_' . \Illuminate\Support\Str::slug($request->name) . '.' . $request->icon->extension();
            $request->icon->move(public_path('uploads/categories'), $fileName);
            $data['icon'] = 'uploads/categories/' . $fileName;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    // Toggle Status Logic
    public function toggleStatus(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'is_active' => $category->is_active]);
        }
        return redirect()->back()->with('success', 'Status updated!');
    }

    // Delete Logic
    public function destroy(Category $category)
    {
        if ($category->qrCodes()->count() > 0) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Cannot delete! QR codes exist.'], 422);
            }
            return redirect()->back()->with('error', 'Cannot delete! QR codes exist.');
        }

        $category->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.categories.index');
    }
}
