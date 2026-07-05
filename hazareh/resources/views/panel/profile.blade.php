@extends('layouts.app')
@section('title', 'ویرایش پروفایل')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-card">
            <h1 class="form-title"><i class="ti ti-user-edit" style="color:var(--accent)"></i> ویرایش اطلاعات حساب</h1>
            <form action="{{ route('panel.profile.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">نام و نام خانوادگی</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">ایمیل</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">موبایل</label>
                        <input type="tel" name="phone" class="form-control en-num" value="{{ old('phone', $user->phone) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">کد ملی (غیرقابل ویرایش)</label>
                    <input type="text" class="form-control en-num" value="{{ $user->national_id }}" disabled>
                </div>
                <div class="form-section-title">تغییر رمز عبور (اختیاری)</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">رمز عبور جدید</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">تکرار رمز عبور جدید</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-accent btn-block btn-lg mt-2"><i class="ti ti-device-floppy"></i> ذخیره تغییرات</button>
            </form>
        </div>
    </div>
</section>
@endsection
