@extends('layouts.admin')
@section('title', $member->exists ? 'ویرایش عضو کادر' : 'عضو جدید')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;">
    <i class="ti ti-users-group"></i> {{ $member->exists ? 'ویرایش عضو کادر' : 'افزودن عضو جدید' }}
</h1>
<div class="card"><div class="card-body" style="padding:1.5rem;">
    <form action="{{ $member->exists ? route('admin.staff.update', $member->id) : route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($member->exists) @method('PUT') @endif
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">نام و نام خانوادگی <span class="required">*</span></label>
                <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $member->full_name) }}">
            </div>
            <div class="form-group">
                <label class="form-label">سمت / عنوان شغلی</label>
                <input type="text" name="role_title" class="form-control" value="{{ old('role_title', $member->role_title) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">بخش</label>
            <select name="department" class="form-control">
                <option value="teaching" {{ old('department',$member->department)=='teaching'?'selected':'' }}>کادر آموزشی</option>
                <option value="research" {{ old('department',$member->department)=='research'?'selected':'' }}>کادر پژوهشی</option>
                <option value="admin" {{ old('department',$member->department)=='admin'?'selected':'' }}>کادر اداری</option>
                <option value="pta" {{ old('department',$member->department)=='pta'?'selected':'' }}>انجمن اولیا و مربیان</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">عکس پروفایل</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
        </div>
        <div class="form-group">
            <label class="form-label">بیوگرافی کوتاه</label>
            <textarea name="bio" class="form-control" rows="3">{{ old('bio', $member->bio) }}</textarea>
        </div>
        <div class="form-group">
            <label style="display:flex; gap:.5rem; align-items:center; cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active ?? true) ? 'checked' : '' }}> نمایش در سایت
            </label>
        </div>
        <button type="submit" class="btn btn-accent btn-lg"><i class="ti ti-device-floppy"></i> ذخیره</button>
        <a href="{{ route('admin.staff.index') }}" class="btn btn-outline btn-lg">انصراف</a>
    </form>
</div></div>
@endsection
