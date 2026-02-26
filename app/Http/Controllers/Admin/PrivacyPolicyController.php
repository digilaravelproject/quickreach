<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy; // Ensure you create this Model
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    // Admin: Show Edit Form
    public function edit()
    {
        $policy = PrivacyPolicy::first() ?? new PrivacyPolicy([
            'title' => 'Privacy Policy',
            'content' => '<p>Initial privacy policy content...</p>'
        ]);
        return view('admin.privacy.edit', compact('policy'));
    }

    // Admin: Update Logic
    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'effective_date' => 'nullable|date'
        ]);

        PrivacyPolicy::updateOrCreate(
            ['id' => 1], // Always keep only one record
            [
                'title' => $request->title,
                'content' => $request->content,
                'effective_date' => $request->effective_date,
            ]
        );

        return back()->with('success', 'Privacy Policy updated successfully!');
    }

    // User Side: View Privacy Policy
    public function index()
    {
        $policy = PrivacyPolicy::first();
        return view('user.privacy', compact('policy'));
    }
}
