@extends('layouts.admin')
@section('title', 'نتایج داوری')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;"><i class="ti ti-medal"></i> خلاصه نتایج داوری</h1>
<div class="panel-grid" style="grid-template-columns:repeat(5,1fr);">
    <div class="panel-widget"><div class="panel-widget-label">ارسال‌شده</div><div class="panel-widget-value">{{ $summary['submitted'] }}</div></div>
    <div class="panel-widget"><div class="panel-widget-label">در حال داوری</div><div class="panel-widget-value">{{ $summary['under_review'] }}</div></div>
    <div class="panel-widget"><div class="panel-widget-label">پذیرفته</div><div class="panel-widget-value" style="color:var(--success)">{{ $summary['accepted'] }}</div></div>
    <div class="panel-widget"><div class="panel-widget-label">رد شده</div><div class="panel-widget-value" style="color:var(--danger)">{{ $summary['rejected'] }}</div></div>
    <div class="panel-widget"><div class="panel-widget-label">نیاز به اصلاح</div><div class="panel-widget-value" style="color:var(--warning)">{{ $summary['revision'] }}</div></div>
</div>

<div class="card mt-3">
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>عنوان مقاله</th><th>تعداد داوری</th><th>میانگین امتیاز</th><th>وضعیت</th></tr></thead>
            <tbody>
                @forelse($papers as $p)
                <tr>
                    <td>{{ Str::limit($p->title, 40) }}</td>
                    <td>{{ $p->reviews->count() }}</td>
                    <td>{{ $p->average_score ?: '—' }}</td>
                    <td><span class="badge badge-primary">{{ $p->status_label }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">داده‌ای موجود نیست</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
