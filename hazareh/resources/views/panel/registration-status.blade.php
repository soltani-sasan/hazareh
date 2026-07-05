@extends('layouts.app')
@section('title', 'وضعیت ثبت‌نام')

@section('content')
<section class="section">
    <div class="container">
        <div class="form-card text-center">
            <h1 class="form-title"><i class="ti ti-clipboard-check" style="color:var(--accent)"></i> وضعیت ثبت‌نام</h1>
            @if($student)
            <div style="padding:1.5rem;">
                <span class="badge
                    @switch($student->enrollment_status)
                        @case('accepted') badge-success @break
                        @case('rejected') badge-danger @break
                        @case('waiting') badge-warning @break
                        @default badge-primary
                    @endswitch
                " style="font-size:1rem; padding:.5rem 1.5rem;">{{ $student->status_label }}</span>

                <table class="data-table mt-3" style="text-align:right;">
                    <tr><th style="width:40%">رشته</th><td>{{ $student->field_label }}</td></tr>
                    <tr><th>پایه</th><td>{{ ['10'=>'دهم','11'=>'یازدهم','12'=>'دوازدهم'][$student->grade] ?? $student->grade }}</td></tr>
                    @if($student->enrollment_note)
                    <tr><th>توضیحات مدیر</th><td>{{ $student->enrollment_note }}</td></tr>
                    @endif
                </table>
            </div>
            @else
            <p class="text-muted">اطلاعات ثبت‌نام تحصیلی برای حساب شما یافت نشد.</p>
            @endif
        </div>
    </div>
</section>
@endsection
