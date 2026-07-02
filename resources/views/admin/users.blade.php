@extends('layouts.admin')
@section('title', 'مدیریت کاربران')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;"><i class="ti ti-shield-check"></i> کاربران و نقش‌ها</h1>

<form method="GET" style="display:flex; gap:.75rem; margin-bottom:1.25rem;">
    <input type="text" name="q" class="form-control" style="max-width:250px;" placeholder="جست‌وجوی نام یا کد ملی..." value="{{ request('q') }}">
    <select name="role" class="form-control" style="width:auto;" onchange="this.form.submit()">
        <option value="">همه نقش‌ها</option>
        <option value="admin" {{ request('role')=='admin'?'selected':'' }}>مدیر سیستم</option>
        <option value="student" {{ request('role')=='student'?'selected':'' }}>هنرجو</option>
        <option value="teacher" {{ request('role')=='teacher'?'selected':'' }}>دبیر/هنرآموز</option>
        <option value="counselor" {{ request('role')=='counselor'?'selected':'' }}>مشاور</option>
        <option value="judge" {{ request('role')=='judge'?'selected':'' }}>داور</option>
        <option value="conference_admin" {{ request('role')=='conference_admin'?'selected':'' }}>مدیر همایش</option>
    </select>
</form>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>نام</th><th>کد ملی</th><th>نقش فعلی</th><th>تغییر نقش</th></tr></thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td class="en-num" style="direction:ltr; text-align:right;">{{ $u->national_id }}</td>
                    <td><span class="badge badge-primary">{{ $u->role_label }}</span></td>
                    <td>
                        <form action="{{ route('admin.users.role', $u->id) }}" method="POST" style="display:flex; gap:.4rem;">
                            @csrf
                            <select name="role" class="form-control" style="width:auto;">
                                @foreach(['admin'=>'مدیر سیستم','student'=>'هنرجو','teacher'=>'دبیر/هنرآموز','counselor'=>'مشاور','judge'=>'داور','conference_admin'=>'مدیر همایش','visitor'=>'بازدیدکننده'] as $k=>$v)
                                <option value="{{ $k }}" {{ $u->role==$k?'selected':'' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">اعمال</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">کاربری یافت نشد</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-2">{{ $users->links() }}</div>
@endsection
