@extends('layouts.admin')
@section('title', $news->exists ? 'ویرایش خبر' : 'خبر جدید')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;">
    <i class="ti ti-news"></i> {{ $news->exists ? 'ویرایش خبر' : 'افزودن خبر/اطلاعیه جدید' }}
</h1>

<div class="card"><div class="card-body" style="padding:1.5rem;">
    <form action="{{ $news->exists ? route('admin.news.update', $news->id) : route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($news->exists) @method('PUT') @endif

        <div class="form-group">
            <label class="form-label">عنوان <span class="required">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}">
        </div>
        <div class="form-grid-3">
            <div class="form-group">
                <label class="form-label">دسته‌بندی</label>
                <select name="category" class="form-control">
                    @foreach(['general'=>'عمومی','electrical'=>'برق صنعتی','mechanical'=>'تاسیسات مکانیکی','instrumentation'=>'ابزار دقیق','extra'=>'فوق‌برنامه'] as $k=>$v)
                    <option value="{{ $k }}" {{ old('category',$news->category)==$k?'selected':'' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">پایه مخاطب</label>
                <select name="grade" class="form-control">
                    @foreach(['all'=>'همه پایه‌ها','10'=>'دهم','11'=>'یازدهم','12'=>'دوازدهم'] as $k=>$v)
                    <option value="{{ $k }}" {{ old('grade',$news->grade)==$k?'selected':'' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">نوع</label>
                <select name="type" class="form-control">
                    <option value="news" {{ old('type',$news->type)=='news'?'selected':'' }}>خبر</option>
                    <option value="notice" {{ old('type',$news->type)=='notice'?'selected':'' }}>اطلاعیه</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">تصویر شاخص</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            @if($news->image)<p class="form-hint">تصویر فعلی: {{ $news->image }}</p>@endif
        </div>
        <div class="form-group">
            <label class="form-label">متن کامل <span class="required">*</span></label>
            <textarea name="body" class="form-control" rows="10">{{ old('body', $news->body) }}</textarea>
            <p class="form-hint">امکان استفاده از تگ‌های ساده HTML وجود دارد</p>
        </div>
        <div class="form-group">
            <label style="display:flex; gap:.5rem; align-items:center; cursor:pointer;">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                انتشار فوری
            </label>
        </div>
        <button type="submit" class="btn btn-accent btn-lg"><i class="ti ti-device-floppy"></i> ذخیره</button>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline btn-lg">انصراف</a>
    </form>
</div></div>
@endsection
