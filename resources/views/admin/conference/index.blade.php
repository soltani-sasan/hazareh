@extends('layouts.admin')
@section('title', 'اطلاعات همایش')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;"><i class="ti ti-award"></i> ویرایش اطلاعات همایش</h1>
<div class="card"><div class="card-body" style="padding:1.5rem; max-width:700px;">
    <form action="{{ route('admin.conference.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">عنوان همایش <span class="required">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $conference->title ?? '') }}">
        </div>
        <div class="form-group">
            <label class="form-label">توضیحات</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $conference->description ?? '') }}</textarea>
        </div>
        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">تاریخ شروع <span class="required">*</span></label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $conference->start_date ?? '') }}">
            </div>
            <div class="form-group">
                <label class="form-label">تاریخ پایان <span class="required">*</span></label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $conference->end_date ?? '') }}">
            </div>
            <div class="form-group">
                <label class="form-label">مهلت ارسال مقاله <span class="required">*</span></label>
                <input type="date" name="submission_deadline" class="form-control" value="{{ old('submission_deadline', $conference->submission_deadline ?? '') }}">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">محل برگزاری</label>
            <input type="text" name="venue" class="form-control" value="{{ old('venue', $conference->venue ?? '') }}">
        </div>
        <div class="form-group">
            <label style="display:flex; gap:.5rem; align-items:center; cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $conference->is_active ?? true) ? 'checked' : '' }}> نمایش فعال در سایت
            </label>
        </div>
        <button type="submit" class="btn btn-accent btn-lg"><i class="ti ti-device-floppy"></i> ذخیره تغییرات</button>
    </form>
</div></div>
@endsection
