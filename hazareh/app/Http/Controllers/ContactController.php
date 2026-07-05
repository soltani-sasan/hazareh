<?php
namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:120',
            'email' => 'nullable|email|max:180',
            'message' => 'required|string|min:5',
        ], ['required' => 'این فیلد الزامی است.']);

        $data['type'] = 'contact';
        Feedback::create($data);

        return back()->with('success', 'پیام شما با موفقیت ارسال شد. به‌زودی با شما تماس خواهیم گرفت.');
    }

    public function feedback()
    {
        return view('pages.feedback');
    }

    public function storeFeedback(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'nullable|string|max:120',
            'email' => 'nullable|email|max:180',
            'type' => 'required|in:suggestion,strength,weakness',
            'message' => 'required|string|min:5',
        ], ['required' => 'این فیلد الزامی است.']);

        Feedback::create($data);

        return back()->with('success', 'با تشکر از نظر شما، پیام شما ثبت شد.');
    }
}
