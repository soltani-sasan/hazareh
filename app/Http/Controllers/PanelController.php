<?php
namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PanelController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        $myPapers = $user->isStudent() || $user->isTeacher()
            ? $user->papers()->latest()->take(5)->get()
            : collect();

        return view('panel.index', compact('user', 'student', 'myPapers'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('panel.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'nullable|email|max:180|unique:users,email,' . $user->id,
            'phone' => 'nullable|regex:/^09[0-9]{9}$/',
            'password' => 'nullable|string|min:6|confirmed',
        ], ['required' => 'این فیلد الزامی است.']);

        $user->name = $data['name'];
        $user->email = $data['email'] ?? $user->email;
        $user->phone = $data['phone'] ?? $user->phone;
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return back()->with('success', 'اطلاعات پروفایل با موفقیت به‌روزرسانی شد.');
    }

    public function registrationStatus()
    {
        $student = Auth::user()->student;
        return view('panel.registration-status', compact('student'));
    }

    public function myCounseling()
    {
        $user = Auth::user();
        $requests = \App\Models\CounselingRequest::where('national_id', $user->national_id)
            ->orderByDesc('created_at')->get();

        return view('panel.counseling', compact('requests'));
    }

    public function myNews()
    {
        $user = Auth::user();
        $student = $user->student;

        $query = News::published()->orderByDesc('published_at');
        if ($student) {
            $query->where(function ($q) use ($student) {
                $q->where('category', $student->field)->orWhere('category', 'general');
            })->where(function ($q) use ($student) {
                $q->where('grade', $student->grade)->orWhere('grade', 'all');
            });
        }

        $news = $query->paginate(9);
        return view('panel.news', compact('news'));
    }
}
