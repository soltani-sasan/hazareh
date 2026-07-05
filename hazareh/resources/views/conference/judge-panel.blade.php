@extends('layouts.app')
@section('title', 'پنل داوری')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">سامانه همایش</span>
            <h1 class="section-title">پنل داوران — مقالات در انتظار داوری</h1>
            <div class="section-line"></div>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr><th>عنوان مقاله</th><th>نویسنده</th><th>محور</th><th>تاریخ ارسال</th><th>وضعیت داوری شما</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse($papers as $paper)
                    <tr>
                        <td>{{ $paper->title }}</td>
                        <td>{{ $paper->author->name ?? '—' }}</td>
                        <td>{{ $paper->track_label }}</td>
                        <td>{{ verta($paper->submitted_at)->format('Y/n/j') }}</td>
                        <td>
                            @if($reviewedIds->contains($paper->id))
                                <span class="badge badge-success">داوری شده</span>
                            @else
                                <span class="badge badge-warning">در انتظار داوری</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('conference.judge.review', $paper->id) }}" class="btn btn-sm btn-primary">
                                <i class="ti ti-clipboard-text"></i> داوری
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted">مقاله‌ای برای داوری موجود نیست</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
