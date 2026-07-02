@extends('layouts.app')
@section('title', $data['name'])

@section('content')
<section class="conf-hero" style="padding:3rem 0 2.5rem;">
    <div class="container">
        <span class="conf-badge"><i class="ti ti-{{ $data['icon'] }}"></i> رشته تخصصی</span>
        <h1 class="conf-title">{{ $data['name'] }}</h1>
        <p style="opacity:.8; font-size:.9rem; max-width:600px; margin:0 auto;">{{ $data['summary'] }}</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div style="display:grid; grid-template-columns:2fr 1fr; gap:2rem;">
            <div>
                <div class="card mb-2">
                    <div class="card-body">
                        <h3 style="font-size:1rem; font-weight:700; color:var(--primary); margin-bottom:1rem;">
                            <i class="ti ti-target" style="color:var(--accent)"></i> اهداف آموزشی
                        </h3>
                        <ul style="font-size:.88rem; line-height:2; color:var(--text);">
                            @foreach($data['goals'] as $goal)
                            <li style="padding-right:1.2rem; position:relative; margin-bottom:.3rem;">
                                <i class="ti ti-circle-check" style="position:absolute; right:0; top:.3em; color:var(--success); font-size:.85rem;"></i>
                                {{ $goal }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-body">
                        <h3 style="font-size:1rem; font-weight:700; color:var(--primary); margin-bottom:1rem;">
                            <i class="ti ti-book" style="color:var(--accent)"></i> دروس تخصصی
                        </h3>
                        <div style="display:flex; gap:.5rem; flex-wrap:wrap;">
                            @foreach($data['courses'] as $course)
                            <span class="badge badge-primary" style="font-size:.8rem; padding:.4rem .8rem;">{{ $course }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3 style="font-size:1rem; font-weight:700; color:var(--primary); margin-bottom:1rem;">
                            <i class="ti ti-briefcase" style="color:var(--accent)"></i> فرصت‌های شغلی
                        </h3>
                        <ul style="font-size:.88rem; line-height:2; color:var(--text);">
                            @foreach($data['careers'] as $career)
                            <li style="padding-right:1.2rem; position:relative; margin-bottom:.3rem;">
                                <i class="ti ti-arrow-left" style="position:absolute; right:0; top:.3em; color:var(--accent); font-size:.8rem;"></i>
                                {{ $career }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div>
                <div class="card" style="background:var(--primary); color:#fff; border:none;">
                    <div class="card-body">
                        <i class="ti ti-building-factory-2" style="font-size:1.8rem; color:var(--accent-light)"></i>
                        <h4 style="margin:.6rem 0; font-size:.95rem;">همکاری صنعتی</h4>
                        <p style="font-size:.82rem; opacity:.85; line-height:1.7;">{{ $data['partner'] }}</p>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-body text-center">
                        <i class="ti ti-user-plus" style="font-size:1.8rem; color:var(--accent)"></i>
                        <h4 style="margin:.6rem 0; font-size:.95rem;">علاقه‌مند به این رشته‌اید؟</h4>
                        <a href="{{ route('pre-register') }}" class="btn btn-accent btn-block mt-2">پیش‌ثبت‌نام کنید</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
