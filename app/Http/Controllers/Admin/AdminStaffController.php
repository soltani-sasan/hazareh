<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class AdminStaffController extends Controller
{
    public function index()
    {
        $staff = Staff::orderBy('department')->orderBy('sort_order')->get();
        return view('admin.staff.index', compact('staff'));
    }

    public function create() { return view('admin.staff.form', ['member' => new Staff()]); }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('staff', 'public');
        }
        Staff::create($data);
        return redirect()->route('admin.staff.index')->with('success', 'عضو کادر با موفقیت اضافه شد.');
    }

    public function edit(int $id)
    {
        $member = Staff::findOrFail($id);
        return view('admin.staff.form', compact('member'));
    }

    public function update(Request $request, int $id)
    {
        $member = Staff::findOrFail($id);
        $data = $this->validateData($request);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('staff', 'public');
        }
        $member->update($data);
        return redirect()->route('admin.staff.index')->with('success', 'اطلاعات با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(int $id)
    {
        Staff::findOrFail($id)->delete();
        return back()->with('success', 'عضو کادر حذف شد.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'full_name' => 'required|string|max:120',
            'role_title' => 'nullable|string|max:120',
            'department' => 'required|in:teaching,research,admin,pta',
            'bio' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'photo' => 'nullable|image|max:2048',
        ], ['required' => 'این فیلد الزامی است.']);
    }
}
