<?php
namespace App\Http\Controllers;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $educational = Announcement::where('section', 'educational')->where('is_active', 1)
            ->orderByDesc('priority')->orderByDesc('created_at')->get();
        $counseling = Announcement::where('section', 'counseling')->where('is_active', 1)
            ->orderByDesc('priority')->orderByDesc('created_at')->get();
        $nurturing = Announcement::where('section', 'nurturing')->where('is_active', 1)
            ->orderByDesc('priority')->orderByDesc('created_at')->get();

        return view('announcements.index', compact('educational', 'counseling', 'nurturing'));
    }

    public function show(int $id)
    {
        $announcement = Announcement::where('is_active', 1)->findOrFail($id);
        return view('announcements.show', compact('announcement'));
    }
}
