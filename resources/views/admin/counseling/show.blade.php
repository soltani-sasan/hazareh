@extends('layouts.admin')
@section('title', 'پاسخ به مشاوره')

@section('content')
<h1 style="font-size:1.2rem; font-weight:700; color:var(--primary); margin-bottom:1.5rem;"><i class="ti ti-message-circle"></i> جزئیات و پاسخ‌گویی</h1>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
    <div class="card"><div class="card-body">
        <h3 style="font-weight:700; color:var(--primary); margin-bottom:1rem; font-size:.95rem;">اطلاعات فرستنده</h3>
        <table class="data-table">
            <tr><th style="width:35%">ارسال از جانب</th><td>{{ $item->sender_type=='student'?'دانش‌آموز':'والدین' }}</td></tr>
            <tr><th>نام و نام خانوادگی</th><td>{{ $item->full_name }}</td></tr>
            <tr><th>کد ملی</th><td class="en-num" style="direction:ltr; text-align:right;">{{ $item->national_id }}</td></tr>
            <tr><th>نام پدر/مادر</th><td>{{ $item->parent_name }}</td></tr>
            <tr><th>موبایل</th><td style="direction:ltr; text-align:right;">{{ $item->mobile }}</td></tr>
            <tr><th>ایمیل</th><td>{{ $item->email }}</td></tr>
            <tr><th>پاسخ از طریق</th><td>{{ $item->reply_via=='sms'?'پیامک':'ایمیل' }}</td></tr>
            <tr><th>خصوصی</th><td>{{ $item->is_private ? 'بله' : 'خیر' }}</td></tr>
        </table>
        <h3 style="font-weight:700; color:var(--primary); margin:1.25rem 0 .5rem; font-size:.95rem;">{{ $item->subject }}</h3>
        <p style="font-size:.88rem; line-height:1.9; background:var(--bg); padding:1rem; border-radius:var(--radius);">{{ $item->message }}</p>
    </div></div>

    <div class="card"><div class="card-body">
        <h3 style="font-weight:700; color:var(--primary); margin-bottom:1rem; font-size:.95rem;">ثبت پاسخ</h3>
        @if($item->status == 'answered')
        <div class="alert alert-success" style="margin:0 0 1rem;">پاسخ قبلاً در {{ verta($item->responded_at)->format('Y/n/j') }} ثبت شده است.</div>
        @endif
        <form action="{{ route('admin.counseling.reply', $item->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">متن پاسخ <span class="required">*</span></label>
                <textarea name="response_text" class="form-control" rows="8">{{ old('response_text', $item->response_text) }}</textarea>
            </div>
            <button type="submit" class="btn btn-accent btn-block"><i class="ti ti-send"></i> ثبت و ارسال پاسخ</button>
        </form>
    </div></div>
</div>
@endsection
