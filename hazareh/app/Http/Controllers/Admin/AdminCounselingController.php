<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CounselingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCounselingController extends Controller
{
    public function index(Request $request)
    {
        $query = CounselingRequest::query();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $requests = $query->latest()->paginate(20)->withQueryString();
        return view('admin.counseling.index', compact('requests'));
    }

    public function show(int $id)
    {
        $item = CounselingRequest::findOrFail($id);
        return view('admin.counseling.show', ['item' => $item]);
    }

    public function reply(Request $request, int $id)
    {
        $request->validate([
            'response_text' => 'required|string|min:5',
        ], ['required' => 'متن پاسخ الزامی است.']);

        $item = CounselingRequest::findOrFail($id);
        $item->response_text = $request->response_text;
        $item->responder_id = Auth::id();
        $item->responded_at = now();
        $item->status = 'answered';
        $item->save();

        // یادآوری: ارسال پاسخ از طریق پیامک/ایمیل بر اساس فیلد reply_via
        // if ($item->reply_via === 'sms') { SmsService::send($item->mobile, ...); }
        // else { Mail::to($item->email)->send(new CounselingReplyMail($item)); }

        return back()->with('success', 'پاسخ با موفقیت ثبت و ارسال شد.');
    }
}
