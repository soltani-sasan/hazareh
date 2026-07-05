@extends('layouts.app')
@section('title', 'معرفی رشته‌های تحصیلی')

@section('content')
<section class="conf-hero" style="padding:3rem 0 2.5rem;">
    <div class="container">
        <span class="conf-badge">رشته‌های تخصصی</span>
        <h1 class="conf-title">معرفی رشته‌های هنرستان هزاره صنعت</h1>
        <p style="opacity:.8; font-size:.9rem; max-width:600px; margin:0 auto;">
            سه رشته تخصصی با همکاری مستقیم پالایشگاه گاز و پتروشیمی برای تربیت نیروی متخصص صنعت
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="grid-3">
            @foreach($fields as $key => $f)
            <div class="card">
                <div style="background:linear-gradient(135deg, var(--primary), var(--primary-light)); padding:2rem; text-align:center;">
                    <i class="ti ti-{{ $f['icon'] }}" style="font-size:2.5rem; color:var(--accent-light);"></i>
                </div>
                <div class="card-body">
                    <h3 class="card-title" style="font-size:1.1rem;">{{ $f['name'] }}</h3>
                    <p class="card-excerpt">{{ $f['summary'] }}</p>
                    <a href="{{ route('fields.show', $key) }}" class="btn btn-outline btn-sm mt-2">
                        جزئیات کامل <i class="ti ti-arrow-left"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
