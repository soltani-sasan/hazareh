<header class="site-header">

    <div class="header-top">
        <div class="container">

            <div>
                <small>اولین هنرستان جوار صنعت غرب کشور</small>
            </div>

            <div>
                <small>{{ verta()->format('Y/m/d') }}</small>
            </div>

        </div>
    </div>

    <div class="header-middle">

        <div class="container">

            <div class="logo-right">

                <img src="{{ asset('images/logos/moe-logo.png') }}" alt="">

                <img src="{{ asset('images/logos/hazareh-logo.png') }}" alt="">

            </div>

            <div class="header-title">

                <h1>هنرستان هزاره صنعت</h1>

                <h2>اولین هنرستان جوار صنعت غرب کشور</h2>

            </div>

            <div class="logo-left">

                <img src="{{ asset('images/logos/petrochemical-logo.png') }}" alt="">

                <img src="{{ asset('images/logos/refinery-logo.png') }}" alt="">

                <img src="{{ asset('images/logos/tvto-logo.png') }}" alt="">

            </div>

        </div>

    </div>

    <nav class="main-menu">

        <div class="container">

            <ul>

                <li><a href="{{ route('home') }}">صفحه اصلی</a></li>

                <li>
                    <a href="{{ route('about') }}">درباره هنرستان</a>

                    <ul>

                        <li><a href="{{ route('about') }}">معرفی</a></li>

                        <li><a href="{{ route('about.goals') }}">اهداف</a></li>

                        <li><a href="{{ route('about.facilities') }}">امکانات</a></li>

                        <li><a href="{{ route('staff.teaching') }}">کادر آموزشی</a></li>

                        <li><a href="{{ route('staff.executive') }}">کادر اجرایی</a></li>

                    </ul>

                </li>

                <li>
                    <a href="{{ route('fields.index') }}">رشته‌ها</a>
                </li>

                <li>
                    <a href="{{ route('news.index') }}">اخبار</a>
                </li>

                <li>
                    <a href="{{ route('conference.index') }}">همایش</a>
                </li>

                <li>
                    <a href="{{ route('contact') }}">تماس با ما</a>
                </li>

                @auth

                <li>

                    <a href="{{ route('panel.index') }}">پنل کاربری</a>

                </li>

                @else

                <li>

                    <a href="{{ route('login') }}">ورود</a>

                </li>

                @endauth

            </ul>

        </div>

    </nav>

</header>