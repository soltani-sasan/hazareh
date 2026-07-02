@extends('layouts.app')
@section('title', 'مقالات من')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">سامانه همایش</span>
            <h1 class="section-title">مقالات ارسالی من</h1>
            <div class="section-line"></div>
        </div>

        @forelse($papers as $paper)
        <div class="card mb-2">
            <div class="card-body">
                <div class="d-flex justify-between align-center mb-1">
                    <span class="badge
                        @switch($paper->status)
                            @case('accepted') badge-success @break
                            @case('rejected') badge-danger @break
                            @case('revision') badge-warning @break
                            @default badge-primary
                        @endswitch
                    ">{{ $paper->status_label }}</span>
                    <span class="text-muted" style="font-size:.78rem;">{{ verta($paper->submitted_at)->format('Y/n/j') }}</span>
                </div>
                <h3 class="card-title">{{ $paper->title }}</h3>
                <p class="text-muted" style="font-size:.82rem;">محور: {{ $paper->track_label }}</p>
            </div>
        </div>
        @empty
        <div class="card"><div class="card-body text-center" style="padding:2.5rem;">
            <i class="ti ti-file-off" style="font-size:2rem; color:var(--text-muted);"></i>
            <p class="text-muted mt-2">هنوز مقاله‌ای ارسال نکرده‌اید.</p>
            <a href="{{ route('conference.submit') }}" class="btn btn-accent mt-2">ارسال مقاله جدید</a>
        </div></div>
        @endforelse
    </div>
</section>
@endsection
