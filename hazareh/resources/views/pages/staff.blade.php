@extends('layouts.app')
@section('title', $title)

@section('content')
<section class="conf-hero" style="padding:2.5rem 0;">
    <div class="container"><h1 class="conf-title" style="font-size:1.5rem;">{{ $title }}</h1></div>
</section>
<section class="section">
    <div class="container">
        <div class="grid-4">
            @forelse($staff as $member)
            <div class="card text-center">
                <img src="{{ $member->photo ? asset('storage/staff/'.$member->photo) : asset('images/avatar-placeholder.png') }}"
                     alt="{{ $member->full_name }}" style="width:100%; height:160px; object-fit:cover;">
                <div class="card-body">
                    <h3 class="card-title" style="font-size:.92rem;">{{ $member->full_name }}</h3>
                    @if($member->role_title)<p class="card-date">{{ $member->role_title }}</p>@endif
                </div>
            </div>
            @empty
            <p class="text-center text-muted" style="grid-column:1/-1; padding:2rem;">اطلاعاتی ثبت نشده است.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
