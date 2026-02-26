<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    // Admin: Edit Form
    public function edit()
    {
        $about = About::first() ?? new About();
        return view('admin.about.edit', compact('about'));
    }

    // Admin: Update Logic
    public function update(Request $request)
    {
        $about = About::first() ?? new About();

        $data = $request->only([
            'main_title',
            'main_description',
            'mission_title',
            'mission_description',
            'story_description'
        ]);

        // Image Processing
        foreach (['main_image', 'mission_image', 'story_image'] as $img) {
            if ($request->hasFile($img)) {
                $data[$img] = $request->file($img)->store('about', 'public');
            }
        }

        About::updateOrCreate(['id' => $about->id], $data);
        return back()->with('success', 'About Us updated!');
    }

    // User Side: View
    public function index()
    {
        $about = About::first();
        return view('user.about', compact('about'));
    }
}
