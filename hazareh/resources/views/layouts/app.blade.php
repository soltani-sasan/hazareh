<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'هنرستان هزاره صنعت') | اولین هنرستان جوار صنعت غرب کشور</title>
    <meta name="description" content="@yield('description', 'هنرستان هزاره صنعت — اولین هنرستان جوار صنعت غرب کشور، رشته‌های برق صنعتی، تاسیسات مکانیکی و ابزار دقیق')">

    <!-- Fonts: Vazirmatn (Persian) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons: Tabler -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    @stack('styles')
</head>
<body class="@yield('body-class')">

<!-- ══ HEADER ══════════════════════════════════════════════ -->
<header class="site-header">
    <div class="header-top">
        <div class="container">
            <!-- Logos strip -->
            <div class="logos-strip">
                <img src="{{ asset('images/logos/hazareh-logo.png') }}" alt="هنرستان هزاره صنعت" class="logo logo-main">
                <div class="logo-divider"></div>
                <img src="{{ asset('images/logos/moe-logo.png') }}" alt="آموزش و پرورش" class="logo">
                <img src="{{ asset('images/logos/refinery-logo.png') }}" alt="پالایشگاه گاز" class="logo">
                <img src="{{ asset('images/logos/petrochemical-logo.png') }}" alt="پتروشیمی" class="logo">
                <img src="{{ asset('images/logos/tvto-logo.png') }}" alt="فنی و حرفه‌ای" class="logo">
            </div>
            <!-- Header info -->
            <div class="header-info">
                <span class="header-date" id="shamsi-date"></span>
                @auth
                    <a href="{{ route('panel.index') }}" class="btn-header-user">
                        <i class="ti ti-user-circle"></i>
                        {{ auth()->user()->name }}
                    </a>
                    <a href="{{ route('logout') }}" class="btn-header-sm"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                        <i class="ti ti-logout"></i> خروج
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @else
                    <a href="{{ route('login') }}" class="btn-header-sm">
                        <i class="ti ti-login"></i> ورود
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- School name banner -->
    <div class="header-banner">
        <div class="container">
            <div class="school-name-wrap">
                <h1 class="school-name">هنرستان هزاره صنعت</h1>
                <p class="school-subtitle">اولین هنرستان جوار صنعت غرب کشور</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="main-nav" id="main-nav">
        <div class="container">
            <button class="nav-toggle" id="nav-toggle" aria-label="منو">
                <i class="ti ti-menu-2"></i>
            </button>
            <ul class="nav-list" id="nav-list">
                <li><a href="{{ route('home') }}" class="@if(request()->routeIs('home')) active @endif">
                    <i class="ti ti-home"></i> صفحه اصلی
                </a></li>

                <li class="has-dropdown">
                    <a href="#" class="@if(request()->is('about*')) active @endif">
                        درباره ما <i class="ti ti-chevron-down"></i>
                    </a>
                    <ul class="dropdown">
                        <li><a href="{{ route('about') }}"><i class="ti ti-info-circle"></i> معرفی هنرستان</a></li>
                        <li><a href="{{ route('about.goals') }}"><i class="ti ti-target"></i> اهداف و رسالت</a></li>
                        <li><a href="{{ route('about.facilities') }}"><i class="ti ti-building"></i> امکانات</a></li>
                        <li><a href="{{ route('staff.teaching') }}"><i class="ti ti-school"></i> کادر آموزشی</a></li>
                        <li><a href="{{ route('staff.research') }}"><i class="ti ti-microscope"></i> کادر پژوهشی</a></li>
                        <li><a href="{{ route('staff.admin') }}"><i class="ti ti-users"></i> کادر اداری</a></li>
                        <li><a href="{{ route('pta') }}"><i class="ti ti-heart-handshake"></i> انجمن اولیا و مربیان</a></li>
                        <li><a href="{{ route('history') }}"><i class="ti ti-history"></i> تاریخچه</a></li>
                    </ul>
                </li>

                <li class="has-dropdown">
                    <a href="#" class="@if(request()->is('register*','fields*','top*','extra*')) active @endif">
                        ثبت‌نام <i class="ti ti-chevron-down"></i>
                    </a>
                    <ul class="dropdown">
                        <li><a href="{{ route('pre-register') }}"><i class="ti ti-user-plus"></i> پیش‌ثبت‌نام</a></li>
                        <li><a href="{{ route('fields.index') }}"><i class="ti ti-certificate"></i> معرفی رشته‌ها</a></li>
                        <li><a href="{{ route('top-students') }}"><i class="ti ti-trophy"></i> برترین‌ها</a></li>
                        <li><a href="{{ route('extra-activities') }}"><i class="ti ti-ball-football"></i> فعالیت‌های فوق‌برنامه</a></li>
                    </ul>
                </li>

                <li class="has-dropdown">
                    <a href="{{ route('conference.index') }}" class="@if(request()->is('conference*')) active @endif">
                        همایش <i class="ti ti-chevron-down"></i>
                    </a>
                    <ul class="dropdown">
                        <li><a href="{{ route('conference.index') }}"><i class="ti ti-award"></i> درباره همایش</a></li>
                        <li><a href="{{ route('conference.register') }}"><i class="ti ti-user-check"></i> ثبت‌نام</a></li>
                        <li><a href="{{ route('conference.submit') }}"><i class="ti ti-file-upload"></i> ارسال مقاله</a></li>
                        <li><a href="{{ route('conference.results') }}"><i class="ti ti-medal"></i> نتایج</a></li>
                        <li><a href="{{ route('conference.schedule') }}"><i class="ti ti-calendar-event"></i> برنامه زمانی</a></li>
                    </ul>
                </li>

                <li class="has-dropdown">
                    <a href="#" class="@if(request()->is('counseling*','announcements*','panel*','app*')) active @endif">
                        سامانه‌ها <i class="ti ti-chevron-down"></i>
                    </a>
                    <ul class="dropdown">
                        <li><a href="{{ route('news.index') }}"><i class="ti ti-news"></i> اخبار و اطلاعیه‌ها</a></li>
                        <li><a href="{{ route('announcements.index') }}"><i class="ti ti-speakerphone"></i> تابلو اعلانات</a></li>
                        <li><a href="{{ route('counseling.form') }}"><i class="ti ti-message-circle"></i> مشاوره آنلاین</a></li>
                        <li><a href="{{ route('counseling.track') }}"><i class="ti ti-search"></i> پیگیری مشاوره</a></li>
                        @auth
                        <li><a href="{{ route('panel.index') }}"><i class="ti ti-layout-dashboard"></i> پنل کاربری</a></li>
                        @endauth
                        <li><a href="{{ route('app.download') }}"><i class="ti ti-device-mobile"></i> دانلود اپ</a></li>
                    </ul>
                </li>

                <li class="has-dropdown">
                    <a href="{{ route('contact') }}" class="@if(request()->is('contact*','feedback*')) active @endif">
                        ارتباط با ما <i class="ti ti-chevron-down"></i>
                    </a>
                    <ul class="dropdown">
                        <li><a href="{{ route('contact') }}"><i class="ti ti-mail"></i> تماس با ما</a></li>
                        <li><a href="{{ route('feedback') }}"><i class="ti ti-messages"></i> نظرات و پیشنهادات</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- ══ MAIN CONTENT ════════════════════════════════════════ -->
