@extends('layouts.app')
@section('title', 'پیش‌ثبت‌نام هنرستان هزاره صنعت')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-card">
            <h1 class="form-title">
                <i class="ti ti-user-plus" style="color:var(--accent)"></i>
                پیش‌ثبت‌نام هنرجویان جدید — سال تحصیلی ۱۴۰۵–۱۴۰۴
            </h1>

            {{-- Step Bar --}}
            <div class="form-step-bar">
                <div class="form-step">
                    <div class="step-circle active">۱</div>
                    <div class="step-label">احراز هویت</div>
                </div>
                <div class="step-line"></div>
                <div class="form-step">
                    <div class="step-circle">۲</div>
                    <div class="step-label">اطلاعات کامل</div>
                </div>
                <div class="step-line"></div>
                <div class="form-step">
                    <div class="step-circle">۳</div>
                    <div class="step-label">تأیید و ارسال</div>
                </div>
            </div>

            <form action="{{ route('pre-register.store') }}" method="POST" enctype="multipart/form-data" id="reg-form">
                @csrf

                {{-- ── Step 1: NID + Instructions ── --}}
                <div class="form-step-panel" id="step-1">
                    <div style="background:rgba(224,123,0,.07); border:1px solid rgba(224,123,0,.3); border-radius:var(--radius); padding:1.25rem; margin-bottom:1.5rem;">
                        <h3 style="font-size:.95rem; font-weight:700; color:var(--accent-dark); margin-bottom:.75rem;">
                            <i class="ti ti-info-circle"></i> راهنمای پیش‌ثبت‌نام — لطفاً قبل از ادامه بخوانید
                        </h3>
                        <ul style="font-size:.84rem; color:var(--text); line-height:2; padding-right:1rem;">
                            <li>• تمامی اعداد را به صورت <strong>انگلیسی</strong> وارد کنید (مثال: ۱۲۳ اشتباه است — 123 صحیح)</li>
                            <li>• برای تکمیل فرآیند ثبت‌نام، به <strong>کارت آزمون</strong> نیاز دارید</li>
                            <li>• <strong>عکس هدایت تحصیلی</strong> را آماده نگه دارید (فرمت JPG یا PDF، حداکثر ۵ مگابایت)</li>
                            <li>• پس از ارسال فرم، نتیجه از طریق پیامک و یا پروفایل کاربری اعلام می‌شود</li>
                            <li>• رشته‌های موجود: برق صنعتی، تاسیسات مکانیکی، تعمیرکار ابزار دقیق (پایه دهم)</li>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="national_id">
                            کد ملی <span class="required">*</span>
                        </label>
                        <input type="text" id="national_id" name="national_id"
                               class="form-control en-num @error('national_id') error @enderror"
                               placeholder="10 رقم — به انگلیسی" maxlength="10" value="{{ old('national_id') }}">
                        <p class="form-hint">مثال صحیح: 1234567890 — مثال اشتباه: ۱۲۳۴۵۶۷۸۹۰</p>
                        @error('national_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="mobile">
                            تلفن همراه <span class="required">*</span>
                        </label>
                        <input type="tel" id="mobile" name="mobile"
                               class="form-control en-num @error('mobile') error @enderror"
                               placeholder="09xxxxxxxxx" maxlength="11" value="{{ old('mobile') }}">
                        @error('mobile')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div style="text-align:left; margin-top:1.5rem">
                        <button type="button" class="btn btn-accent btn-next-step">
                            مرحله بعد <i class="ti ti-arrow-left"></i>
                        </button>
                    </div>
                </div>

                {{-- ── Step 2: Full Information ── --}}
                <div class="form-step-panel d-none" id="step-2">

                    <div class="form-section-title">مشخصات هنرجو</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="first_name">نام <span class="required">*</span></label>
                            <input type="text" id="first_name" name="first_name"
                                   class="form-control @error('first_name') error @enderror"
                                   value="{{ old('first_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="last_name">نام خانوادگی <span class="required">*</span></label>
                            <input type="text" id="last_name" name="last_name"
                                   class="form-control @error('last_name') error @enderror"
                                   value="{{ old('last_name') }}" required>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="birth_date">تاریخ تولد <span class="required">*</span></label>
                            <input type="text" id="birth_date" name="birth_date"
                                   class="form-control jalali-picker @error('birth_date') error @enderror"
                                   placeholder="مثال: 1388/05/12" value="{{ old('birth_date') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_phone">تلفن محل سکونت</label>
                            <input type="tel" id="home_phone" name="home_phone"
                                   class="form-control en-num"
                                   placeholder="08xxxxxxxx" value="{{ old('home_phone') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="introducer_name">نام و نام خانوادگی معرف</label>
                        <input type="text" id="introducer_name" name="introducer_name"
                               class="form-control" value="{{ old('introducer_name') }}">
                    </div>

                    <div class="form-section-title">مشخصات پدر</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="father_name">نام پدر <span class="required">*</span></label>
                            <input type="text" id="father_name" name="father_name"
                                   class="form-control @error('father_name') error @enderror"
                                   value="{{ old('father_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="father_mobile">موبایل پدر <span class="required">*</span></label>
                            <input type="tel" id="father_mobile" name="father_mobile"
                                   class="form-control en-num @error('father_mobile') error @enderror"
                                   placeholder="09xxxxxxxxx" value="{{ old('father_mobile') }}" required>
                        </div>
                    </div>

                    <div class="form-section-title">مشخصات مادر</div>
                    <div class="form-grid-3">
                        <div class="form-group">
                            <label class="form-label" for="mother_name">نام مادر</label>
                            <input type="text" id="mother_name" name="mother_name"
                                   class="form-control" value="{{ old('mother_name') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="mother_lastname">نام خانوادگی مادر</label>
                            <input type="text" id="mother_lastname" name="mother_lastname"
                                   class="form-control" value="{{ old('mother_lastname') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="mother_mobile">موبایل مادر</label>
                            <input type="tel" id="mother_mobile" name="mother_mobile"
                                   class="form-control en-num" placeholder="09xxxxxxxxx" value="{{ old('mother_mobile') }}">
                        </div>
                    </div>

                    <div class="form-section-title">اطلاعات مدرسه قبلی</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="prev_school">نام مدرسه قبلی <span class="required">*</span></label>
                            <input type="text" id="prev_school" name="prev_school"
                                   class="form-control @error('prev_school') error @enderror"
                                   value="{{ old('prev_school') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="prev_district">منطقه آموزشی (عدد)</label>
                            <input type="number" id="prev_district" name="prev_district"
                                   class="form-control en-num" min="1" max="20" value="{{ old('prev_district') }}">
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="prev_principal">نام مدیر مدرسه</label>
                            <input type="text" id="prev_principal" name="prev_principal"
                                   class="form-control" value="{{ old('prev_principal') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="prev_counselor">نام معلم راهنما (مشاور)</label>
                            <input type="text" id="prev_counselor" name="prev_counselor"
                                   class="form-control" value="{{ old('prev_counselor') }}">
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="last_gpa">
                                معدل نیمسال گذشته <span class="required">*</span>
                                <span style="font-size:.72rem; font-weight:400; color:var(--text-muted)">(با دو رقم اعشار، مثال: 18.50)</span>
                            </label>
                            <input type="number" id="last_gpa" name="last_gpa"
                                   class="form-control en-num @error('last_gpa') error @enderror"
                                   step="0.01" min="0" max="20" placeholder="18.50" value="{{ old('last_gpa') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="discipline_score">
                                نمره انضباط
                                <span style="font-size:.72rem; font-weight:400; color:var(--text-muted)">(با دو رقم اعشار)</span>
                            </label>
                            <input type="number" id="discipline_score" name="discipline_score"
                                   class="form-control en-num"
                                   step="0.01" min="0" max="20" placeholder="19.00" value="{{ old('discipline_score') }}">
                        </div>
                    </div>

                    <div class="form-section-title">انتخاب رشته و سایر اطلاعات</div>
                    <div class="form-group">
                        <label class="form-label" for="requested_field">رشته درخواستی <span class="required">*</span></label>
                        <select id="requested_field" name="requested_field"
                                class="form-control @error('requested_field') error @enderror" required>
                            <option value="">-- انتخاب کنید --</option>
                            <option value="electrical" {{ old('requested_field')=='electrical'?'selected':'' }}>برق صنعتی</option>
                            <option value="mechanical" {{ old('requested_field')=='mechanical'?'selected':'' }}>تاسیسات مکانیکی</option>
                            <option value="instrumentation" {{ old('requested_field')=='instrumentation'?'selected':'' }}>تعمیرکار ابزار دقیق</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="how_known">شیوه آشنایی با هنرستان</label>
                        <select id="how_known" name="how_known" class="form-control">
                            <option value="">-- انتخاب کنید --</option>
                            <option value="website" {{ old('how_known')=='website'?'selected':'' }}>سایت هنرستان</option>
                            <option value="instagram" {{ old('how_known')=='instagram'?'selected':'' }}>اینستاگرام</option>
                            <option value="friend" {{ old('how_known')=='friend'?'selected':'' }}>معرفی دوستان</option>
                            <option value="teacher" {{ old('how_known')=='teacher'?'selected':'' }}>معرفی معلم/مشاور</option>
                            <option value="industry" {{ old('how_known')=='industry'?'selected':'' }}>همکاران صنعتی</option>
                            <option value="other" {{ old('how_known')=='other'?'selected':'' }}>سایر</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="address">آدرس محل سکونت</label>
                        <textarea id="address" name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="postal_code">کدپستی</label>
                        <input type="text" id="postal_code" name="postal_code"
                               class="form-control en-num" maxlength="10" placeholder="1234567890" value="{{ old('postal_code') }}">
                    </div>

                    <div class="form-section-title">بارگذاری مدارک</div>
                    <div class="form-group">
                        <label class="form-label">عکس هدایت تحصیلی <span class="required">*</span></label>
                        <div class="form-upload" onclick="document.getElementById('guidance_doc').click()">
                            <input type="file" id="guidance_doc" name="guidance_doc"
                                   accept=".jpg,.jpeg,.png,.pdf" style="display:none" required>
                            <i class="ti ti-upload"></i>
                            <p>کلیک کنید یا فایل را اینجا رها کنید</p>
                            <p style="font-size:.72rem; margin-top:.25rem">JPG، PNG یا PDF — حداکثر ۵ مگابایت</p>
                        </div>
                        @error('guidance_doc')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div style="display:flex; justify-content:space-between; margin-top:1.5rem">
                        <button type="button" class="btn btn-outline btn-prev-step">
                            <i class="ti ti-arrow-right"></i> مرحله قبل
                        </button>
                        <button type="button" class="btn btn-accent btn-next-step">
                            مرحله بعد <i class="ti ti-arrow-left"></i>
                        </button>
                    </div>
                </div>

                {{-- ── Step 3: Review & Submit ── --}}
                <div class="form-step-panel d-none" id="step-3">
                    <div style="background:rgba(5,150,105,.07); border:1px solid rgba(5,150,105,.25); border-radius:var(--radius); padding:1.5rem; text-align:center; margin-bottom:1.5rem">
                        <i class="ti ti-circle-check" style="font-size:2.5rem; color:var(--success)"></i>
                        <h3 style="margin:.75rem 0 .5rem; color:var(--success)">اطلاعات آماده ارسال است</h3>
                        <p style="font-size:.85rem; color:var(--text-muted)">
                            لطفاً اطلاعات وارد شده را بررسی کنید. پس از ثبت، امکان ویرایش وجود ندارد.
                        </p>
                    </div>

                    <div id="review-summary" style="font-size:.85rem; line-height:2;"></div>

                    <div style="background:rgba(26,58,92,.05); border-radius:var(--radius); padding:1rem; margin:1.25rem 0; font-size:.82rem; color:var(--text-muted)">
                        <label style="display:flex; gap:.5rem; align-items:flex-start; cursor:pointer">
                            <input type="checkbox" id="confirm-check" style="margin-top:.25rem" required>
                            <span>صحت اطلاعات وارد شده را تأیید می‌کنم و متعهد می‌شوم مدارک لازم را در زمان مقرر ارائه دهم.</span>
                        </label>
                    </div>

                    <div style="display:flex; justify-content:space-between; margin-top:1.5rem">
                        <button type="button" class="btn btn-outline btn-prev-step">
                            <i class="ti ti-arrow-right"></i> مرحله قبل
                        </button>
                        <button type="submit" class="btn btn-accent" id="submit-btn">
                            <i class="ti ti-send"></i> ثبت نهایی پیش‌ثبت‌نام
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Fill review summary before step 3 shows
document.querySelector('.btn-next-step:last-of-type')?.addEventListener('click', function() {
    const fields = [
        ['نام و نام خانوادگی', document.getElementById('first_name')?.value + ' ' + document.getElementById('last_name')?.value],
        ['کد ملی', document.getElementById('national_id')?.value],
        ['موبایل', document.getElementById('mobile')?.value],
        ['تاریخ تولد', document.getElementById('birth_date')?.value],
        ['نام پدر', document.getElementById('father_name')?.value],
        ['مدرسه قبلی', document.getElementById('prev_school')?.value],
        ['معدل', document.getElementById('last_gpa')?.value],
        ['رشته درخواستی', document.getElementById('requested_field')?.options[document.getElementById('requested_field')?.selectedIndex]?.text],
    ];
    const html = fields.map(([k,v]) =>
        `<div style="display:flex; gap:.5rem; border-bottom:1px solid var(--border); padding:.3rem 0">
            <span style="font-weight:600; min-width:150px; color:var(--text-muted)">${k}:</span>
            <span>${v || '—'}</span>
        </div>`
    ).join('');
    document.getElementById('review-summary').innerHTML = html;
});

// Prevent Arabic numerals
document.querySelectorAll('.en-num').forEach(el => {
    el.addEventListener('keypress', e => {
        if (/[۰-۹\u0660-\u0669]/.test(e.key)) {
            e.preventDefault();
            alert('لطفاً اعداد را به صورت انگلیسی وارد کنید');
        }
    });
});
</script>
@endpush
