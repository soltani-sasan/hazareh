@extends('layouts.app')
@section('title', $pageTitle ?? 'اخبار و اطلاعیه‌ها')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">اطلاع‌رسانی</span>
            <h1 class="section-title">{{ $pageTitle ?? 'اخبار و اطلاعیه‌ها' }}</h1>
            <div class="section-line"></div>
        </div>

        {{-- Filters --}}
        <form method="GET" style="display:flex; gap:.75rem; flex-wrap:wrap; justify-content:center; margin-bottom:2rem;">
            <select name="category" class="form-control" style="width:auto;" onchange="this.form.submit()">
                <option value="">همه رشته‌ها</option>
                <option value="general" {{ request('category')=='general'?'selected':'' }}>عمومی</option>
                <option value="electrical" {{ request('category')=='electrical'?'selected':'' }}>برق صنعتی</option>
                <option value="mechanical" {{ request('category')=='mechanical'?'selected':'' }}>تاسیسات مکانیکی</option>
                <option value="instrumentation" {{ request('category')=='instrumentation'?'selected':'' }}>ابزار دقیق</option>
            </select>
            <select name="grade" class="form-control" style="width:auto;" onchange="this.form.submit()">
                <option value="">همه پایه‌ها</option>
                <option value="10" {{ request('grade')=='10'?'selected':'' }}>دهم</option>
                <option value="11" {{ request('grade')=='11'?'selected':'' }}>یازدهم</option>
                <option value="12" {{ request('grade')=='12'?'selected':'' }}>دوازدهم</option>
            </select>
            <select name="type" class="form-control" style="width:auto;" onchange="this.form.submit()">
                <option value="">خبر و اطلاعیه</option>
                <option value="news" {{ request('type')=='news'?'selected':'' }}>فقط خبر</option>
                <option value="notice" {{ request('type')=='notice'?'selected':'' }}>فقط اطلاعیه</option>
            </select>
        </form>

        <div class="grid-3">
            @forelse($news as $item)
            <div class="card">
                <img src="{{ $item->image ? asset('storage/news/'.$item->image) : asset('images/news-placeholder.jpg') }}"
                     alt="{{ $item->title }}" class="card-img">
                <div class="card-body">
                    <span class="card-tag {{ $item->type=='notice' ? 'accent' : '' }}">
                        {{ $item->type === 'notice' ? 'اطلاعیه' : 'خبر' }} — {{ $item->category_label }}
                    </span>
                    <h3 class="card-title"><a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a></h3>
                    <p class="card-date"><i class="ti ti-calendar"></i> {{ verta($item->published_at)->format('Y/n/j') }}</p>
                    <p class="card-excerpt">{{ Str::limit(strip_tags($item->body), 100) }}</p>
                </div>
            </div>
            @empty
            <p class="text-center text-muted" style="grid-column:1/-1; padding:2rem;">خبری یافت نشد.</p>
            @endforelse
        </div>

        <div class="mt-3">{{ $news->links() }}</div>
    </div>
</section>
@endsection