<main id="main-content">
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        <i class="ti ti-circle-check"></i>
        {{ session('success') }}
        <button class="alert-close" onclick="this.parentElement.remove()"><i class="ti ti-x"></i></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error" role="alert">
        <i class="ti ti-alert-circle"></i>
        {{ session('error') }}
        <button class="alert-close" onclick="this.parentElement.remove()"><i class="ti ti-x"></i></button>
    </div>
    @endif

    @yield('content')
</main>

<!-- ══ FOOTER ══════════════════════════════════════════════ -->
<footer class="site-footer">
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- About col -->
                <div class="footer-col">
                    <img src="{{ asset('images/logos/hazareh-logo.png') }}" alt="هنرستان هزاره صنعت" class="footer-logo">
                    <p class="footer-desc">هنرستان هزاره صنعت، اولین هنرستان جوار صنعت غرب کشور، در سال ۱۴۰۴ با هدف تربیت نیروی ماهر برای صنایع پتروشیمی و پالایشگاه تأسیس شده است.</p>
                    <div class="footer-socials">
                        <a href="#" aria-label="اینستاگرام"><i class="ti ti-brand-instagram"></i></a>
                        <a href="#" aria-label="تلگرام"><i class="ti ti-brand-telegram"></i></a>
                        <a href="#" aria-label="واتساپ"><i class="ti ti-brand-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Quick links -->
                <div class="footer-col">
                    <h3 class="footer-heading">دسترسی سریع</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('pre-register') }}"><i class="ti ti-chevron-left"></i> پیش‌ثبت‌نام</a></li>
                        <li><a href="{{ route('fields.index') }}"><i class="ti ti-chevron-left"></i> معرفی رشته‌ها</a></li>
                        <li><a href="{{ route('conference.index') }}"><i class="ti ti-chevron-left"></i> همایش بین‌المللی</a></li>
                        <li><a href="{{ route('counseling.form') }}"><i class="ti ti-chevron-left"></i> مشاوره آنلاین</a></li>
                        <li><a href="{{ route('announcements.index') }}"><i class="ti ti-chevron-left"></i> تابلو اعلانات</a></li>
                        <li><a href="{{ route('app.download') }}"><i class="ti ti-chevron-left"></i> دانلود اپلیکیشن</a></li>
                    </ul>
                </div>

                <!-- Fields -->
                <div class="footer-col">
                    <h3 class="footer-heading">رشته‌های تحصیلی</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('fields.show', 'electrical') }}"><i class="ti ti-bolt"></i> برق صنعتی</a></li>
                        <li><a href="{{ route('fields.show', 'mechanical') }}"><i class="ti ti-settings-2"></i> تاسیسات مکانیکی</a></li>
                        <li><a href="{{ route('fields.show', 'instrumentation') }}"><i class="ti ti-gauge"></i> تعمیرکار ابزار دقیق</a></li>
                    </ul>
                    <h3 class="footer-heading" style="margin-top:1.5rem">همکاران صنعتی</h3>
                    <div class="partner-logos">
                        <img src="{{ asset('images/logos/refinery-logo.png') }}" alt="پالایشگاه">
                        <img src="{{ asset('images/logos/petrochemical-logo.png') }}" alt="پتروشیمی">
                        <img src="{{ asset('images/logos/tvto-logo.png') }}" alt="فنی و حرفه‌ای">
                    </div>
                </div>

                <!-- Contact -->
                <div class="footer-col">
                    <h3 class="footer-heading">اطلاعات تماس</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="ti ti-map-pin"></i>
                            <span>آدرس: [آدرس کامل هنرستان]</span>
                        </li>
                        <li>
                            <i class="ti ti-phone"></i>
                            <span>تلفن: [شماره تلفن]</span>
                        </li>
                        <li>
                            <i class="ti ti-mail"></i>
                            <a href="mailto:info@hazareh.ir">info@hazareh.ir</a>
                        </li>
                        <li>
                            <i class="ti ti-clock"></i>
                            <span>شنبه تا چهارشنبه: ۷:۳۰ — ۱۴:۳۰</span>
                        </li>
                    </ul>
                    <!-- Google Map embed -->
                    <div class="footer-map">
                        <iframe
                            src="https://maps.google.com/maps?q=هنرستان+هزاره+صنعت&output=embed"
                            loading="lazy" allowfullscreen
                            title="موقعیت هنرستان"
                            width="100%" height="140" style="border:0;border-radius:8px">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p>© {{ date('Y') }} هنرستان هزاره صنعت — تمامی حقوق محفوظ است</p>
            <p>طراحی و توسعه با ❤ برای صنعت ایران</p>
        </div>
    </div>
</footer>

<!-- Main JS -->
<script src="{{ asset('js/main.js') }}"></script>
@stack('scripts')
</body>
</html>
