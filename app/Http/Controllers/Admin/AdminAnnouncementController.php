<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(15);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.form', ['announcement' => new Announcement()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['author_id'] = Auth::id();
        if ($request->hasFile('attachment')) {
    $file = $request->file('attachment');
    $data['attachment'] = $file->store('announcements', 'public');
    $mime = $file->getMimeType();
    $data['attachment_type'] = str_contains($mime,'image') ? 'image' 
                             : (str_contains($mime,'video') ? 'video' : 'pdf');
}
        Announcement::create($data);
        return redirect()->route('admin.announcements.index')->with('success', 'اعلان با موفقیت ثبت شد.');
    }

    public function edit(int $id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('admin.announcements.form', compact('announcement'));
    }

    public function update(Request $request, int $id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->update($this->validateData($request));
        return redirect()->route('admin.announcements.index')->with('success', 'اعلان با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(int $id)
    {
        Announcement::findOrFail($id)->delete();
        return back()->with('success', 'اعلان حذف شد.');
    }

    private function validateData(Request $request): array
{
    return $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'section' => 'required|in:educational,counseling,nurturing',
        'priority' => 'nullable|integer|min:0|max:10',
        'expires_at' => 'nullable|date',
        'is_active' => 'boolean',
    ]);
}
}
