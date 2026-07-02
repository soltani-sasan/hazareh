@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')

@section('title', 'هنرستان هزاره صنعت')
@section('body-class', 'page-home')

@section('content')

{{-- ══ HERO SLIDER ══════════════════════════════════════════ --}}
{{-- ===== HERO ===== --}}
<section class="hero-slider">

@foreach($sliders as $slider)

<div class="slide {{ $loop->first ? 'active':'' }}">

<img src="{{ Storage::url('sliders/'.$slider->image) }}">

<div class="slide-content">

<h2>{{ $slider->title }}</h2>

@if($slider->subtitle)

<p>{{ $slider->subtitle }}</p>

@endif

<a href="{{ route('pre-registration.form') }}" class="btn btn-accent">

پیش ثبت نام

</a>

</div>

</div>

@endforeach

<button class="slider-arrow prev">
<i class="ti ti-chevron-right"></i>
</button>

<button class="slider-arrow next">
<i class="ti ti-chevron-left"></i>
</button>

<div class="slider-controls">

@foreach($sliders as $slider)

<button class="slider-dot {{ $loop->first ? 'active':'' }}"></button>

@endforeach

</div>

</section>

<div class="container">

<div class="home-news">

<aside class="sidebar-box">

<div class="sidebar-title">

تابلو اعلانات

</div>

@foreach($announcements->take(10) as $item)

<div class="sidebar-item">

<a href="{{ route('announcements.show',$item->id) }}">

{{ $item->title }}

</a>

<small>

{{ verta($item->created_at)->format('Y/m/d') }}

</small>

</div>

@endforeach

</aside>

<section class="news-area">

@foreach($latestNews as $item)

<article class="news-card">

<img src="{{ $item->image ? asset('storage/news/'.$item->image) : asset('images/news-placeholder.jpg') }}">

<div class="news-content">

<h3>

<a href="{{ route('news.show',$item->slug) }}">

{{ $item->title }}

</a>

</h3>

<p>

{{ Str::limit(strip_tags($item->body),180) }}

</p>

<a class="btn btn-outline"

href="{{ route('news.show',$item->slug) }}">

ادامه مطلب

</a>

</div>

</article>

@endforeach

</section>

</div>

</div>

