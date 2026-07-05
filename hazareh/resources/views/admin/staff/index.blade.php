@extends('layouts.admin')
@section('title', 'مدیریت کادر هنرستان')

@section('content')
<div class="d-flex justify-between align-center mb-3">
    <h1 style="font-size:1.2rem; font-weight:700; color:var(--primary);"><i class="ti ti-users-group"></i> مدیریت کادر هنرستان</h1>
    <a href="{{ route('admin.staff.create') }}" class="btn btn-accent"><i class="ti ti-plus"></i> عضو جدید</a>
</div>
<div class="card">
    <div class="table-wrap">
        <table class="data-table">
            <thead><tr><th>نام و نام خانوادگی</th><th>سمت</th><th>بخش</th><th>وضعیت</th><th></th></tr></thead>
            <tbody>
                @forelse($staff as $s)
                <tr>
                    <td>{{ $s->full_name }}</td>
                    <td>{{ $s->role_title }}</td>
                    <td>{{ $s->department_label }}</td>
                    <td><span class="badge {{ $s->is_active ? 'badge-success' : 'badge-danger' }}">{{ $s->is_active ? 'فعال' : 'غیرفعال' }}</span></td>
                    <td class="actions">
                        <a href="{{ route('admin.staff.edit', $s->id) }}" class="btn btn-sm btn-outline"><i class="ti ti-edit"></i></a>
                        <form action="{{ route('admin.staff.destroy', $s->id) }}" method="POST" onsubmit="return confirm('حذف شود؟')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">عضوی ثبت نشده است</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
