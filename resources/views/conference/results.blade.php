@extends('layouts.app')
@section('title', 'نتایج داوری همایش')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">نتایج نهایی</span>
            <h1 class="section-title">مقالات پذیرفته‌شده</h1>
            <div class="section-line"></div>
        </div>

        @foreach($tracks as $key => $t)
        @if(isset($accepted[$key]) && $accepted[$key]->count())
        <h3 style="font-size:1rem; font-weight:700; color:var(--primary); margin:1.5rem 0 1rem; display:flex; align-items:center; gap:.4rem;">
            <i class="ti ti-{{ $t['icon'] }}" style="color:var(--accent)"></i> {{ $t['name'] }}
        </h3>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>عنوان مقاله</th><th>نویسنده</th><th>وضعیت</th></tr></thead>
                <tbody>
                    @foreach($accepted[$key] as $paper)
                    <tr>
                        <td>{{ $paper->title }}</td>
                        <td>{{ $paper->author->name ?? '—' }}</td>
                        <td><span class="badge badge-success">پذیرفته شده</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        @endforeach

        @if($accepted->isEmpty())
        <div class="card"><div class="card-body text-center" style="padding:2.5rem;">
            <i class="ti ti-clock" style="font-size:2rem; color:var(--text-muted);"></i>
            <p class="text-muted mt-2">نتایج داوری هنوز اعلام نشده است. لطفاً بعداً مراجعه کنید.</p>
        </div></div>
        @endif
    </div>
</section>
@endsection
