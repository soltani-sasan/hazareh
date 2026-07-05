@extends('layouts.admin')
@section('title', 'مدیریت اسلایدر')

@section('content')
<div class="d-flex justify-between align-center mb-3">
    <h1 style="font-size:1.2rem; font-weight:700; color:var(--primary);"><i class="ti ti-photo"></i> مدیریت اسلایدر صفحه اصلی</h1>
    <a href="{{ route('admin.sliders.create') }}" class="btn btn-accent"><i class="ti ti-plus"></i> اسلاید جدید</a>
</div>
<div class="grid-4">
    @forelse($sliders as $s)
    <div class="card">
        <img src="{{ asset('storage/sliders/'.$s->image) }}" class="card-img" alt="{{ $s->title }}" style="height:130px;">
        <div class="card-body">
            <h3 class="card-title" style="font-size:.88rem;">{{ $s->title ?: '—' }}</h3>
            <span class="badge {{ $s->is_active ? 'badge-success' : 'badge-danger' }}">{{ $s->is_active ? 'فعال' : 'غیرفعال' }}</span>
            <div class="actions mt-2">
                <a href="{{ route('admin.sliders.edit', $s->id) }}" class="btn btn-sm btn-outline"><i class="ti ti-edit"></i></a>
                <form action="{{ route('admin.sliders.destroy', $s->id) }}" method="POST" onsubmit="return confirm('حذف شود؟')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <p class="text-muted text-center" style="grid-column:1/-1;">اسلایدی ثبت نشده است</p>
    @endforelse
</div>
@endsection
