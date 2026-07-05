<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PreRegistration;
use Illuminate\Http\Request;

class ApiRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'national_id' => 'required|digits:10|unique:pre_registrations,national_id',
            'mobile' => 'required|regex:/^09[0-9]{9}$/',
            'first_name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'birth_date' => 'nullable|string',
            'father_name' => 'required|string|max:80',
            'father_mobile' => 'required|regex:/^09[0-9]{9}$/',
            'prev_school' => 'required|string|max:120',
            'last_gpa' => 'required|numeric|min:0|max:20',
            'requested_field' => 'required|in:electrical,mechanical,instrumentation',
            'guidance_doc' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($request->hasFile('guidance_doc')) {
            $data['guidance_doc'] = $request->file('guidance_doc')->store('guidance', 'public');
        }

        $registration = PreRegistration::create($data);

        return response()->json([
            'success' => true,
            'message' => 'پیش‌ثبت‌نام با موفقیت انجام شد.',
            'data' => ['id' => $registration->id],
        ], 201);
    }

    public function checkStatus(string $national_id)
    {
        $registration = PreRegistration::where('national_id', $national_id)->latest()->first();
        if (!$registration) {
            return response()->json(['success' => false, 'message' => 'پیش‌ثبت‌نامی با این کد ملی یافت نشد.'], 404);
        }

        return response()->json(['success' => true, 'data' => [
            'status' => $registration->status,
            'status_label' => $registration->status_label,
            'admin_note' => $registration->admin_note,
        ]]);
    }
}
