@extends('layouts.admin')
@section('title', $slider->exists ? 'ویرایش اسلاید' : 'اسلاید جدید')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;">
    <i class="ti ti-photo"></i> {{ $slider->exists ? 'ویرایش اسلاید' : 'افزودن اسلاید جدید' }}
</h1>
<div class="card"><div class="card-body" style="padding:1.5rem; max-width:600px;">
    <form action="{{ $slider->exists ? route('admin.sliders.update', $slider->id) : route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($slider->exists) @method('PUT') @endif
        <div class="form-group">
            <label class="form-label">تصویر {{ $slider->exists ? '' : '' }}<span class="required">*</span></label>
            <input type="file" name="image" class="form-control" accept="image/*" {{ $slider->exists ? '' : 'required' }}>
            <p class="form-hint">پیشنهاد: ابعاد ۱۹۲۰×۸۰۰ پیکسل</p>
        </div>
        <div class="form-group">
            <label class="form-label">عنوان</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $slider->title) }}">
        </div>
        <div class="form-group">
            <label class="form-label">زیرعنوان</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $slider->subtitle) }}">
        </div>
        <div class="form-group">
            <label class="form-label">لینک (اختیاری)</label>
            <input type="url" name="link" class="form-control" value="{{ old('link', $slider->link) }}">
        </div>
        <div class="form-group">
            <label class="form-label">ترتیب نمایش</label>
            <input type="number" name="sort_order" class="form-control en-num" value="{{ old('sort_order', $slider->sort_order ?? 0) }}">
        </div>
        <div class="form-group">
            <label style="display:flex; gap:.5rem; align-items:center; cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slider->is_active ?? true) ? 'checked' : '' }}> فعال باشد
            </label>
        </div>
        <button type="submit" class="btn btn-accent btn-lg"><i class="ti ti-device-floppy"></i> ذخیره</button>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline btn-lg">انصراف</a>
    </form>
</div></div>
@endsection
