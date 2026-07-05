@extends('layouts.app')
@section('title', $page->title)

@section('content')
<section class="conf-hero" style="padding:2.5rem 0;">
    <div class="container">
        <h1 class="conf-title" style="font-size:1.5rem;">{{ $page->title }}</h1>
    </div>
</section>
<section class="section">
    <div class="container" style="max-width:850px;">
        <div class="card"><div class="card-body" style="padding:2rem; font-size:.92rem; line-height:2;">
            {!! $page->body !!}
        </div></div>
    </div>
</section>
@endsection
