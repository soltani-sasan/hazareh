@extends('layouts.app')
@section('title', 'صفحه یافت نشد')
@section('content')
<section class="section">
    <div class="container text-center" style="padding:4rem 0;">
        <i class="ti ti-error-404" style="font-size:4rem; color:var(--text-muted);"></i>
        <h1 style="font-size:1.4rem; font-weight:700; color:var(--primary); margin:1rem 0 .5rem;">صفحه مورد نظر یافت نشد</h1>
        <p class="text-muted mb-3">ممکن است آدرس وارد شده اشتباه باشد یا صفحه حذف شده باشد.</p>
        <a href="{{ route('home') }}" class="btn btn-accent">بازگشت به صفحه اصلی</a>
    </div>
</section>
@endsection
