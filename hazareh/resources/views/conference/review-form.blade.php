@extends('layouts.app')
@section('title', 'فرم داوری مقاله')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-card">
            <h1 class="form-title"><i class="ti ti-clipboard-text" style="color:var(--accent)"></i> فرم داوری مقاله</h1>

            <div class="card mb-3" style="background:var(--bg);">
                <div class="card-body">
                    <h3 style="font-size:1rem; font-weight:700; color:var(--primary);">{{ $paper->title }}</h3>
                    <p class="text-muted" style="font-size:.82rem; margin-top:.3rem;">
                        نویسنده: {{ $paper->author->name ?? '—' }} | محور: {{ $paper->track_label }}
                    </p>
                    <p style="font-size:.85rem; margin-top:.75rem; line-height:1.8;">{{ $paper->abstract }}</p>
                    @if($paper->file_path)
                    <a href="{{ asset('storage/'.$paper->file_path) }}" target="_blank" class="btn btn-sm btn-outline mt-2">
                        <i class="ti ti-download"></i> دانلود فایل مقاله
                    </a>
                    @endif
                </div>
            </div>

            <form action="{{ route('conference.judge.review.store', $paper->id) }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">نوآوری و اصالت (از ۲۰) <span class="required">*</span></label>
                        <input type="number" name="originality" class="form-control en-num" min="0" max="20"
                               value="{{ $existingReview->originality ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">کیفیت علمی (از ۲۰) <span class="required">*</span></label>
                        <input type="number" name="quality" class="form-control en-num" min="0" max="20"
                               value="{{ $existingReview->quality ?? '' }}" required>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">ارتباط با محور (از ۲۰) <span class="required">*</span></label>
                        <input type="number" name="relevance" class="form-control en-num" min="0" max="20"
                               value="{{ $existingReview->relevance ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">کیفیت ارائه و نگارش (از ۲۰) <span class="required">*</span></label>
                        <input type="number" name="presentation" class="form-control en-num" min="0" max="20"
                               value="{{ $existingReview->presentation ?? '' }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">نظرات داور</label>
                    <textarea name="comments" class="form-control" rows="4">{{ $existingReview->comments ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">تصمیم نهایی <span class="required">*</span></label>
                    <select name="decision" class="form-control" required>
                        <option value="">انتخاب کنید</option>
                        <option value="accept" {{ ($existingReview->decision ?? '')=='accept'?'selected':'' }}>پذیرش</option>
                        <option value="revision" {{ ($existingReview->decision ?? '')=='revision'?'selected':'' }}>نیاز به اصلاح</option>
                        <option value="reject" {{ ($existingReview->decision ?? '')=='reject'?'selected':'' }}>رد</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-accent btn-block btn-lg mt-2"><i class="ti ti-check"></i> ثبت داوری</button>
            </form>
        </div>
    </div>
</section>
@endsection
