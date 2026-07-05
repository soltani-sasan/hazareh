@extends('layouts.app')
@section('title', 'ارسال مقاله به همایش')

@section('content')
<section class="section">
    <div class="container">
        @auth
        <div class="form-card">
            <h1 class="form-title"><i class="ti ti-file-upload" style="color:var(--accent)"></i> ارسال مقاله به همایش</h1>

            <form action="{{ route('conference.submit.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">عنوان مقاله <span class="required">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') error @enderror" value="{{ old('title') }}">
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">محور مرتبط <span class="required">*</span></label>
                    <select name="track" class="form-control @error('track') error @enderror">
                        <option value="">انتخاب کنید</option>
                        @foreach($tracks as $key => $t)
                        <option value="{{ $key }}" {{ old('track')==$key?'selected':'' }}>{{ $t['name'] }}</option>
                        @endforeach
                    </select>
                    @error('track')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">چکیده مقاله <span class="required">*</span></label>
                    <textarea name="abstract" class="form-control @error('abstract') error @enderror" rows="5">{{ old('abstract') }}</textarea>
                    <p class="form-hint">حداقل ۵۰ کاراکتر</p>
                    @error('abstract')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">کلیدواژه‌ها (با کاما جدا کنید)</label>
                    <input type="text" name="keywords" class="form-control" value="{{ old('keywords') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">فایل کامل مقاله <span class="required">*</span></label>
                    <div class="form-upload" onclick="document.getElementById('paper-file').click()">
                        <input type="file" id="paper-file" name="file" accept=".pdf,.doc,.docx" style="display:none" required>
                        <i class="ti ti-upload"></i>
                        <p>کلیک کنید تا فایل مقاله را انتخاب کنید</p>
                        <p style="font-size:.72rem; margin-top:.25rem">PDF یا Word — حداکثر ۱۰ مگابایت</p>
                    </div>
                    @error('file')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn btn-accent btn-block btn-lg mt-2"><i class="ti ti-send"></i> ارسال مقاله</button>
            </form>
        </div>
        @else
        <div class="form-card text-center">
            <i class="ti ti-lock" style="font-size:2.5rem; color:var(--text-muted);"></i>
            <h3 style="margin:1rem 0 .5rem; color:var(--primary);">برای ارسال مقاله ابتدا وارد شوید</h3>
            <p class="text-muted mb-3" style="font-size:.85rem;">برای پیگیری وضعیت داوری مقاله، نیاز به ورود یا ساخت حساب کاربری دارید.</p>
            <div style="display:flex; gap:.75rem; justify-content:center;">
                <a href="{{ route('login') }}" class="btn btn-accent">ورود</a>
                <a href="{{ route('register.form') }}" class="btn btn-outline">ثبت‌نام</a>
            </div>
        </div>
        @endauth
    </div>
</section>
@endsection
