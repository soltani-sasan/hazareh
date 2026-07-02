@extends('layouts.admin')
@section('title', 'گزارش‌ها و اقدامات')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;"><i class="ti ti-report"></i> ثبت و مشاهده گزارش‌ها</h1>
<div class="form-group">
    <label class="form-label">فایل پیوست (تصویر، فیلم یا PDF)</label>
    <input type="file" name="attachment" class="form-control"
           accept="image/*,video/*,.pdf">
</div>
<div style="display:grid; grid-template-columns:1fr 1.5fr; gap:1.5rem;">
    <div class="card"><div class="card-body">
        <h3 style="font-weight:700; color:var(--primary); margin-bottom:1rem; font-size:.95rem;">ثبت گزارش جدید</h3>
        <form action="{{ route('admin.reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">عنوان <span class="required">*</span></label>
                <input type="text" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">نوع</label>
                <select name="type" class="form-control">
                    <option value="action">اقدام انجام‌شده</option>
                    <option value="visit">بازدید</option>
                    <option value="future">کار آتی</option>
                    <option value="general">عمومی</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">تاریخ</label>
                <input type="date" name="report_date" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">شرح</label>
                <textarea name="body" class="form-control" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-accent btn-block"><i class="ti ti-plus"></i> ثبت گزارش</button>
        </form>
    </div></div>

    <div class="card">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>عنوان</th><th>نوع</th><th>تاریخ</th><th>ثبت‌کننده</th></tr></thead>
                <tbody>
                    @forelse($reports as $r)
                    <tr>
                        <td>{{ $r->title }}</td>
                        <td><span class="badge badge-primary">{{ $r->type_label }}</span></td>
                        <td>{{ $r->report_date ? verta($r->report_date)->format('Y/n/j') : '—' }}</td>
                        <td>{{ $r->author->name ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">گزارشی ثبت نشده است</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
