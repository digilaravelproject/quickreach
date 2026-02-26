<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactControllerAdmin extends Controller
{
    // Saare messages dikhane ke liye
    public function index()
    {
        $messages = Contact::latest()->paginate(10);
        return view('admin.contacts.index', compact('messages'));
    }

    // Message ko read mark karne ke liye (AJAX support)
    public function toggleRead($id)
    {
        $message = Contact::findOrFail($id);
        $message->is_read = !$message->is_read;
        $message->save();

        return response()->json(['success' => true, 'is_read' => $message->is_read]);
    }

    // Message delete karne ke liye
    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return back()->with('success', 'Inquiry deleted successfully!');
    }
}
