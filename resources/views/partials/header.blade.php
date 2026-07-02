<header class="main-header">
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="language-switch">
                    <a href="#" class="active">فارسی</a>
                    <a href="#">English</a>
                </div>
                <div class="date-time">
                    {{ verta()->format('l d F Y') }} | {{ verta()->format('H:i') }}
                </div>
            </div>
        </div>
    </div>

    <div class="main-nav">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="هنرستان هزاره صنعت">
                    <div class="logo-text">
                        <h1>هنرستان هزاره صنعت</h1>
                        <p>اولین هنرستان جوار صنعت غرب کشور</p>
                    </div>
                </div>

                <div class="search-box">
                    <form action="{{ url('/search') }}" method="GET">
                        <input type="text" name="q" placeholder="جستجو در سایت..." value="{{ request('q') }}">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <div class="header-actions">
    <a href="{{ route('login') }}" class="btn-login">ورود به سیستم</a>
    <a href="{{ route('pre-registration.form') }}" class="btn-pre-registration.form">فرم پیش‌نام</a>
</div>
            </div>
        </div>
    </div>

    <nav class="main-menu">
        <div class="container">
            <ul>
                <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">صفحه اصلی</a></li>
                <li><a href="#">تماس با ما</a></li>
                <li><a href="#">گالری تصاویر</a></li>
                <li><a href="#">همایش ها و رویدادها</a></li>
                <li><a href="#">دانش آموزان</a></li>
                <li><a href="#">رشته ها و دوره ها</a></li>
                <li><a href="#">امکانات و تجهیزات</a></li>
                <li><a href="#">اخبار و اطلاعیه ها</a></li>
                <li><a href="#">درباره هنرستان</a></li>
            </ul>
        </div>
    </nav>
</header>

<!-- Hero Banner - فقط صفحه اصلی -->
@if(request()->is('/'))
<section class="hero-banner">
    <img src="{{ asset('storage/images/hero-main.jpg') }}" alt="هنرستان هزاره صنعت">
    <div class="hero-overlay">
        <div class="container">
            <h2>مرکز تربیت نیروی متخصص برای صنعت ایران</h2>
            <p>آموزش مهارت‌محور، کارگاهی و صنعتی همگام با نیاز صنایع روز</p>
            <a href="{{ route('pre-registration.form') }}" class="hero-btn">ثبت‌نام آنلاین</a>
        </div>
    </div>
</section>
@endif