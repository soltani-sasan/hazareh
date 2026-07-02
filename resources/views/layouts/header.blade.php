<header class="top-header">

    <div class="top-bar">
        <div class="container">

            <div class="top-right">
                <i class="ti ti-map-pin"></i>
                شهرستان چوار - استان ایلام
            </div>

            <div class="top-left">

                @guest
                    <a href="{{ route('login') }}">
                        <i class="ti ti-login"></i>
                        ورود
                    </a>

                    <a href="{{ route('pre-register') }}">
                        <i class="ti ti-user-plus"></i>
                        پیش ثبت نام
                    </a>
                @endguest

                @auth
                    <a href="{{ route('panel.index') }}">
                        <i class="ti ti-user"></i>
                        پنل کاربری
                    </a>

                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        خروج
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                @endauth

            </div>

        </div>
    </div>

    <div class="header-banner">

        <div class="container banner-container">

            <div class="logo-right">
                <img src="{{ asset('images/logos/hazareh-logo.png') }}" alt="">
            </div>

            <div class="header-title">
                <h1>هنرستان هزاره صنعت</h1>
                <h2>اولین هنرستان جوار صنعت غرب کشور</h2>
            </div>

            <div class="logo-left">
                <img src="{{ asset('images/logos/moe-logo.png') }}" alt="">
            </div>

        </div>

    </div>

    <nav class="main-menu">

        <div class="container">

            <ul>

                <li><a href="{{ route('home') }}">صفحه اصلی</a></li>

                <li><a href="{{ route('about') }}">درباره هنرستان</a></li>

                <li><a href="{{ route('fields.index') }}">رشته‌ها</a></li>

                <li><a href="{{ route('news.index') }}">اخبار</a></li>

                <li><a href="{{ route('announcements.index') }}">اطلاعیه‌ها</a></li>

                <li><a href="{{ route('conference.index') }}">همایش</a></li>

                <li><a href="{{ route('counseling.form') }}">مشاوره</a></li>

                <li><a href="{{ route('contact') }}">تماس با ما</a></li>

            </ul>

        </div>

    </nav>

</header>