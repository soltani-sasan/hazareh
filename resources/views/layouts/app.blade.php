<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'هنرستان هزاره صنعت')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Vazir:300,400,500,700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-header-footer.css') }}">   {{-- فایل جدید ما --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">   {{-- اگر قبلاً داشتید --}}
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header-footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/template.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header-real.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-layout.css') }}">
    @stack('styles')
    
</head>
<body>

    <!-- HEADER + HERO -->
    @include('partials.header')

    <!-- محتوای اصلی صفحات -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    @include('partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
    @stack('scripts')

</body>
</html>