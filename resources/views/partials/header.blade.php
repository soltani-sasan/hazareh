<header class="main-header">

    <!-- Top Bar (سبک و سریع) -->
    <div class="top-bar bg-dark text-white py-2">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center small">
                <div>
                    <a href="#" class="text-white me-3 text-decoration-none">English</a>
                    <span class="text-white-50">{{ verta()->format('Y/m/d') }} • {{ verta()->format('H:i') }}</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-sm btn-light">ورود</a>
                    <a href="{{ route('pre-register') }}" class="btn btn-sm btn-warning">پیش‌نام</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="header-main py-3 text-white" style="background: linear-gradient(135deg, #0a2a5e 0%, #1e4a8c 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-4 text-center text-lg-start">
                    <img src="{{ asset('storage/images/logo-left.png') }}" alt="لوگو" loading="lazy" style="max-height: 68px;">
                </div>
                <div class="col-lg-6 col-4 text-center">
                    <h1 class="h3 fw-bold mb-1">هنرستان هزاره صنعت</h1>
                    <p class="small mb-0 opacity-90">اولین هنرستان جوار صنعت غرب کشور</p>
                </div>
                <div class="col-lg-3 col-4 text-center text-lg-end">
                    <img src="{{ asset('storage/images/logo-right.png') }}" alt="لوگو" loading="lazy" style="max-height: 82px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation - بهینه و سریع -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">صفحه اصلی</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">درباره ما</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('news.index') }}">اخبار</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('fields.index') }}">رشته‌ها</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('conference.index') }}">همایش</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">تماس</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>