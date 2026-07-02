@extends('layouts.app')
@section('title', 'خطای سرور')
@section('content')
<section class="section">
    <div class="container text-center" style="padding:4rem 0;">
        <i class="ti ti-alert-triangle" style="font-size:4rem; color:var(--danger);"></i>
        <h1 style="font-size:1.4rem; font-weight:700; color:var(--primary); margin:1rem 0 .5rem;">خطایی در سرور رخ داد</h1>
        <p class="text-muted mb-3">لطفاً دوباره تلاش کنید یا با پشتیبانی تماس بگیرید.</p>
        <a href="{{ route('home') }}" class="btn btn-accent">بازگشت به صفحه اصلی</a>
    </div>
</section>
@endsection
