@extends('layouts.admin')
@section('title', 'مدیریت پیش‌ثبت‌نام‌ها')

@section('content')
<div class="d-flex justify-between align-center mb-3">
    <h1 style="font-size:1.2rem; font-weight:700; color:var(--primary);"><i class="ti ti-user-plus"></i> پیش‌ثبت‌نام‌های دریافتی</h1>
    <a href="{{ route('admin.registrations.export') }}" class="btn btn-outline"><i class="ti ti-file-export"></i> خروجی CSV</a>
</div>

<form method="GET" style="display:flex; gap:.75rem; flex-wrap:wrap; margin-bottom:1.25rem;">
    <input type="text" name="q" class="form-control" style="max-width:220px;" placeholder="جست‌وجو نام یا کد ملی..." value="{{ request('q') }}">
    <select name="status" class="form-control" style="width:auto;" onchange="this.form.submit()">
        <option value="">همه وضعیت‌ها</option>
        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>در انتظار بررسی</option>
        <option value="reviewed" {{ request('status')=='reviewed'?'selected':'' }}>در حال بررسی</option>
        <option value="accepted" {{ request('status')=='accepted'?'selected':'' }}>پذیرفته شده</option>
        <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>رد شده</option>
    </select>
    <select name="field" class="form-control" style="width:auto;" onchange="this.form.submit()">
        <option value="">همه رشته‌ها</option>
        <option value="electrical" {{ request('field')=='electrical'?'selected':'' }}>برق صنعتی</option>
        <option value="mechanical" {{ request('field')=='mechanical'?'selected':'' }}>تاسیسات مکانیکی</option>
        <option value="instrumentation" {{ request('field')=='instrumentation'?'selected':'' }}>ابزار دقیق</option>
    </select>
    <button class="btn btn-primary"><i class="ti ti-search"></i></button>
</form>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>نام و نام خانوادگی</th><th>کد ملی</th><th>موبایل</th><th>رشته</th><th>معدل</th><th>وضعیت</th><th>تاریخ</th><th></th></tr></thead>
            <tbody>
                @forelse($registrations as $r)
                <tr>
                    <td>{{ $r->first_name }} {{ $r->last_name }}</td>
                    <td class="en-num" style="direction:ltr; text-align:right;">{{ $r->national_id }}</td>
                    <td style="direction:ltr; text-align:right;">{{ $r->mobile }}</td>
                    <td>{{ $r->field_label }}</td>
                    <td>{{ $r->last_gpa }}</td>
                    <td><span class="badge {{ $r->status_badge }}">{{ $r->status_label }}</span></td>
                    <td>{{ verta($r->created_at)->format('Y/n/j') }}</td>
                    <td><a href="{{ route('admin.registrations.show', $r->id) }}" class="btn btn-sm btn-outline">بررسی</a></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">پیش‌ثبت‌نامی ثبت نشده است</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-2">{{ $registrations->links() }}</div>
@endsection
