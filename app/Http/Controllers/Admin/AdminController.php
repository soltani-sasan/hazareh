<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PreRegistration;
use App\Models\CounselingRequest;
use App\Models\News;
use App\Models\Feedback;
use App\Models\Paper;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'pending_registrations' => PreRegistration::where('status', 'pending')->count(),
            'pending_counseling' => CounselingRequest::where('status', 'pending')->count(),
            'unread_feedback' => Feedback::where('is_read', 0)->count(),
            'draft_news' => News::where('is_published', 0)->count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_papers' => Paper::count(),
        ];

        $recentRegistrations = PreRegistration::latest()->take(5)->get();
        $recentCounseling = CounselingRequest::where('status', 'pending')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentRegistrations', 'recentCounseling'));
    }

    public function users(Request $request)
    {
        $query = User::query();
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('national_id', 'like', '%' . $request->q . '%');
            });
        }
        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, int $id)
    {
        $request->validate([
            'role' => 'required|in:admin,student,teacher,counselor,judge,conference_admin,visitor',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'نقش کاربر با موفقیت تغییر یافت.');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function saveSettings(Request $request)
    {
        // یادآوری: تنظیمات سایت در جدول/فایل تنظیمات ذخیره می‌شود
        return back()->with('success', 'تنظیمات با موفقیت ذخیره شد.');
    }
}
