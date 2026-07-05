@extends('layouts.app')
@section('title', 'نظرات و پیشنهادات')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-card">
            <h1 class="form-title"><i class="ti ti-messages" style="color:var(--accent)"></i> نظرات، پیشنهادات و نقاط قوت/ضعف</h1>
            <form action="{{ route('feedback.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">نوع پیام <span class="required">*</span></label>
                    <select name="type" class="form-control">
                        <option value="suggestion">پیشنهاد</option>
                        <option value="strength">نقطه قوت</option>
                        <option value="weakness">نقطه ضعف</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">نام (اختیاری)</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">ایمیل (اختیاری)</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">متن پیام <span class="required">*</span></label>
                    <textarea name="message" class="form-control @error('message') error @enderror" rows="5">{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="btn btn-accent btn-block btn-lg"><i class="ti ti-send"></i> ارسال</button>
            </form>
        </div>
    </div>
</section>
@endsection
