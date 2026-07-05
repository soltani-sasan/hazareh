@extends('layouts.admin')
@section('title', 'مدیریت تابلو اعلانات')

@section('content')
<div class="d-flex justify-between align-center mb-3">
    <h1 style="font-size:1.2rem; font-weight:700; color:var(--primary);"><i class="ti ti-speakerphone"></i> مدیریت تابلو اعلانات</h1>
    <a href="{{ route('admin.announcements.create') }}" class="btn btn-accent"><i class="ti ti-plus"></i> اعلان جدید</a>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>عنوان</th><th>بخش</th><th>اولویت</th><th>وضعیت</th><th>تاریخ</th><th>عملیات</th></tr></thead>
            <tbody>
                @forelse($announcements as $a)
                <tr>
                    <td>{{ Str::limit($a->title, 40) }}</td>
                    <td>{{ $a->section_label }}</td>
                    <td>{{ $a->priority }}</td>
                    <td><span class="badge {{ $a->is_active ? 'badge-success' : 'badge-danger' }}">{{ $a->is_active ? 'فعال' : 'غیرفعال' }}</span></td>
                    <td>{{ verta($a->created_at)->format('Y/n/j') }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.announcements.edit', $a->id) }}" class="btn btn-sm btn-outline"><i class="ti ti-edit"></i></a>
                        <form action="{{ route('admin.announcements.destroy', $a->id) }}" method="POST" onsubmit="return confirm('حذف شود؟')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">اعلانی ثبت نشده است</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-2">{{ $announcements->links() }}</div>
@endsection
