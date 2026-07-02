<?php
namespace App\Http\Controllers;

use App\Models\PreRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function form()
    {
        return view('registration.pre-register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'national_id' => 'required|digits:10|regex:/^[0-9]{10}$/|unique:pre_registrations,national_id',
            'mobile' => 'required|regex:/^09[0-9]{9}$/',
            'first_name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'birth_date' => 'nullable|string|max:20',
            'home_phone' => 'nullable|string|max:15',
            'father_name' => 'required|string|max:80',
            'father_mobile' => 'required|regex:/^09[0-9]{9}$/',
            'mother_name' => 'nullable|string|max:80',
            'mother_lastname' => 'nullable|string|max:80',
            'mother_mobile' => 'nullable|string|max:15',
            'prev_school' => 'required|string|max:120',
            'prev_district' => 'nullable|integer|min:1|max:20',
            'prev_principal' => 'nullable|string|max:80',
            'prev_counselor' => 'nullable|string|max:80',
            'last_gpa' => 'required|numeric|min:0|max:20',
            'discipline_score' => 'nullable|numeric|min:0|max:20',
            'requested_field' => 'required|in:electrical,mechanical,instrumentation',
            'how_known' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:10',
            'guidance_doc' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'national_id.required' => 'وارد کردن کد ملی الزامی است.',
            'national_id.digits' => 'کد ملی باید دقیقاً ۱۰ رقم انگلیسی باشد.',
            'national_id.unique' => 'این کد ملی پیش‌تر ثبت‌نام شده است.',
'mobile'       => 'required|string|max:15',   // regex سخت‌گیرانه را بردارید
'birth_date'   => 'nullable|string|max:30',
'guidance_doc' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // required را بردارید            'father_mobile.regex' => 'شماره موبایل پدر را به‌صورت صحیح وارد کنید.',
            'last_gpa.required' => 'وارد کردن معدل الزامی است.',
            'guidance_doc.required' => 'بارگذاری عکس هدایت تحصیلی الزامی است.',
            'guidance_doc.mimes' => 'فرمت فایل باید JPG، PNG یا PDF باشد.',
            'guidance_doc.max' => 'حجم فایل نباید بیشتر از ۵ مگابایت باشد.',
            'required' => 'این فیلد الزامی است.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('guidance_doc')) {
            $path = $request->file('guidance_doc')->store('guidance', 'public');
            $data['guidance_doc'] = $path;
        }

        PreRegistration::create($data);

        return redirect()->route('pre-register.success')
            ->with('success', 'پیش‌ثبت‌نام شما با موفقیت ثبت شد. نتیجه از طریق پیامک یا پروفایل کاربری اعلام خواهد شد.');
    }

    public function success()
    {
        return view('registration.success');
    }
}
