<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PreRegistration;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = PreRegistration::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('field')) {
            $query->where('requested_field', $request->field);
        }
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->q . '%')
                  ->orWhere('last_name', 'like', '%' . $request->q . '%')
                  ->orWhere('national_id', 'like', '%' . $request->q . '%');
            });
        }

        $registrations = $query->latest()->paginate(20)->withQueryString();
        return view('admin.registrations.index', compact('registrations'));
    }

    public function show(int $id)
    {
        $registration = PreRegistration::findOrFail($id);
        return view('admin.registrations.show', compact('registration'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
            'admin_note' => 'nullable|string',
        ]);

        $registration = PreRegistration::findOrFail($id);
        $registration->status = $request->status;
        $registration->admin_note = $request->admin_note;
        $registration->save();

        // در صورت پذیرش، حساب کاربری هنرجو به‌صورت خودکار ساخته می‌شود
        if ($request->status === 'accepted' && !User::where('national_id', $registration->national_id)->exists()) {
            DB::transaction(function () use ($registration) {
                $user = User::create([
                    'name' => $registration->first_name . ' ' . $registration->last_name,
                    'national_id' => $registration->national_id,
                    'phone' => $registration->mobile,
                    'password' => Hash::make($registration->national_id), // رمز پیش‌فرض = کد ملی (پیشنهاد: اطلاع‌رسانی تغییر رمز)
                    'role' => 'student',
                    'is_active' => true,
                ]);

                Student::create([
                    'user_id' => $user->id,
                    'field' => $registration->requested_field,
                    'grade' => '10',
                    'birth_date' => $registration->birth_date,
                    'address' => $registration->address,
                    'postal_code' => $registration->postal_code,
                    'father_name' => $registration->father_name,
                    'father_phone' => $registration->father_mobile,
                    'mother_name' => $registration->mother_name,
                    'mother_lastname' => $registration->mother_lastname,
                    'mother_phone' => $registration->mother_mobile,
                    'prev_school' => $registration->prev_school,
                    'prev_district' => $registration->prev_district,
                    'prev_principal' => $registration->prev_principal,
                    'prev_counselor' => $registration->prev_counselor,
                    'last_gpa' => $registration->last_gpa,
                    'discipline_score' => $registration->discipline_score,
                    'guidance_doc_path' => $registration->guidance_doc,
                    'enrollment_status' => 'accepted',
                ]);
            });
        }

        return back()->with('success', 'وضعیت ثبت‌نام با موفقیت به‌روزرسانی شد.');
    }

    public function export()
    {
        $registrations = PreRegistration::all();

        $filename = 'pre-registrations-' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($registrations) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // BOM برای نمایش صحیح فارسی در اکسل
            fputcsv($file, ['نام', 'نام خانوادگی', 'کد ملی', 'موبایل', 'رشته', 'معدل', 'وضعیت', 'تاریخ ثبت']);
            foreach ($registrations as $r) {
                fputcsv($file, [
                    $r->first_name, $r->last_name, $r->national_id, $r->mobile,
                    $r->field_label, $r->last_gpa, $r->status_label, $r->created_at,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
