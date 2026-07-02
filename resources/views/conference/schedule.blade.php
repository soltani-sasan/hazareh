@extends('layouts.app')
@section('title', 'برنامه زمانی همایش')

@section('content')
<section class="section">
    <div class="container" style="max-width:800px;">
        <div class="section-header">
            <span class="section-eyebrow">زمان‌بندی</span>
            <h1 class="section-title">برنامه زمانی همایش</h1>
            <div class="section-line"></div>
        </div>

        <div class="card">
            <div class="card-body" style="padding:2rem;">
                <div style="display:flex; flex-direction:column; gap:1.5rem;">
                    <div style="display:flex; gap:1rem; align-items:flex-start; border-right:3px solid var(--accent); padding-right:1rem;">
                        <i class="ti ti-calendar-event" style="font-size:1.4rem; color:var(--accent); margin-top:.2rem;"></i>
                        <div>
                            <h4 style="font-weight:700; color:var(--primary); font-size:.95rem;">مهلت ارسال مقالات و آثار</h4>
                            <p class="text-muted" style="font-size:.85rem;">{{ $conference ? verta($conference->submission_deadline)->format('Y/n/j') : '۲۰ فروردین ۱۴۰۳' }}</p>
                        </div>
                    </div>
                    <div style="display:flex; gap:1rem; align-items:flex-start; border-right:3px solid var(--primary); padding-right:1rem;">
                        <i class="ti ti-clipboard-check" style="font-size:1.4rem; color:var(--primary); margin-top:.2rem;"></i>
                        <div>
                            <h4 style="font-weight:700; color:var(--primary); font-size:.95rem;">اعلام نتایج داوری</h4>
                            <p class="text-muted" style="font-size:.85rem;">حداکثر دو هفته پس از مهلت ارسال</p>
                        </div>
                    </div>
                    <div style="display:flex; gap:1rem; align-items:flex-start; border-right:3px solid var(--success); padding-right:1rem;">
                        <i class="ti ti-confetti" style="font-size:1.4rem; color:var(--success); margin-top:.2rem;"></i>
                        <div>
                            <h4 style="font-weight:700; color:var(--primary); font-size:.95rem;">برگزاری همایش</h4>
                            <p class="text-muted" style="font-size:.85rem;">
                                {{ $conference ? verta($conference->start_date)->format('Y/n/j') . ' تا ' . verta($conference->end_date)->format('Y/n/j') : '۱۵ تا ۱۷ اردیبهشت ۱۴۰۳' }}
                                — {{ $conference->venue ?? 'اتاق همایش هنرستان' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-body">
                <h3 style="font-size:.95rem; font-weight:700; color:var(--primary); margin-bottom:.75rem;">
                    <i class="ti ti-users-group" style="color:var(--accent)"></i> دبیرخانه همایش
                </h3>
                <p style="font-size:.85rem; color:var(--text-muted); line-height:1.9;">
                    رئیس همایش، دبیر علمی، دبیر اجرایی و اعضای کمیته علمی هنرستان هزاره صنعت مسئولیت برگزاری این رویداد را بر عهده دارند.
                    داوران شامل ۵ استاد دانشگاه، ۲ مدیر از پالایشگاه/پتروشیمی و ۲ کارشناس صنعتی خواهند بود.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
