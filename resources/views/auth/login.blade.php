@extends('layouts.app')
@section('title', 'ورود به سامانه')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-card" style="max-width:440px;">
            <h1 class="form-title"><i class="ti ti-login" style="color:var(--accent)"></i> ورود به سامانه</h1>

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="national_id">کد ملی <span class="required">*</span></label>
                    <input type="text" id="national_id" name="national_id" class="form-control en-num @error('national_id') error @enderror"
                           maxlength="10" value="{{ old('national_id') }}" autofocus>
                    @error('national_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">رمز عبور <span class="required">*</span></label>
                    <input type="password" id="password" name="password" class="form-control @error('password') error @enderror">
                    @error('password')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="d-flex justify-between align-center mb-2" style="font-size:.82rem;">
                    <label style="display:flex; gap:.4rem; align-items:center; cursor:pointer;">
                        <input type="checkbox" name="remember"> مرا به خاطر بسپار
                    </label>
                    <a href="{{ route('password.forgot') }}">فراموشی رمز عبور؟</a>
                </div>
                <button type="submit" class="btn btn-accent btn-block btn-lg">
                    <i class="ti ti-login"></i> ورود
                </button>
            </form>

            <p class="text-center mt-3" style="font-size:.85rem; color:var(--text-muted)">
                حساب کاربری ندارید؟ <a href="{{ route('register.form') }}" style="font-weight:600">ثبت‌نام کنید</a>
            </p>
        </div>
    </div>
</section>
@endsection
