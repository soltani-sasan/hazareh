@extends('layouts.app')
@section('title', 'مشاوره آنلاین')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-card">
            <h1 class="form-title"><i class="ti ti-message-circle" style="color:var(--accent)"></i> مشاوره آنلاین</h1>
            <div style="background:rgba(26,58,92,.06); border-radius:var(--radius); padding:1rem; margin-bottom:1.5rem; font-size:.82rem; color:var(--text-muted); text-align:center;">
                <i class="ti ti-shield-lock"></i> این بخش کاملاً خصوصی است و فقط برای مدیر و مشاور هنرستان قابل مشاهده می‌باشد.
            </div>

            <form action="{{ route('counseling.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">ارسال از جانب <span class="required">*</span></label>
                    <select name="sender_type" class="form-control @error('sender_type') error @enderror">
                        <option value="student" {{ old('sender_type')=='student'?'selected':'' }}>دانش‌آموز</option>
                        <option value="parent" {{ old('sender_type')=='parent'?'selected':'' }}>والدین</option>
                    </select>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">نام و نام خانوادگی <span class="required">*</span></label>
                        <input type="text" name="full_name" class="form-control @error('full_name') error @enderror" value="{{ old('full_name') }}">
                        @error('full_name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">کد ملی <span class="required">*</span></label>
                        <input type="text" name="national_id" class="form-control en-num @error('national_id') error @enderror" maxlength="10" value="{{ old('national_id') }}">
                        @error('national_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">نام و نام خانوادگی پدر/مادر</label>
                    <input type="text" name="parent_name" class="form-control" value="{{ old('parent_name') }}">
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">تلفن منزل</label>
                        <input type="tel" name="home_phone" class="form-control en-num" value="{{ old('home_phone') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">شماره موبایل <span class="required">*</span></label>
                        <input type="tel" name="mobile" class="form-control en-num @error('mobile') error @enderror" placeholder="09xxxxxxxxx" value="{{ old('mobile') }}">
                        @error('mobile')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">آدرس ایمیل</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">ارسال پاسخ از طریق <span class="required">*</span></label>
                        <select name="reply_via" class="form-control">
                            <option value="sms" {{ old('reply_via')=='sms'?'selected':'' }}>پیامک</option>
                            <option value="email" {{ old('reply_via')=='email'?'selected':'' }}>ایمیل</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">موضوع پیام <span class="required">*</span></label>
                    <input type="text" name="subject" class="form-control @error('subject') error @enderror" value="{{ old('subject') }}">
                    @error('subject')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label style="display:flex; gap:.5rem; align-items:center; cursor:pointer; font-size:.85rem;">
                        <input type="checkbox" name="is_private" value="1" checked> این مشاوره کاملاً خصوصی باشد
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-label">متن پیام <span class="required">*</span></label>
                    <textarea name="message" class="form-control @error('message') error @enderror" rows="5">{{ old('message') }}</textarea>
                    @error('message')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="btn btn-accent btn-block btn-lg mt-2"><i class="ti ti-send"></i> ارسال پیام</button>
            </form>

            <p class="text-center mt-3" style="font-size:.85rem;">
                <a href="{{ route('counseling.track') }}"><i class="ti ti-search"></i> پیگیری پیام‌های قبلی</a>
            </p>
        </div>
    </div>
</section>
@endsection
