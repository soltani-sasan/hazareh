@extends('layouts.admin')
@section('title', 'ثبت‌نام‌کنندگان همایش')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;"><i class="ti ti-clipboard-list"></i> ثبت‌نام‌کنندگان همایش</h1>
<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>نام</th><th>نوع شرکت‌کننده</th><th>سازمان</th><th>تماس</th><th>تاریخ</th></tr></thead>
            <tbody>
                @forelse($registrations as $r)
                <tr>
                    <td>{{ $r->full_name }}</td>
                    <td>{{ $r->type_label }}</td>
                    <td>{{ $r->organization ?: '—' }}</td>
                    <td>{{ $r->phone }} / {{ $r->email }}</td>
                    <td>{{ verta($r->created_at)->format('Y/n/j') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">ثبت‌نامی موجود نیست</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-2">{{ $registrations->links() }}</div>
@endsection
