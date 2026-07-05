@extends('layouts.app')
@section('title', 'تماس با ما')

@section('content')
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">در ارتباط باشید</span>
            <h1 class="section-title">تماس با هنرستان</h1>
            <div class="section-line"></div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1.3fr; gap:2rem;">
            <div class="card">
                <div class="card-body">
                    <h3 style="font-size:1rem; font-weight:700; color:var(--primary); margin-bottom:1.25rem;">اطلاعات تماس</h3>
                    <ul class="footer-contact" style="color:var(--text);">
                        <li style="display:flex; gap:.6rem; margin-bottom:1rem;"><i class="ti ti-map-pin" style="color:var(--accent)"></i> [آدرس کامل هنرستان]</li>
                        <li style="display:flex; gap:.6rem; margin-bottom:1rem;"><i class="ti ti-phone" style="color:var(--accent)"></i> [شماره تلفن]</li>
                        <li style="display:flex; gap:.6rem; margin-bottom:1rem;"><i class="ti ti-mail" style="color:var(--accent)"></i> info@hazareh.ir</li>
                        <li style="display:flex; gap:.6rem; margin-bottom:1rem;"><i class="ti ti-clock" style="color:var(--accent)"></i> شنبه تا چهارشنبه ۷:۳۰ — ۱۴:۳۰</li>
                    </ul>
                    <div style="border-radius:var(--radius); overflow:hidden; margin-top:1rem;">
                        <iframe src="https://maps.google.com/maps?q=هنرستان+هزاره+صنعت&output=embed&hl=fa"
                                width="100%" height="180" style="border:0;" loading="lazy" title="موقعیت هنرستان"></iframe>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3 style="font-size:1rem; font-weight:700; color:var(--primary); margin-bottom:1.25rem;">ارسال پیام</h3>
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">نام و نام خانوادگی <span class="required">*</span></label>
                            <input type="text" name="full_name" class="form-control @error('full_name') error @enderror" value="{{ old('full_name') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">ایمیل</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">پیام شما <span class="required">*</span></label>
                            <textarea name="message" class="form-control @error('message') error @enderror" rows="5">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-accent btn-block"><i class="ti ti-send"></i> ارسال پیام</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
