@extends('layouts.app')
@section('title', 'ثبت‌نام در همایش')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-card">
            <h1 class="form-title"><i class="ti ti-user-check" style="color:var(--accent)"></i> ثبت‌نام در همایش بین‌المللی</h1>

            <form action="{{ route('conference.register.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">نام و نام خانوادگی <span class="required">*</span></label>
                    <input type="text" name="full_name" class="form-control @error('full_name') error @enderror" value="{{ old('full_name') }}">
                    @error('full_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">کد ملی</label>
                        <input type="text" name="national_id" class="form-control en-num" maxlength="10" value="{{ old('national_id') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">نوع شرکت‌کننده <span class="required">*</span></label>
                        <select name="participant_type" class="form-control">
                            <option value="public" {{ old('participant_type')=='public'?'selected':'' }}>عموم مردم</option>
                            <option value="student" {{ old('participant_type')=='student'?'selected':'' }}>هنرجو</option>
                            <option value="teacher" {{ old('participant_type')=='teacher'?'selected':'' }}>دبیر/هنرآموز</option>
                            <option value="industry" {{ old('participant_type')=='industry'?'selected':'' }}>کارکنان صنعت</option>
                            <option value="other" {{ old('participant_type')=='other'?'selected':'' }}>سایر</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">سازمان / محل کار (اختیاری)</label>
                    <input type="text" name="organization" class="form-control" value="{{ old('organization') }}">
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">ایمیل <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') error @enderror" value="{{ old('email') }}">
                        @error('email')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">موبایل <span class="required">*</span></label>
                        <input type="tel" name="phone" class="form-control en-num @error('phone') error @enderror" placeholder="09xxxxxxxxx" value="{{ old('phone') }}">
                        @error('phone')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-accent btn-block btn-lg mt-2"><i class="ti ti-send"></i> ثبت‌نام</button>
            </form>
        </div>
    </div>
</section>
@endsection
