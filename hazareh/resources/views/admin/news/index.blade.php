@extends('layouts.admin')
@section('title', 'مدیریت اخبار')

@section('content')
<div class="d-flex justify-between align-center mb-3">
    <h1 style="font-size:1.2rem; font-weight:700; color:var(--primary);"><i class="ti ti-news"></i> مدیریت اخبار و اطلاعیه‌ها</h1>
    <a href="{{ route('admin.news.create') }}" class="btn btn-accent"><i class="ti ti-plus"></i> خبر جدید</a>
</div>

<form method="GET" class="mb-3"><input type="text" name="q" class="form-control" style="max-width:300px;" placeholder="جست‌وجوی عنوان..." value="{{ request('q') }}"></form>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>عنوان</th><th>دسته</th><th>پایه</th><th>نوع</th><th>وضعیت</th><th>تاریخ</th><th>عملیات</th></tr></thead>
            <tbody>
                @forelse($news as $item)
                <tr>
                    <td>{{ Str::limit($item->title, 40) }}</td>
                    <td>{{ $item->category_label }}</td>
                    <td>{{ $item->grade == 'all' ? 'همه' : $item->grade }}</td>
                    <td>{{ $item->type == 'notice' ? 'اطلاعیه' : 'خبر' }}</td>
                    <td>
                        <form action="{{ route('admin.news.publish', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="badge {{ $item->is_published ? 'badge-success' : 'badge-warning' }}" style="border:none; cursor:pointer;">
                                {{ $item->is_published ? 'منتشرشده' : 'پیش‌نویس' }}
                            </button>
                        </form>
                    </td>
                    <td>{{ verta($item->created_at)->format('Y/n/j') }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-outline"><i class="ti ti-edit"></i></a>
                        <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('حذف شود؟')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted">خبری ثبت نشده است</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-2">{{ $news->links() }}</div>
@endsection
