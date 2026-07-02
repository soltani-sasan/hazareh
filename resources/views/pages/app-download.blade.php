@extends('layouts.app')
@section('title', 'دانلود اپلیکیشن موبایل')

@section('content')
<section class="section section-alt">
    <div class="container">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:2.5rem; align-items:center;">
            <div>
                <span class="section-eyebrow" style="color:var(--accent-light)">اپلیکیشن موبایل</span>
                <h1 style="font-size:1.6rem; font-weight:700; color:#fff; margin:.5rem 0 1rem;">
                    هنرستان هزاره صنعت همراه شما
                </h1>
                <p style="color:rgba(255,255,255,.75); font-size:.9rem; line-height:1.9; margin-bottom:1.5rem;">
                    با اپلیکیشن موبایل هنرستان هزاره صنعت، به آخرین اخبار، اطلاعیه‌ها، وضعیت ثبت‌نام، مشاوره آنلاین و سامانه همایش
                    در هر زمان و هر مکان دسترسی داشته باشید.
                </p>
                <div style="display:flex; gap:.75rem; flex-wrap:wrap;">
                    <a href="#" class="btn btn-accent btn-lg"><i class="ti ti-brand-android"></i> دانلود برای اندروید (APK)</a>
                    <a href="#" class="btn btn-outline btn-lg" style="color:#fff; border-color:rgba(255,255,255,.4)">
                        <i class="ti ti-brand-apple"></i> به‌زودی برای iOS
                    </a>
                </div>
                <p style="color:rgba(255,255,255,.5); font-size:.78rem; margin-top:1rem;">
                    نسخه ۱.۰.۰ — حجم تقریبی ۱۸ مگابایت
                </p>
            </div>
            <div class="text-center">
                <i class="ti ti-device-mobile" style="font-size:10rem; color:rgba(255,255,255,.15);"></i>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">امکانات اپلیکیشن</span>
            <h2 class="section-title">چه کارهایی می‌توانید انجام دهید؟</h2>
            <div class="section-line"></div>
        </div>
        <div class="grid-4">
            <div class="card text-center"><div class="card-body">
                <i class="ti ti-news" style="font-size:1.8rem; color:var(--accent);"></i>
                <h3 class="card-title mt-2" style="font-size:.9rem;">اخبار لحظه‌ای</h3>
            </div></div>
            <div class="card text-center"><div class="card-body">
                <i class="ti ti-user-check" style="font-size:1.8rem; color:var(--accent);"></i>
                <h3 class="card-title mt-2" style="font-size:.9rem;">پیگیری ثبت‌نام</h3>
            </div></div>
            <div class="card text-center"><div class="card-body">
                <i class="ti ti-message-circle" style="font-size:1.8rem; color:var(--accent);"></i>
                <h3 class="card-title mt-2" style="font-size:.9rem;">مشاوره آنلاین</h3>
            </div></div>
            <div class="card text-center"><div class="card-body">
                <i class="ti ti-award" style="font-size:1.8rem; color:var(--accent);"></i>
                <h3 class="card-title mt-2" style="font-size:.9rem;">سامانه همایش</h3>
            </div></div>
        </div>
    </div>
</section>
@endsection
