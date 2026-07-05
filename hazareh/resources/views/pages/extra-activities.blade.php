@extends('layouts.app')
@section('title', 'فعالیت‌های فوق‌برنامه')

@section('content')
<section class="conf-hero" style="padding:2.5rem 0;">
    <div class="container"><h1 class="conf-title" style="font-size:1.5rem;">فعالیت‌های فوق‌برنامه</h1></div>
</section>
<section class="section">
    <div class="container">
        <div class="grid-3">
            <div class="card"><div class="card-body text-center">
                <i class="ti ti-ball-football" style="font-size:2rem; color:var(--accent);"></i>
                <h3 class="card-title mt-2">فعالیت‌های ورزشی</h3>
                <p class="card-excerpt">کلاس‌های فوق‌برنامه ورزشی برای هنرجویان</p>
            </div></div>
            <div class="card"><div class="card-body text-center">
                <i class="ti ti-tool" style="font-size:2rem; color:var(--accent);"></i>
                <h3 class="card-title mt-2">کارگاه‌های مهارتی</h3>
                <p class="card-excerpt">کارگاه‌های تکمیلی مهارت فنی خارج از برنامه رسمی</p>
            </div></div>
            <div class="card"><div class="card-body text-center">
                <i class="ti ti-map" style="font-size:2rem; color:var(--accent);"></i>
                <h3 class="card-title mt-2">بازدیدهای صنعتی</h3>
                <p class="card-excerpt">بازدید از خطوط تولید پالایشگاه و پتروشیمی</p>
            </div></div>
        </div>
    </div>
</section>
@endsection
