@extends('layouts.app')
@section('title', 'اخبار رشته من')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">پنل کاربری</span>
            <h1 class="section-title">اخبار مرتبط با رشته و پایه من</h1>
            <div class="section-line"></div>
        </div>
        <div class="grid-3">
            @forelse($news as $item)
            <div class="card">
                <img src="{{ $item->image ? asset('storage/news/'.$item->image) : asset('images/news-placeholder.jpg') }}" class="card-img" alt="{{ $item->title }}">
                <div class="card-body">
                    <span class="card-tag">{{ $item->category_label }}</span>
                    <h3 class="card-title"><a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a></h3>
                    <p class="card-date">{{ verta($item->published_at)->format('Y/n/j') }}</p>
                </div>
            </div>
            @empty
            <p class="text-center text-muted" style="grid-column:1/-1;">خبری یافت نشد.</p>
            @endforelse
        </div>
        <div class="mt-3">{{ $news->links() }}</div>
    </div>
</section>
@endsection
