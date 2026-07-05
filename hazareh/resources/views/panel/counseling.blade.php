@extends('layouts.app')
@section('title', 'پیام‌های مشاوره من')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">پنل کاربری</span>
            <h1 class="section-title">پیام‌های مشاوره من</h1>
            <div class="section-line"></div>
        </div>
        @forelse($requests as $r)
        <div class="card mb-2"><div class="card-body">
            <div class="d-flex justify-between align-center mb-1">
                <span class="card-tag {{ $r->status=='answered' ? '' : 'accent' }}">{{ $r->status=='answered' ? 'پاسخ داده شده' : 'در انتظار پاسخ' }}</span>
                <span class="text-muted" style="font-size:.78rem;">{{ verta($r->created_at)->format('Y/n/j') }}</span>
            </div>
            <h3 class="card-title" style="font-size:.95rem;">{{ $r->subject }}</h3>
            @if($r->status=='answered')
            <div style="background:rgba(5,150,105,.07); border-radius:8px; padding:.85rem; margin-top:.75rem; font-size:.85rem;">{{ $r->response_text }}</div>
            @endif
        </div></div>
        @empty
        <p class="text-center text-muted">پیامی ثبت نشده است. <a href="{{ route('counseling.form') }}">ارسال پیام جدید</a></p>
        @endforelse
    </div>
</section>
@endsection
