<?php
namespace App\Http\Controllers;

use App\Models\CounselingRequest;
use Illuminate\Http\Request;

class CounselingController extends Controller
{
    public function form()
    {
        return view('counseling.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sender_type' => 'required|in:student,parent',
            'full_name' => 'required|string|max:120',
            'national_id' => 'required|digits:10',
            'parent_name' => 'nullable|string|max:120',
            'home_phone' => 'nullable|string|max:15',
            'mobile' => 'required|regex:/^09[0-9]{9}$/',
            'email' => 'nullable|email|max:180',
            'reply_via' => 'required|in:sms,email',
            'subject' => 'required|string|max:255',
            'is_private' => 'nullable|boolean',
            'message' => 'required|string|min:10',
        ], [
            'required' => 'این فیلد الزامی است.',
            'national_id.digits' => 'کد ملی باید ۱۰ رقم باشد.',
            'mobile' => 'required|string|max:15',  // regex را بردارید
            'message.min' => 'متن پیام باید حداقل ۱۰ کاراکتر باشد.',
        ]);

        $data['is_private'] = $request->boolean('is_private', true);

        CounselingRequest::create($data);

        // یادآوری: در محیط تولید، اینجا اعلان به مشاور/مدیر از طریق Mail یا SMS ارسال شود
        // Mail::to(config('mail.counselor_email'))->send(new NewCounselingRequest($data));

        return redirect()->route('counseling.success')
            ->with('success', 'پیام شما با موفقیت ارسال شد و فقط برای مدیر و مشاور قابل مشاهده است.');
    }

    public function success()
    {
        return view('counseling.success');
    }

    public function trackForm()
    {
        return view('counseling.track');
    }

    public function track(Request $request)
    {
        $request->validate([
            'national_id' => 'required|digits:10',
            'mobile' => 'required|regex:/^09[0-9]{9}$/',
        ]);

        $requests = CounselingRequest::where('national_id', $request->national_id)
            ->where('mobile', $request->mobile)
            ->orderByDesc('created_at')
            ->get();

        return view('counseling.track', [
            'requests' => $requests,
            'searched' => true,
            'national_id' => $request->national_id,
            'mobile' => $request->mobile,
        ]);
    }
}
