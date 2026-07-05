@extends('layouts.app')
@section('title', 'ثبت‌نام کاربری')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-card">
            <h1 class="form-title"><i class="ti ti-user-plus" style="color:var(--accent)"></i> ایجاد حساب کاربری هنرجو</h1>
            <p class="text-center text-muted mb-3" style="font-size:.82rem;">
                این فرم برای ساخت حساب کاربری (پنل شخصی) است؛ برای پیش‌ثبت‌نام تحصیلی به
                <a href="{{ route('pre-register') }}">صفحه پیش‌ثبت‌نام</a> مراجعه کنید.
            </p>

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">نام <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') error @enderror" value="{{ old('name') }}">
                        @error('name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">نام خانوادگی <span class="required">*</span></label>
                        <input type="text" name="last_name" class="form-control @error('last_name') error @enderror" value="{{ old('last_name') }}">
                        @error('last_name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">کد ملی <span class="required">*</span></label>
                        <input type="text" name="national_id" class="form-control en-num @error('national_id') error @enderror" maxlength="10" value="{{ old('national_id') }}">
                        @error('national_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">موبایل <span class="required">*</span></label>
                        <input type="tel" name="phone" class="form-control en-num @error('phone') error @enderror" placeholder="09xxxxxxxxx" value="{{ old('phone') }}">
                        @error('phone')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">ایمیل (اختیاری)</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">رشته تحصیلی <span class="required">*</span></label>
                        <select name="field" class="form-control @error('field') error @enderror">
                            <option value="">انتخاب کنید</option>
                            <option value="electrical" {{ old('field')=='electrical'?'selected':'' }}>برق صنعتی</option>
                            <option value="mechanical" {{ old('field')=='mechanical'?'selected':'' }}>تاسیسات مکانیکی</option>
                            <option value="instrumentation" {{ old('field')=='instrumentation'?'selected':'' }}>تعمیرکار ابزار دقیق</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">پایه تحصیلی <span class="required">*</span></label>
                        <select name="grade" class="form-control @error('grade') error @enderror">
                            <option value="">انتخاب کنید</option>
                            <option value="10" {{ old('grade')=='10'?'selected':'' }}>دهم</option>
                            <option value="11" {{ old('grade')=='11'?'selected':'' }}>یازدهم</option>
                            <option value="12" {{ old('grade')=='12'?'selected':'' }}>دوازدهم</option>
                        </select>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">رمز عبور <span class="required">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') error @enderror">
                        @error('password')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">تکرار رمز عبور <span class="required">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-accent btn-block btn-lg mt-2">
                    <i class="ti ti-user-plus"></i> ایجاد حساب کاربری
                </button>
            </form>

            <p class="text-center mt-3" style="font-size:.85rem; color:var(--text-muted)">
                قبلاً ثبت‌نام کرده‌اید؟ <a href="{{ route('login') }}" style="font-weight:600">وارد شوید</a>
            </p>
        </div>
    </div>
</section>
@endsection
