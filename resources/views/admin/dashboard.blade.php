@extends('layouts.admin')
@section('title', 'داشبورد مدیریت')

@section('content')
<h1 style="font-size:1.3rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;">
    <i class="ti ti-layout-dashboard"></i> داشبورد مدیریت
</h1>

<div class="panel-grid" style="grid-template-columns: repeat(4, 1fr);">
    <div class="panel-widget" style="border-top:3px solid var(--accent)">
        <div class="panel-widget-icon"><i class="ti ti-user-plus"></i></div>
        <div class="panel-widget-label">پیش‌ثبت‌نام‌های در انتظار</div>
        <div class="panel-widget-value">{{ $stats['pending_registrations'] }}</div>
        <a href="{{ route('admin.registrations.index', ['status'=>'pending']) }}" class="btn btn-sm btn-outline mt-1">مشاهده</a>
    </div>
    <div class="panel-widget" style="border-top:3px solid var(--primary-light)">
        <div class="panel-widget-icon"><i class="ti ti-message-circle"></i></div>
        <div class="panel-widget-label">مشاوره‌های پاسخ‌نداده</div>
        <div class="panel-widget-value">{{ $stats['pending_counseling'] }}</div>
        <a href="{{ route('admin.counseling.index', ['status'=>'pending']) }}" class="btn btn-sm btn-outline mt-1">مشاهده</a>
    </div>
    <div class="panel-widget" style="border-top:3px solid var(--warning)">
        <div class="panel-widget-icon"><i class="ti ti-messages"></i></div>
        <div class="panel-widget-label">نظرات خوانده‌نشده</div>
        <div class="panel-widget-value">{{ $stats['unread_feedback'] }}</div>
    </div>
    <div class="panel-widget" style="border-top:3px solid var(--success)">
        <div class="panel-widget-icon"><i class="ti ti-users"></i></div>
        <div class="panel-widget-label">تعداد هنرجویان</div>
        <div class="panel-widget-value">{{ $stats['total_students'] }}</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; margin-top:1.5rem;">
    <div class="card">
        <div class="card-body">
            <h3 style="font-size:1rem; font-weight:700; color:var(--primary); margin-bottom:1rem;">
                <i class="ti ti-user-plus" style="color:var(--accent)"></i> آخرین پیش‌ثبت‌نام‌ها
            </h3>
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>نام و نام خانوادگی</th><th>رشته</th><th>وضعیت</th><th></th></tr></thead>
                    <tbody>
                        @forelse($recentRegistrations as $r)
                        <tr>
                            <td>{{ $r->first_name }} {{ $r->last_name }}</td>
                            <td>{{ $r->field_label }}</td>
                            <td><span class="badge {{ $r->status_badge }}">{{ $r->status_label }}</span></td>
                            <td><a href="{{ route('admin.registrations.show', $r->id) }}" class="btn btn-sm btn-outline">مشاهده</a></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">موردی یافت نشد</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 style="font-size:1rem; font-weight:700; color:var(--primary); margin-bottom:1rem;">
                <i class="ti ti-message-circle" style="color:var(--accent)"></i> مشاوره‌های در انتظار پاسخ
            </h3>
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>نام</th><th>موضوع</th><th>تاریخ</th><th></th></tr></thead>
                    <tbody>
                        @forelse($recentCounseling as $c)
                        <tr>
                            <td>{{ $c->full_name }}</td>
                            <td>{{ Str::limit($c->subject, 25) }}</td>
                            <td>{{ verta($c->created_at)->format('Y/n/j') }}</td>
                            <td><a href="{{ route('admin.counseling.show', $c->id) }}" class="btn btn-sm btn-outline">پاسخ</a></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">موردی یافت نشد</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
        <h3 style="font-size:1rem; font-weight:700; color:var(--primary); margin-bottom:1rem;">
            <i class="ti ti-bolt" style="color:var(--accent)"></i> دسترسی سریع
        </h3>
        <div style="display:flex; gap:.75rem; flex-wrap:wrap;">
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm"><i class="ti ti-plus"></i> خبر جدید</a>
            <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary btn-sm"><i class="ti ti-plus"></i> اعلان جدید</a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm"><i class="ti ti-plus"></i> اسلاید جدید</a>
            <a href="{{ route('admin.registrations.export') }}" class="btn btn-outline btn-sm"><i class="ti ti-file-export"></i> خروجی اکسل ثبت‌نام‌ها</a>
            @endif
        </div>
    </div>
</div>
@endsection
