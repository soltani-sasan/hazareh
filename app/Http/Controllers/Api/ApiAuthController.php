<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'national_id' => 'required|digits:10',
            'password' => 'required|string',
        ]);

        $user = User::where('national_id', $request->national_id)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'کد ملی یا رمز عبور اشتباه است.'], 401);
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'national_id' => 'required|digits:10|unique:users,national_id',
            'phone' => 'required|regex:/^09[0-9]{9}$/',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
            'field' => 'required|in:electrical,mechanical,instrumentation',
            'grade' => 'required|in:10,11,12',
        ]);

        $user = DB::transaction(function () use ($data) {
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

            return $user;
        });

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json(['success' => true, 'token' => $token, 'user' => $user], 201);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['national_id' => 'required|digits:10']);
        // یادآوری: ارسال کد بازیابی از طریق پیامک
        return response()->json(['success' => true, 'message' => 'در صورت صحت اطلاعات، کد بازیابی ارسال شد.']);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true, 'message' => 'خروج با موفقیت انجام شد.']);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load('student');
        return response()->json(['success' => true, 'data' => $user]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => 'sometimes|string|max:120',
            'email' => 'sometimes|nullable|email|unique:users,email,' . $user->id,
            'phone' => 'sometimes|regex:/^09[0-9]{9}$/',
        ]);
        $user->update($data);
        return response()->json(['success' => true, 'data' => $user]);
    }
}
