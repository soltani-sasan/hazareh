@extends('layouts.app')
@section('title', 'تابلو اعلانات')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">اطلاع‌رسانی داخلی</span>
            <h1 class="section-title">تابلو اعلانات هنرستان</h1>
            <div class="section-line"></div>
        </div>

        <div class="grid-3" style="align-items:start;">
            <div class="card">
                <div class="card-body">
                    <h3 style="font-size:.95rem; font-weight:700; color:var(--primary); margin-bottom:1rem; display:flex; align-items:center; gap:.4rem;">
                        <i class="ti ti-book" style="color:var(--accent)"></i> تابلو آموزشی
                    </h3>
                    @forelse($educational as $a)
                    <div class="announce-item">
                        <i class="announce-icon ti ti-pin"></i>
                        <div class="announce-text">
                            <a href="{{ route('announcements.show', $a->id) }}" class="announce-title">{{ $a->title }}</a>
                            <p class="announce-date">{{ verta($a->created_at)->format('Y/n/j') }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center" style="font-size:.82rem; padding:1rem;">اعلانی موجود نیست</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3 style="font-size:.95rem; font-weight:700; color:var(--primary); margin-bottom:1rem; display:flex; align-items:center; gap:.4rem;">
                        <i class="ti ti-message-circle" style="color:var(--accent)"></i> تابلو مشاوره‌ای
                    </h3>
                    @forelse($counseling as $a)
                    <div class="announce-item">
                        <i class="announce-icon ti ti-pin"></i>
                        <div class="announce-text">
                            <a href="{{ route('announcements.show', $a->id) }}" class="announce-title">{{ $a->title }}</a>
                            <p class="announce-date">{{ verta($a->created_at)->format('Y/n/j') }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center" style="font-size:.82rem; padding:1rem;">اعلانی موجود نیست</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3 style="font-size:.95rem; font-weight:700; color:var(--primary); margin-bottom:1rem; display:flex; align-items:center; gap:.4rem;">
                        <i class="ti ti-star" style="color:var(--accent)"></i> تابلو پرورشی
                    </h3>
                    @forelse($nurturing as $a)
                    <div class="announce-item">
                        <i class="announce-icon ti ti-pin"></i>
                        <div class="announce-text">
                            <a href="{{ route('announcements.show', $a->id) }}" class="announce-title">{{ $a->title }}</a>
                            <p class="announce-date">{{ verta($a->created_at)->format('Y/n/j') }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center" style="font-size:.82rem; padding:1rem;">اعلانی موجود نیست</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
