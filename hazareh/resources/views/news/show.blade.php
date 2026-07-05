@extends('layouts.app')
@section('title', $news->title)

@section('content')
<section class="section">
    <div class="container" style="max-width:900px;">
        <div class="card">
            <img src="{{ $news->image ? asset('storage/news/'.$news->image) : asset('images/news-placeholder.jpg') }}"
                 alt="{{ $news->title }}" class="card-img" style="height:320px;">
            <div class="card-body" style="padding:2rem;">
                <span class="card-tag accent">{{ $news->type === 'notice' ? 'اطلاعیه' : 'خبر' }} — {{ $news->category_label }}</span>
                <h1 style="font-size:1.4rem; font-weight:700; color:var(--primary); margin:.75rem 0;">{{ $news->title }}</h1>
                <p class="card-date mb-3"><i class="ti ti-calendar"></i> {{ verta($news->published_at)->format('Y، j F') }}
                    @if($news->author) &nbsp;|&nbsp; <i class="ti ti-user"></i> {{ $news->author->name }} @endif
                </p>
                <div style="font-size:.92rem; line-height:2; color:var(--text);">
                    {!! $news->body !!}
                </div>
            </div>
        </div>

        @if($related->count())
        <h3 style="font-size:1.05rem; font-weight:700; color:var(--primary); margin:2rem 0 1rem;">اخبار مرتبط</h3>
        <div class="grid-3">
            @foreach($related as $item)
            <div class="card">
                <img src="{{ $item->image ? asset('storage/news/'.$item->image) : asset('images/news-placeholder.jpg') }}" class="card-img" alt="{{ $item->title }}">
                <div class="card-body">
                    <h3 class="card-title" style="font-size:.92rem;"><a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a></h3>
                    <p class="card-date">{{ verta($item->published_at)->format('Y/n/j') }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <a href="{{ route('news.index') }}" class="btn btn-outline mt-3"><i class="ti ti-arrow-right"></i> بازگشت به اخبار</a>
    </div>
</section>
@endsection
