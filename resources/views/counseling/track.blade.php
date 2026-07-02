@extends('layouts.app')
@section('title', 'پیگیری مشاوره')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-card" style="max-width:{{ ($searched ?? false) ? '760px' : '480px' }};">
            <h1 class="form-title"><i class="ti ti-search" style="color:var(--accent)"></i> پیگیری درخواست مشاوره</h1>

            <form action="{{ route('counseling.track.search') }}" method="POST" class="mb-3">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">کد ملی <span class="required">*</span></label>
                        <input type="text" name="national_id" class="form-control en-num @error('national_id') error @enderror"
                               maxlength="10" value="{{ $national_id ?? old('national_id') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">شماره موبایل <span class="required">*</span></label>
                        <input type="tel" name="mobile" class="form-control en-num @error('mobile') error @enderror"
                               value="{{ $mobile ?? old('mobile') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-accent btn-block"><i class="ti ti-search"></i> جست‌وجو</button>
            </form>

            @if($searched ?? false)
                @forelse($requests as $r)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex justify-between align-center mb-1">
                            <span class="card-tag {{ $r->status=='answered' ? '' : 'accent' }}">{{ $r->status=='answered' ? 'پاسخ داده شده' : 'در انتظار پاسخ' }}</span>
                            <span class="text-muted" style="font-size:.78rem;">{{ verta($r->created_at)->format('Y/n/j') }}</span>
                        </div>
                        <h3 class="card-title" style="font-size:.95rem;">{{ $r->subject }}</h3>
                        @if($r->status == 'answered')
                        <div style="background:rgba(5,150,105,.07); border-radius:8px; padding:.85rem; margin-top:.75rem; font-size:.85rem;">
                            <p style="font-weight:600; color:var(--success); margin-bottom:.3rem;">
                                <i class="ti ti-message-check"></i> پاسخ ({{ verta($r->responded_at)->format('Y/n/j') }})
                            </p>
                            <p>{{ $r->response_text }}</p>
                        </div>
                        @else
                        <p class="text-muted" style="font-size:.82rem;">پاسخ شما هنوز ثبت نشده است.</p>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-center text-muted">پیامی با این مشخصات یافت نشد.</p>
                @endforelse
            @endif
        </div>
    </div>
</section>
@endsection