{{-- ══ FIELDS ═══════════════════════════════════════════════ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">رشته‌های تحصیلی</span>
            <h2 class="section-title">رشته‌های تخصصی هنرستان</h2>
            <div class="section-line"></div>
        </div>
        <div class="grid-3">
            <div class="field-card">
                <div class="field-icon"><i class="ti ti-bolt"></i></div>
                <h3 class="field-name">برق صنعتی</h3>
                <p class="field-desc">آموزش مفاهیم برق، تابلوهای فرمان، موتورهای الکتریکی و انرژی‌های تجدیدپذیر با کارآموزی در پالایشگاه</p>
                <a href="{{ route('fields.show', 'electrical') }}" class="field-link">بیشتر بدانید ←</a>
            </div>
            <div class="field-card">
                <div class="field-icon"><i class="ti ti-settings-2"></i></div>
                <h3 class="field-name">تاسیسات مکانیکی</h3>
                <p class="field-desc">طراحی و اجرای سیستم‌های لوله‌کشی، تهویه مطبوع و سیستم‌های حرارتی صنعتی با تمرین عملی در محیط واقعی</p>
                <a href="{{ route('fields.show', 'mechanical') }}" class="field-link">بیشتر بدانید ←</a>
            </div>
            <div class="field-card">
                <div class="field-icon"><i class="ti ti-gauge"></i></div>
                <h3 class="field-name">تعمیرکار ابزار دقیق</h3>
                <p class="field-desc">کالیبراسیون و تعمیر سنسورها، کنترل‌کننده‌های صنعتی، PLC و سیستم‌های اتوماسیون پتروشیمی</p>
                <a href="{{ route('fields.show', 'instrumentation') }}" class="field-link">بیشتر بدانید ←</a>
            </div>
        </div>
    </div>
</section>

{{-- ══ NEWS + ANNOUNCEMENTS ══════════════════════════════════ --}}
<section class="section section-gray">
    <div class="container">
        <div style="display:grid; grid-template-columns: 2fr 1fr; gap: 2rem;">

            {{-- Latest News --}}
            <div>
                <div class="section-header" style="text-align:right; margin-bottom:1.25rem;">
                    <span class="section-eyebrow">آخرین اخبار</span>
                    <h2 class="section-title">اخبار و اطلاعیه‌ها</h2>
                </div>

                {{-- Featured news --}}
                @if($featuredNews)
                <div class="card mb-2">
                    <img src="{{ $featuredNews->image ? asset('storage/news/'.$featuredNews->image) : asset('images/news-placeholder.jpg') }}"
                         alt="{{ $featuredNews->title }}" class="card-img">
                    <div class="card-body">
                        <span class="card-tag accent">{{ $featuredNews->type === 'notice' ? 'اطلاعیه' : 'خبر' }}</span>
                        <h3 class="card-title">
                            <a href="{{ route('news.show', $featuredNews->slug) }}">{{ $featuredNews->title }}</a>
                        </h3>
                        <p class="card-date"><i class="ti ti-calendar"></i> {{ verta($featuredNews->published_at)->format('Y/n/j') }}</p>
                        <p class="card-excerpt">{{ Str::limit($featuredNews->body, 160) }}</p>
                    </div>
                </div>
                @endif

                {{-- News list --}}
                <div class="card">
                    <div class="card-body" style="padding:0">
                        @foreach($latestNews as $item)
                        <div class="news-item" style="padding:1rem 1.25rem">
                            <img src="{{ $item->image ? asset('storage/news/'.$item->image) : asset('images/news-placeholder.jpg') }}"
                                 alt="{{ $item->title }}" class="news-thumb">
                            <div>
                                <p class="news-meta">
                                    <i class="ti ti-calendar"></i>
                                    {{ verta($item->published_at)->format('Y/n/j') }}
                                    &nbsp;|&nbsp;
                                    <span class="badge badge-primary" style="font-size:.68rem">
                                        @switch($item->category)
                                            @case('electrical') برق صنعتی @break
                                            @case('mechanical') تاسیسات @break
                                            @case('instrumentation') ابزار دقیق @break
                                            @default عمومی
                                        @endswitch
                                    </span>
                                </p>
                                <a href="{{ route('news.show', $item->slug) }}" class="news-title">{{ $item->title }}</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div style="margin-top:.75rem; text-align:left">
                    <a href="{{ route('news.index') }}" class="btn btn-outline btn-sm">
                        همه اخبار <i class="ti ti-arrow-left"></i>
                    </a>
                </div>
            </div>

            {{-- Announcements --}}
            <div>
                <div class="section-header" style="text-align:right; margin-bottom:1.25rem;">
                    <span class="section-eyebrow">تابلو اعلانات</span>
                    <h2 class="section-title">اعلانات</h2>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="announce-tabs">
                            <button class="announce-tab active" data-tab="edu">آموزشی</button>
                            <button class="announce-tab" data-tab="coun">مشاوره‌ای</button>
                            <button class="announce-tab" data-tab="nur">پرورشی</button>
                        </div>

                        <div id="panel-edu" class="announce-panel">
                            @foreach($announcements->where('section','educational') as $ann)
                            <div class="announce-item">
                                <i class="announce-icon ti ti-book"></i>
                                <div class="announce-text">
                                    <a href="{{ route('announcements.show', $ann->id) }}" class="announce-title">{{ $ann->title }}</a>
                                    <p class="announce-date">{{ verta($ann->created_at)->format('Y/n/j') }}</p>
                                </div>
                            </div>
                            @endforeach
                            @if($announcements->where('section','educational')->isEmpty())
                            <p class="text-muted" style="font-size:.82rem; text-align:center; padding:1rem">اعلانی موجود نیست</p>
                            @endif
                        </div>

                        <div id="panel-coun" class="announce-panel d-none">
                            @foreach($announcements->where('section','counseling') as $ann)
                            <div class="announce-item">
                                <i class="announce-icon ti ti-message-circle"></i>
                                <div class="announce-text">
                                    <a href="{{ route('announcements.show', $ann->id) }}" class="announce-title">{{ $ann->title }}</a>
                                    <p class="announce-date">{{ verta($ann->created_at)->format('Y/n/j') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div id="panel-nur" class="announce-panel d-none">
                            @foreach($announcements->where('section','nurturing') as $ann)
                            <div class="announce-item">
                                <i class="announce-icon ti ti-star"></i>
                                <div class="announce-text">
                                    <a href="{{ route('announcements.show', $ann->id) }}" class="announce-title">{{ $ann->title }}</a>
                                    <p class="announce-date">{{ verta($ann->created_at)->format('Y/n/j') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Quick Counseling CTA --}}
                <div class="card mt-2" style="background:var(--primary); color:#fff; border:none;">
                    <div class="card-body" style="text-align:center">
                        <i class="ti ti-message-question" style="font-size:2rem; color:var(--accent-light)"></i>
                        <h4 style="margin:.5rem 0; font-size:1rem">مشاوره آنلاین</h4>
                        <p style="font-size:.8rem; opacity:.8; margin-bottom:1rem">سؤال دارید؟ پاسخ کارشناسان ما را دریافت کنید</p>
                        <a href="{{ route('counseling.form') }}" class="btn btn-accent btn-sm">
                            <i class="ti ti-send"></i> ارسال سؤال
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ INDUSTRIAL PARTNERS ════════════════════════════════════ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">تفاهم‌نامه‌های همکاری</span>
            <h2 class="section-title">همکاران صنعتی و آموزشی</h2>
            <div class="section-line"></div>
        </div>
        <div style="display:flex; align-items:center; justify-content:center; gap:3rem; flex-wrap:wrap; padding:1rem 0">
            <div style="text-align:center">
                <img src="{{ asset('images/logos/refinery-logo.png') }}" alt="پالایشگاه گاز" style="height:70px; object-fit:contain; filter:grayscale(30%)">
                <p style="font-size:.8rem; color:var(--text-muted); margin-top:.5rem">پالایشگاه گاز</p>
            </div>
            <div style="text-align:center">
                <img src="{{ asset('images/logos/petrochemical-logo.png') }}" alt="پتروشیمی" style="height:70px; object-fit:contain; filter:grayscale(30%)">
                <p style="font-size:.8rem; color:var(--text-muted); margin-top:.5rem">پتروشیمی</p>
            </div>
            <div style="text-align:center">
                <img src="{{ asset('images/logos/tvto-logo.png') }}" alt="فنی و حرفه‌ای" style="height:70px; object-fit:contain; filter:grayscale(30%)">
                <p style="font-size:.8rem; color:var(--text-muted); margin-top:.5rem">اداره فنی و حرفه‌ای</p>
            </div>
            <div style="text-align:center">
                <img src="{{ asset('images/logos/moe-logo.png') }}" alt="آموزش و پرورش" style="height:70px; object-fit:contain; filter:grayscale(30%)">
                <p style="font-size:.8rem; color:var(--text-muted); margin-top:.5rem">آموزش و پرورش</p>
            </div>
        </div>
    </div>
</section>

{{-- ══ CONFERENCE PROMO ═══════════════════════════════════════ --}}
@if($conference)
<section class="section section-alt">
    <div class="container">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem; align-items:center;">
            <div>
                <span class="section-eyebrow" style="color:var(--accent-light)">رویداد بزرگ</span>
                <h2 style="font-size:1.5rem; font-weight:700; color:#fff; margin:.5rem 0 1rem; line-height:1.5">
                    {{ $conference->title }}
                </h2>
                <p style="color:rgba(255,255,255,.75); font-size:.9rem; line-height:1.7; margin-bottom:1.25rem">
                    با همکاری پتروشیمی، پالایشگاه گاز و اداره کل فنی و حرفه‌ای
                </p>
                <div style="display:flex; gap:.75rem; flex-wrap:wrap;">
                    <a href="{{ route('conference.index') }}" class="btn btn-accent">
                        <i class="ti ti-award"></i> اطلاعات بیشتر
                    </a>
                    <a href="{{ route('conference.submit') }}" class="btn btn-outline" style="color:#fff; border-color:rgba(255,255,255,.4)">
                        <i class="ti ti-file-upload"></i> ارسال مقاله
                    </a>
                </div>
            </div>
            <div>
                <div id="conf-countdown" data-target="{{ $conference->start_date }}T08:00:00">
                    <div class="countdown">
                        <div class="countdown-unit">
                            <div class="countdown-num" id="cd-days">۰۰</div>
                            <div class="countdown-label">روز</div>
                        </div>
                        <div class="countdown-sep">:</div>
                        <div class="countdown-unit">
                            <div class="countdown-num" id="cd-hours">۰۰</div>
                            <div class="countdown-label">ساعت</div>
                        </div>
                        <div class="countdown-sep">:</div>
                        <div class="countdown-unit">
                            <div class="countdown-num" id="cd-mins">۰۰</div>
                            <div class="countdown-label">دقیقه</div>
                        </div>
                        <div class="countdown-sep">:</div>
                        <div class="countdown-unit">
                            <div class="countdown-num" id="cd-secs">۰۰</div>
                            <div class="countdown-label">ثانیه</div>
                        </div>
                    </div>
                </div>
                <div style="display:flex; gap:1.5rem; justify-content:center; margin-top:1.25rem; font-size:.82rem; color:rgba(255,255,255,.7)">
                    <span><i class="ti ti-calendar" style="color:var(--accent-light)"></i>
                        {{ verta($conference->start_date)->format('Y/n/j') }} تا {{ verta($conference->end_date)->format('Y/n/j') }}
                    </span>
                    <span><i class="ti ti-clock" style="color:var(--accent-light)"></i>
                        مهلت ارسال: {{ verta($conference->submission_deadline)->format('Y/n/j') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ══ MAP ════════════════════════════════════════════════════ --}}
<section class="section section-gray" id="location">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">موقعیت مکانی</span>
            <h2 class="section-title">آدرس هنرستان</h2>
            <div class="section-line"></div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1.5fr; gap:1.5rem; align-items:stretch;">
            <div class="card">
                <div class="card-body">
                    <h3 style="font-size:1rem; font-weight:700; margin-bottom:1.25rem; color:var(--primary)">
                        <i class="ti ti-map-pin" style="color:var(--accent)"></i> اطلاعات تماس
                    </h3>
                    <ul class="footer-contact" style="list-style:none; padding:0">
                        <li style="display:flex; gap:.6rem; align-items:flex-start; margin-bottom:1rem">
                            <i class="ti ti-map-2" style="color:var(--accent); margin-top:.15rem; flex-shrink:0"></i>
                            <span style="font-size:.88rem">آدرس: [استان / شهرستان / آدرس کامل هنرستان هزاره صنعت]</span>
                        </li>
                        <li style="display:flex; gap:.6rem; align-items:center; margin-bottom:1rem">
                            <i class="ti ti-phone" style="color:var(--accent)"></i>
                            <span style="font-size:.88rem">تلفن: [شماره تلفن هنرستان]</span>
                        </li>
                        <li style="display:flex; gap:.6rem; align-items:center; margin-bottom:1rem">
                            <i class="ti ti-mail" style="color:var(--accent)"></i>
                            <a href="mailto:info@hazareh.ir" style="font-size:.88rem">info@hazareh.ir</a>
                        </li>
                        <li style="display:flex; gap:.6rem; align-items:center; margin-bottom:1rem">
                            <i class="ti ti-clock" style="color:var(--accent)"></i>
                            <span style="font-size:.88rem">ساعت کار: شنبه تا چهارشنبه ۷:۳۰ — ۱۴:۳۰</span>
                        </li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn btn-primary btn-block" style="margin-top:.5rem">
                        <i class="ti ti-mail"></i> ارسال پیام
                    </a>
                </div>
            </div>
            
            <div class="location-box">

<div class="card">

<div class="card-body">

<h3>اطلاعات تماس</h3>

<p>هنرستان هزاره صنعت</p>

<p>اولین هنرستان جوار صنعت غرب کشور</p>

<p>ایلام</p>

<p>info@hazareh.ir</p>

<a href="{{ route('contact') }}" class="btn btn-primary">

تماس با ما

</a>

</div>

</div>

<div>

<iframe
src="https://maps.google.com/maps?q=https://maps.app.goo.gl/GWGse8uB8n5Ugs1NA&output=embed"
loading="lazy">
</iframe>

</div>

</div>
        </div>
    </div>
</section>

@endsection