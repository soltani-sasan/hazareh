@extends('layouts.app')
@section('title', 'پنل کاربری')

@section('content')
<section class="section">
    <div class="container">
        <div class="card" style="max-width:1000px; margin:0 auto; overflow:visible;">
            <div class="panel-header">
                <div class="panel-welcome"><i class="ti ti-user-circle"></i> خوش آمدید، {{ $user->name }}</div>
                <div class="panel-sub">{{ $user->role_label }}@if($student) — {{ $student->field_label }} (پایه {{ ['10'=>'دهم','11'=>'یازدهم','12'=>'دوازدهم'][$student->grade] ?? $student->grade }})@endif</div>
            </div>

            <div class="card-body" style="padding:1.5rem;">
                <div class="panel-grid">
                    <a href="{{ route('panel.profile') }}" class="panel-widget" style="text-decoration:none;">
                        <div class="panel-widget-icon"><i class="ti ti-user-edit"></i></div>
                        <div class="panel-widget-label">ویرایش پروفایل</div>
                    </a>
                    @if($student)
                    <a href="{{ route('panel.reg-status') }}" class="panel-widget" style="text-decoration:none;">
                        <div class="panel-widget-icon"><i class="ti ti-clipboard-check"></i></div>
                        <div class="panel-widget-label">وضعیت ثبت‌نام</div>
                        <div class="panel-widget-value" style="font-size:.85rem;">{{ $student->status_label }}</div>
                    </a>
                    @endif
                    <a href="{{ route('panel.counseling') }}" class="panel-widget" style="text-decoration:none;">
                        <div class="panel-widget-icon"><i class="ti ti-message-circle"></i></div>
                        <div class="panel-widget-label">پیام‌های مشاوره</div>
                    </a>
                    <a href="{{ route('panel.news') }}" class="panel-widget" style="text-decoration:none;">
                        <div class="panel-widget-icon"><i class="ti ti-news"></i></div>
                        <div class="panel-widget-label">اخبار رشته من</div>
                    </a>
                </div>

                @if(in_array($user->role, ['student','teacher']))
                <h3 style="font-size:.95rem; font-weight:700; color:var(--primary); margin:2rem 0 1rem;">
                    <i class="ti ti-file-text" style="color:var(--accent)"></i> مقالات همایش من
                </h3>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead><tr><th>عنوان</th><th>محور</th><th>وضعیت</th></tr></thead>
                        <tbody>
                            @forelse($myPapers as $p)
                            <tr><td>{{ $p->title }}</td><td>{{ $p->track_label }}</td><td><span class="badge badge-primary">{{ $p->status_label }}</span></td></tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted">مقاله‌ای ارسال نشده — <a href="{{ route('conference.submit') }}">ارسال مقاله</a></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @endif

                @if(in_array($user->role, ['admin','teacher','counselor','conference_admin']))
                <div class="mt-3 text-center">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary"><i class="ti ti-layout-dashboard"></i> ورود به پنل مدیریت</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
