@extends('layouts.app')

@section('title', 'هنرستان هزاره صنعت')

@section('content')

<!-- Hero Slider با انیمیشن -->
<section class="hero-slider">
    <div id="mainSlider" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
<div id="heroSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="{{ asset('storage/images/slide1.jpg') }}" class="d-block w-100" alt="">
                <div class="carousel-caption animate__animated animate__fadeInLeftBig">
                    <h1>مرکز تربیت نیروی متخصص</h1>
                    <h2 class="text-warning">برای صنعت ایران</h2>
                    <a href="/pre-register" class="btn btn-warning btn-lg">ثبت‌نام کنید</a>
                </div>
            </div>
            <div class="carousel-item active">
                <img src="{{ asset('storage/images/slide1.jpg') }}" class="d-block w-100" alt="اسلاید 1">
                <div class="carousel-caption animate__animated animate__fadeInLeft">
                    <h1>مرکز تربیت نیروی متخصص</h1>
                    <h2 class="text-warning">برای صنعت ایران</h2>
                    <a href="{{ route('pre-register') }}" class="btn btn-warning btn-lg">ثبت‌نام آنلاین</a>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('storage/images/slide2.jpg') }}" class="d-block w-100" alt="اسلاید 2">
                <div class="carousel-caption animate__animated animate__fadeInRight">
                    <h1>اولین هنرستان جوار صنعت</h1>
                    <p>غرب کشور</p>
                    <a href="{{ route('fields.index') }}" class="btn btn-outline-light btn-lg">رشته‌ها</a>
                </div>
            </div>

            <!-- اسلاید سوم (می‌توانید اضافه کنید) -->
            <div class="carousel-item">
                <img src="{{ asset('storage/images/slide3.jpg') }}" class="d-block w-100" alt="اسلاید 3">
                <div class="carousel-caption animate__animated animate__fadeInUp">
                    <h1>آموزش مهارت‌محور</h1>
                    <p>همگام با صنعت</p>
                </div>
            </div>
<div class="carousel-item active">
                <img src="{{ asset('storage/images/slide1.jpg') }}" class="d-block w-100" alt="">
                <div class="carousel-caption animate__animated animate__fadeInLeftBig">
                    <h1>مرکز تربیت نیروی متخصص</h1>
                    <h2 class="text-warning">برای صنعت ایران</h2>
                    <a href="/pre-register" class="btn btn-warning btn-lg">ثبت‌نام کنید</a>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>

@endsection