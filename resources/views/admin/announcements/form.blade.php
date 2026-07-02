@extends('layouts.admin')
@section('title', $announcement->exists ? 'ویرایش اعلان' : 'اعلان جدید')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;">
    <i class="ti ti-speakerphone"></i> {{ $announcement->exists ? 'ویرایش اعلان' : 'افزودن اعلان جدید' }}
</h1>
<div class="card"><div class="card-body" style="padding:1.5rem;">
    <form action="{{ $announcement->exists ? route('admin.announcements.update', $announcement->id) : route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($announcement->exists) @method('PUT') @endif
        <div class="form-group">
            <label class="form-label">عنوان <span class="required">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $announcement->title) }}">
        </div>
        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">بخش</label>
                <select name="section" class="form-control">
                    <option value="educational" {{ old('section',$announcement->section)=='educational'?'selected':'' }}>آموزشی</option>
                    <option value="counseling" {{ old('section',$announcement->section)=='counseling'?'selected':'' }}>مشاوره‌ای</option>
                    <option value="nurturing" {{ old('section',$announcement->section)=='nurturing'?'selected':'' }}>پرورشی</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">اولویت (۰ تا ۱۰)</label>
                <input type="number" name="priority" class="form-control en-num" min="0" max="10" value="{{ old('priority',$announcement->priority ?? 0) }}">
            </div>
            <div class="form-group">
                <label class="form-label">تاریخ انقضا (اختیاری)</label>
                <input type="date" name="expires_at" class="form-control" value="{{ old('expires_at', $announcement->expires_at) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">متن اعلان <span class="required">*</span></label>
            <textarea name="body" class="form-control" rows="6">{{ old('body', $announcement->body) }}</textarea>
        </div>
        <div class="form-group">
            <label style="display:flex; gap:.5rem; align-items:center; cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $announcement->is_active ?? true) ? 'checked' : '' }}> فعال باشد
            </label>
        </div>
        <div class="form-group">
    <label class="form-label">پیوست (تصویر، فیلم یا PDF)</label>
    <input type="file" name="attachment" class="form-control"
           accept="image/*,video/*,.pdf">
    <p class="form-hint">حداکثر ۲۰ مگابایت — JPG، PNG، MP4، PDF</p>
    @if(isset($announcement) && $announcement->attachment)
        <p class="form-hint mt-1">
            <a href="{{ asset('storage/'.$announcement->attachment) }}" target="_blank">
                مشاهده فایل فعلی
            </a>
        </p>
    @endif
</div>
        <button type="submit" class="btn btn-accent btn-lg"><i class="ti ti-device-floppy"></i> ذخیره</button>
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-outline btn-lg">انصراف</a>
    </form>
</div></div>
@endsection
