<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::query();

        // 1. Search Filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('message', 'like', '%' . $request->search . '%');
            });
        }

        // 2. Status Filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status == 'active' ? 1 : 0);
        }

        // Paginate use karein (e.g., 10 items per page)
        $announcements = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $announcements->items(), // Sirf current page ke items
                'pagination' => [
                    'current_page' => $announcements->currentPage(),
                    'last_page' => $announcements->lastPage(),
                    'prev_page_url' => $announcements->previousPageUrl(),
                    'next_page_url' => $announcements->nextPageUrl(),
                ]
            ]);
        }

        return view('admin.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Naya create hoga aur default active rahega, purane change nahi honge
        Announcement::create([
            'title' => $request->title,
            'message' => $request->message,
            'is_active' => true
        ]);

        return response()->json(['success' => true, 'message' => 'Notification added!']);
    }

    public function toggleStatus($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->update(['is_active' => !$announcement->is_active]);

        return response()->json(['success' => true, 'is_active' => $announcement->is_active]);
    }

    public function destroy($id)
    {
        Announcement::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
