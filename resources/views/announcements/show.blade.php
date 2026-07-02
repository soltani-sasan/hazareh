@extends('layouts.app')
@section('title', $announcement->title)

@section('content')
<section class="section">
    <div class="container" style="max-width:800px;">
        <div class="card">
            <div class="card-body" style="padding:2rem;">
                <span class="card-tag accent">{{ $announcement->section_label }}</span>
                <h1 style="font-size:1.3rem; font-weight:700; color:var(--primary); margin:.75rem 0;">{{ $announcement->title }}</h1>
                <p class="card-date mb-3"><i class="ti ti-calendar"></i> {{ verta($announcement->created_at)->format('Y، j F') }}</p>
                <div style="font-size:.92rem; line-height:2; color:var(--text);">{!! nl2br(e($announcement->body)) !!}</div>
            </div>
        </div>
        <a href="{{ route('announcements.index') }}" class="btn btn-outline mt-3"><i class="ti ti-arrow-right"></i> بازگشت به تابلو اعلانات</a>
    </div>
</section>
@endsection
