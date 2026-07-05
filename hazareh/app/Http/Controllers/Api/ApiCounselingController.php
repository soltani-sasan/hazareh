<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CounselingRequest;
use Illuminate\Http\Request;

class ApiCounselingController extends Controller
{
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
        ]);

        $data['is_private'] = $request->boolean('is_private', true);
        $item = CounselingRequest::create($data);

        return response()->json(['success' => true, 'message' => 'پیام شما ارسال شد.', 'data' => ['id' => $item->id]], 201);
    }

    public function track(Request $request)
    {
        $request->validate([
            'national_id' => 'required|digits:10',
            'mobile' => 'required|regex:/^09[0-9]{9}$/',
        ]);

        $items = CounselingRequest::where('national_id', $request->national_id)
            ->where('mobile', $request->mobile)->orderByDesc('created_at')->get();

        return response()->json(['success' => true, 'data' => $items]);
    }
}
