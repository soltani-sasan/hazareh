@extends('layouts.app')
@section('title', 'پیش‌ثبت‌نام موفق')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-card text-center">
            <i class="ti ti-circle-check" style="font-size:3.5rem; color:var(--success);"></i>
            <h1 style="font-size:1.2rem; font-weight:700; color:var(--success); margin:1rem 0 .5rem;">پیش‌ثبت‌نام شما با موفقیت ثبت شد</h1>
            <p class="text-muted mb-3" style="font-size:.88rem; line-height:1.8;">
                درخواست شما در صف بررسی قرار گرفت. نتیجه از طریق پیامک و یا با ورود به پروفایل شخصی خود (پس از ساخت حساب کاربری) اعلام خواهد شد.
                لطفاً کارت آزمون را تا اطلاع بعدی نزد خود نگه دارید.
            </p>
            <div style="display:flex; gap:.75rem; justify-content:center; flex-wrap:wrap;">
                <a href="{{ route('register.form') }}" class="btn btn-outline">ساخت حساب کاربری</a>
                <a href="{{ route('home') }}" class="btn btn-accent">بازگشت به صفحه اصلی</a>
            </div>
        </div>
    </div>
</section>
@endsection
