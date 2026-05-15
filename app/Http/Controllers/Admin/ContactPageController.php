<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\Request;

class ContactPageController extends Controller
{
    // Admin: Edit Form
    public function edit()
    {
        $contact = ContactSetting::first() ?? new ContactSetting();
        return view('admin.contact.edit', compact('contact'));
    }

    // Admin: Update Logic
    public function update(Request $request)
    {
        $contact = ContactSetting::first() ?? new ContactSetting();

        $data = $request->only([
            'email',
            'phone',
            'whatsapp',
            'instagram',
            'facebook',
            'twitter',
            'youtube',
            'linkedin',
            'website',
            'address',
            'support_hours',
        ]);

        ContactSetting::updateOrCreate(['id' => $contact->id], $data);

        return back()->with('success', 'Contact details updated successfully!');
    }

    // User Side: View
    public function index()
    {
        $contact = ContactSetting::first();
        return view('user.contacts', compact('contact'));
    }
}
