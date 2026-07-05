@extends('layouts.app')
@section('title', 'ارسال موفق')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-card text-center" style="max-width:480px;">
            <i class="ti ti-circle-check" style="font-size:3.5rem; color:var(--success);"></i>
            <h1 style="font-size:1.2rem; font-weight:700; color:var(--success); margin:1rem 0 .5rem;">پیام شما ارسال شد</h1>
            <p class="text-muted mb-3" style="font-size:.88rem;">مشاور یا مدیر هنرستان به‌زودی به پیام شما پاسخ خواهد داد.</p>
            <a href="{{ route('counseling.track') }}" class="btn btn-outline btn-block mb-2">پیگیری وضعیت پاسخ</a>
            <a href="{{ route('home') }}" class="btn btn-accent btn-block">بازگشت به صفحه اصلی</a>
        </div>
    </div>
</section>
@endsection
