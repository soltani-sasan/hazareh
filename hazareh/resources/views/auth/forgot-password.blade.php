@extends('layouts.app')
@section('title', 'فراموشی رمز عبور')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-card" style="max-width:440px;">
            <h1 class="form-title"><i class="ti ti-lock-question" style="color:var(--accent)"></i> فراموشی رمز عبور</h1>
            <p class="text-center text-muted mb-3" style="font-size:.85rem;">کد ملی خود را وارد کنید تا راهنمای بازیابی رمز عبور برایتان ارسال شود.</p>

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">کد ملی <span class="required">*</span></label>
                    <input type="text" name="national_id" class="form-control en-num @error('national_id') error @enderror" maxlength="10">
                    @error('national_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn btn-accent btn-block btn-lg">
                    <i class="ti ti-send"></i> ارسال درخواست
                </button>
            </form>
            <p class="text-center mt-3" style="font-size:.85rem;"><a href="{{ route('login') }}">بازگشت به صفحه ورود</a></p>
        </div>
    </div>
</section>
@endsection
