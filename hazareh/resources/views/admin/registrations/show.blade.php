@extends('layouts.admin')
@section('title', 'بررسی پیش‌ثبت‌نام')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;">
    <i class="ti ti-user-plus"></i> بررسی پیش‌ثبت‌نام: {{ $registration->first_name }} {{ $registration->last_name }}
</h1>

<div style="display:grid; grid-template-columns:2fr 1fr; gap:1.5rem;">
    <div class="card"><div class="card-body">
        <h3 style="font-weight:700; color:var(--primary); margin-bottom:1rem; font-size:.95rem;">اطلاعات هنرجو</h3>
        <table class="data-table">
            <tr><th style="width:30%">نام و نام خانوادگی</th><td>{{ $registration->first_name }} {{ $registration->last_name }}</td></tr>
            <tr><th>کد ملی</th><td class="en-num" style="direction:ltr; text-align:right;">{{ $registration->national_id }}</td></tr>
            <tr><th>تاریخ تولد</th><td>{{ $registration->birth_date }}</td></tr>
            <tr><th>موبایل</th><td style="direction:ltr; text-align:right;">{{ $registration->mobile }}</td></tr>
            <tr><th>تلفن منزل</th><td style="direction:ltr; text-align:right;">{{ $registration->home_phone }}</td></tr>
            <tr><th>نام پدر / موبایل</th><td>{{ $registration->father_name }} — {{ $registration->father_mobile }}</td></tr>
            <tr><th>نام مادر</th><td>{{ $registration->mother_name }} {{ $registration->mother_lastname }} — {{ $registration->mother_mobile }}</td></tr>
            <tr><th>مدرسه قبلی</th><td>{{ $registration->prev_school }} (منطقه {{ $registration->prev_district }})</td></tr>
            <tr><th>مدیر / مشاور قبلی</th><td>{{ $registration->prev_principal }} / {{ $registration->prev_counselor }}</td></tr>
            <tr><th>معدل / نمره انضباط</th><td>{{ $registration->last_gpa }} / {{ $registration->discipline_score }}</td></tr>
            <tr><th>رشته درخواستی</th><td>{{ $registration->field_label }}</td></tr>
            <tr><th>شیوه آشنایی</th><td>{{ $registration->how_known }}</td></tr>
            <tr><th>آدرس</th><td>{{ $registration->address }} — کدپستی: {{ $registration->postal_code }}</td></tr>
            <tr><th>مدرک هدایت تحصیلی</th><td>
                @if($registration->guidance_doc)
                <a href="{{ asset('storage/'.$registration->guidance_doc) }}" target="_blank" class="btn btn-sm btn-outline"><i class="ti ti-eye"></i> مشاهده فایل</a>
                @else — @endif
            </td></tr>
        </table>
    </div></div>

    <div class="card"><div class="card-body">
        <h3 style="font-weight:700; color:var(--primary); margin-bottom:1rem; font-size:.95rem;">تعیین وضعیت</h3>
        <form action="{{ route('admin.registrations.status', $registration->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">وضعیت</label>
                <select name="status" class="form-control">
                    <option value="pending" {{ $registration->status=='pending'?'selected':'' }}>در انتظار بررسی</option>
                    <option value="reviewed" {{ $registration->status=='reviewed'?'selected':'' }}>در حال بررسی</option>
                    <option value="accepted" {{ $registration->status=='accepted'?'selected':'' }}>پذیرفته شده</option>
                    <option value="rejected" {{ $registration->status=='rejected'?'selected':'' }}>رد شده</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">یادداشت مدیر</label>
                <textarea name="admin_note" class="form-control" rows="4">{{ $registration->admin_note }}</textarea>
            </div>
            <button type="submit" class="btn btn-accent btn-block"><i class="ti ti-check"></i> ثبت وضعیت</button>
        </form>
        <p class="form-hint mt-2">با انتخاب «پذیرفته شده»، حساب کاربری هنرجو به‌صورت خودکار ساخته می‌شود (رمز پیش‌فرض: کد ملی).</p>
    </div></div>
</div>
@endsection
