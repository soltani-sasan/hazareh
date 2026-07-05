@extends('layouts.admin')
@section('title', 'مدیریت مشاوره آنلاین')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;"><i class="ti ti-message-circle"></i> پیام‌های مشاوره آنلاین</h1>

<form method="GET" class="mb-3">
    <select name="status" class="form-control" style="width:auto;" onchange="this.form.submit()">
        <option value="">همه</option>
        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>در انتظار پاسخ</option>
        <option value="answered" {{ request('status')=='answered'?'selected':'' }}>پاسخ داده شده</option>
    </select>
</form>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>نام</th><th>موضوع</th><th>نوع</th><th>وضعیت</th><th>تاریخ</th><th></th></tr></thead>
            <tbody>
                @forelse($requests as $r)
                <tr>
                    <td>{{ $r->full_name }} <span class="text-muted" style="font-size:.75rem;">({{ $r->sender_type=='student'?'دانش‌آموز':'والدین' }})</span></td>
                    <td>{{ Str::limit($r->subject, 30) }}</td>
                    <td>{{ $r->is_private ? 'خصوصی' : 'عمومی' }}</td>
                    <td><span class="badge {{ $r->status=='answered' ? 'badge-success' : 'badge-warning' }}">{{ $r->status=='answered' ? 'پاسخ داده شده' : 'در انتظار' }}</span></td>
                    <td>{{ verta($r->created_at)->format('Y/n/j') }}</td>
                    <td><a href="{{ route('admin.counseling.show', $r->id) }}" class="btn btn-sm btn-outline">مشاهده / پاسخ</a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">پیامی ثبت نشده است</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-2">{{ $requests->links() }}</div>
@endsection
