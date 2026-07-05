<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'national_id' => 'required|digits:10',
            'password' => 'required|string',
        ], [
            'required' => 'این فیلد الزامی است.',
            'national_id.digits' => 'کد ملی باید ۱۰ رقم باشد.',
        ]);

        if (!Auth::attempt(['national_id' => $credentials['national_id'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'national_id' => 'کد ملی یا رمز عبور اشتباه است.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('panel.index'))
            ->with('success', 'ورود با موفقیت انجام شد.');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'national_id' => 'required|digits:10|unique:users,national_id',
            'phone' => 'required|regex:/^09[0-9]{9}$/',
            'email' => 'nullable|email|max:180|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'field' => 'required|in:electrical,mechanical,instrumentation',
            'grade' => 'required|in:10,11,12',
        ], [
            'required' => 'این فیلد الزامی است.',
            'national_id.unique' => 'این کد ملی قبلاً ثبت‌نام کرده است.',
            'password.confirmed' => 'تکرار رمز عبور مطابقت ندارد.',
            'password.min' => 'رمز عبور باید حداقل ۶ کاراکتر باشد.',
        ]);

        $user = User::create([
            'name' => $data['name'] . ' ' . $data['last_name'],
            'national_id' => $data['national_id'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => 'student',
            'is_active' => true,
        ]);

        Student::create([
            'user_id' => $user->id,
            'field' => $data['field'],
            'grade' => $data['grade'],
            'enrollment_status' => 'pending',
        ]);

        Auth::login($user);

        return redirect()->route('panel.index')
            ->with('success', 'حساب کاربری شما با موفقیت ایجاد شد.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'با موفقیت خارج شدید.');
    }

    public function forgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendReset(Request $request)
    {
        $request->validate([
            'national_id' => 'required|digits:10|exists:users,national_id',
        ], [
            'national_id.exists' => 'کاربری با این کد ملی یافت نشد.',
        ]);

        // یادآوری: در محیط تولید، اینجا لینک/کد بازیابی از طریق پیامک یا ایمیل ارسال می‌شود
        return back()->with('success', 'در صورت صحت اطلاعات، کد بازیابی برای شما ارسال شد.');
    }
}
