<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Form dikhane ke liye
    public function index()
    {
        return view('user.contact');
    }

    // Form submit karne ke liye
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        Contact::create($request->all());

        return back()->with('success', 'Thank you! Your message has been sent successfully.');
    }
}
