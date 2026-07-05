@extends('layouts.admin')
@section('title', 'تنظیمات سایت')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;"><i class="ti ti-settings"></i> تنظیمات عمومی سایت</h1>
<div class="card"><div class="card-body" style="padding:1.5rem; max-width:600px;">
    <form action="{{ route('admin.settings.save') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">نام هنرستان</label>
            <input type="text" name="site_name" class="form-control" value="هنرستان هزاره صنعت">
        </div>
        <div class="form-group">
            <label class="form-label">شماره تلفن</label>
            <input type="text" name="phone" class="form-control en-num">
        </div>
        <div class="form-group">
            <label class="form-label">ایمیل</label>
            <input type="email" name="email" class="form-control" value="info@hazareh.ir">
        </div>
        <div class="form-group">
            <label class="form-label">آدرس کامل</label>
            <textarea name="address" class="form-control" rows="2"></textarea>
        </div>
        <div class="form-group">
            <label class="form-label">لینک گوگل‌مپ</label>
            <input type="url" name="map_url" class="form-control">
        </div>
        <button type="submit" class="btn btn-accent btn-lg"><i class="ti ti-device-floppy"></i> ذخیره تنظیمات</button>
    </form>
</div></div>
@endsection
