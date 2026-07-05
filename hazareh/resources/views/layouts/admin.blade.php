<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'پنل مدیریت') | هنرستان هزاره صنعت</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @stack('styles')
</head>
<body>

<div style="background:var(--primary-dark); padding:.6rem 1.5rem; display:flex; align-items:center; justify-content:space-between;">
    <a href="{{ route('home') }}" style="display:flex; align-items:center; gap:.5rem; color:#fff; font-size:.85rem;">
        <i class="ti ti-arrow-right"></i> بازگشت به سایت
    </a>
    <span style="color:rgba(255,255,255,.7); font-size:.8rem;">پنل مدیریت — هنرستان هزاره صنعت</span>
</div>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="sidebar-user">
            <div class="sidebar-avatar"><i class="ti ti-user"></i></div>
            <div class="sidebar-name">{{ auth()->user()->name }}</div>
            <div class="sidebar-role">{{ auth()->user()->role_label }}</div>
        </div>

        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="@if(request()->routeIs('admin.dashboard')) active @endif">
                <i class="ti ti-layout-dashboard"></i> داشبورد
            </a>

            <div class="menu-section">محتوای سایت</div>
            <a href="{{ route('admin.news.index') }}" class="@if(request()->routeIs('admin.news.*')) active @endif">
                <i class="ti ti-news"></i> اخبار و اطلاعیه‌ها
            </a>
            <a href="{{ route('admin.announcements.index') }}" class="@if(request()->routeIs('admin.announcements.*')) active @endif">
                <i class="ti ti-speakerphone"></i> تابلو اعلانات
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.sliders.index') }}" class="@if(request()->routeIs('admin.sliders.*')) active @endif">
                <i class="ti ti-photo"></i> اسلایدر صفحه اصلی
            </a>
            <a href="{{ route('admin.staff.index') }}" class="@if(request()->routeIs('admin.staff.*')) active @endif">
                <i class="ti ti-users-group"></i> کادر هنرستان
            </a>
            @endif

            <div class="menu-section">ثبت‌نام و مشاوره</div>
            <a href="{{ route('admin.registrations.index') }}" class="@if(request()->routeIs('admin.registrations.*')) active @endif">
                <i class="ti ti-user-plus"></i> پیش‌ثبت‌نام‌ها
            </a>
            @if(auth()->user()->isAdmin() || auth()->user()->isCounselor())
            <a href="{{ route('admin.counseling.index') }}" class="@if(request()->routeIs('admin.counseling.*')) active @endif">
                <i class="ti ti-message-circle"></i> مشاوره آنلاین
            </a>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isConferenceAdmin())
            <div class="menu-section">سامانه همایش</div>
            <a href="{{ route('admin.conference.index') }}" class="@if(request()->routeIs('admin.conference.index')) active @endif">
                <i class="ti ti-award"></i> اطلاعات همایش
            </a>
            <a href="{{ route('admin.conference.papers') }}" class="@if(request()->routeIs('admin.conference.papers')) active @endif">
                <i class="ti ti-file-text"></i> مقالات و داوری
            </a>
            <a href="{{ route('admin.conference.registrations') }}" class="@if(request()->routeIs('admin.conference.registrations')) active @endif">
                <i class="ti ti-clipboard-list"></i> ثبت‌نام‌کنندگان
            </a>
            @endif

            @if(auth()->user()->isAdmin())
            <div class="menu-section">مدیریت سیستم</div>
            <a href="{{ route('admin.users') }}" class="@if(request()->routeIs('admin.users')) active @endif">
                <i class="ti ti-shield-check"></i> کاربران و نقش‌ها
            </a>
            <a href="{{ route('admin.reports.index') }}" class="@if(request()->routeIs('admin.reports.*')) active @endif">
                <i class="ti ti-report"></i> گزارش‌ها و اقدامات
            </a>
            <a href="{{ route('admin.settings') }}" class="@if(request()->routeIs('admin.settings')) active @endif">
                <i class="ti ti-settings"></i> تنظیمات سایت
            </a>
            @endif

            <div class="menu-section">حساب کاربری</div>
            <a href="{{ route('panel.index') }}"><i class="ti ti-user-circle"></i> پنل شخصی</a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit()">
                <i class="ti ti-logout"></i> خروج
            </a>
            <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </nav>
    </aside>

    <main class="admin-content">
        @if(session('success'))
        <div class="alert alert-success"><i class="ti ti-circle-check"></i> {{ session('success') }}
            <button class="alert-close" onclick="this.parentElement.remove()"><i class="ti ti-x"></i></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-error"><i class="ti ti-alert-circle"></i> {{ session('error') }}
            <button class="alert-close" onclick="this.parentElement.remove()"><i class="ti ti-x"></i></button>
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-error">
            <i class="ti ti-alert-circle"></i>
            <div>لطفاً خطاهای زیر را برطرف کنید:
                <ul style="margin-top:.3rem; padding-right:1rem;">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="{{ asset('js/main.js') }}"></script>
@stack('scripts')
</body>
</html>
