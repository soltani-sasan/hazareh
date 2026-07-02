@extends('layouts.app')
@section('title', $conference->title ?? 'همایش بین‌المللی')

@section('content')
<section class="conf-hero">
    <div class="container">
        <span class="conf-badge"><i class="ti ti-award"></i> اولین دوره</span>
        <h1 class="conf-title">{{ $conference->title ?? 'اولین همایش بین‌المللی هنرستان‌های جوار صنعت' }}</h1>
        <p style="opacity:.8; font-size:.92rem; max-width:650px; margin:0 auto;">
            با همکاری پتروشیمی، پالایشگاه گاز و اداره کل آموزش فنی و حرفه‌ای
        </p>

        @if($conference)
        <div id="conf-countdown" data-target="{{ $conference->start_date }}T08:00:00">
            <div class="countdown">
                <div class="countdown-unit"><div class="countdown-num" id="cd-days">۰۰</div><div class="countdown-label">روز</div></div>
                <div class="countdown-sep">:</div>
                <div class="countdown-unit"><div class="countdown-num" id="cd-hours">۰۰</div><div class="countdown-label">ساعت</div></div>
                <div class="countdown-sep">:</div>
                <div class="countdown-unit"><div class="countdown-num" id="cd-mins">۰۰</div><div class="countdown-label">دقیقه</div></div>
                <div class="countdown-sep">:</div>
                <div class="countdown-unit"><div class="countdown-num" id="cd-secs">۰۰</div><div class="countdown-label">ثانیه</div></div>
            </div>
        </div>

        <div class="conf-meta">
            <span><i class="ti ti-calendar"></i> {{ verta($conference->start_date)->format('Y/n/j') }} تا {{ verta($conference->end_date)->format('Y/n/j') }}</span>
            <span><i class="ti ti-map-pin"></i> {{ $conference->venue }}</span>
            <span><i class="ti ti-clock"></i> مهلت ارسال مقاله: {{ verta($conference->submission_deadline)->format('Y/n/j') }}</span>
        </div>
        @endif

        <div style="display:flex; gap:.75rem; justify-content:center; margin-top:1.5rem; flex-wrap:wrap;">
            <a href="{{ route('conference.register') }}" class="btn btn-accent btn-lg"><i class="ti ti-user-check"></i> ثبت‌نام در همایش</a>
            <a href="{{ route('conference.submit') }}" class="btn btn-outline btn-lg" style="color:#fff; border-color:rgba(255,255,255,.4)"><i class="ti ti-file-upload"></i> ارسال مقاله</a>
        </div>
    </div>
</section>

{{-- Tracks --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">محورهای همایش</span>
            <h2 class="section-title">محورهای موضوعی</h2>
            <div class="section-line"></div>
        </div>
        <div class="conf-tracks">
            @foreach($tracks as $key => $t)
            <div class="track-card">
                <i class="track-icon ti ti-{{ $t['icon'] }}"></i>
                <h3 class="track-name">{{ $t['name'] }}</h3>
                <ul class="track-topics">
                    @foreach($t['topics'] as $topic)<li>{{ $topic }}</li>@endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Programs & Participants --}}
<section class="section section-gray">
    <div class="container">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem;">
            <div class="card">
                <div class="card-body">
                    <h3 style="font-size:1rem; font-weight:700; color:var(--primary); margin-bottom:1rem;">
                        <i class="ti ti-calendar-event" style="color:var(--accent)"></i> برنامه‌های همایش
                    </h3>
                    <ul style="font-size:.88rem; line-height:2;">
                        <li><i class="ti ti-point" style="color:var(--accent)"></i> ارائه مقالات علمی</li>
                        <li><i class="ti ti-point" style="color:var(--accent)"></i> کارگاه‌های عملی تخصصی</li>
                        <li><i class="ti ti-point" style="color:var(--accent)"></i> سخنرانی‌های تخصصی صنعت</li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3 style="font-size:1rem; font-weight:700; color:var(--primary); margin-bottom:1rem;">
                        <i class="ti ti-users" style="color:var(--accent)"></i> شرکت‌کنندگان
                    </h3>
                    <p style="font-size:.88rem; line-height:1.9; color:var(--text-muted);">
                        عموم مردم، فرهنگیان، هنرجویان، دبیران و هنرآموزان، مدیران و کارکنان صنایع پتروشیمی و پالایشگاه
                    </p>
                </div>
            </div>
        </div>

        @if($partners->count())
        <div class="text-center mt-3">
            <h3 style="font-size:.95rem; font-weight:700; color:var(--primary); margin-bottom:1rem;">حامیان و همکاران همایش</h3>
            <div style="display:flex; justify-content:center; gap:2rem; flex-wrap:wrap;">
                @foreach($partners as $p)
                <span class="badge badge-primary" style="font-size:.85rem; padding:.5rem 1.2rem;">{{ $p->name }}</span>
                @endforeach
            </div>
        </div>
        @endif

        <div style="display:flex; justify-content:center; gap:1rem; margin-top:2rem; flex-wrap:wrap;">
            <a href="{{ route('conference.schedule') }}" class="btn btn-outline"><i class="ti ti-calendar"></i> برنامه زمانی</a>
            <a href="{{ route('conference.results') }}" class="btn btn-outline"><i class="ti ti-medal"></i> نتایج داوری</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>initCountdown();</script>
@endpush
