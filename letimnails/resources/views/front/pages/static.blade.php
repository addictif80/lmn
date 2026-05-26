@extends('layouts.front')
@section('title', $page->title)
@section('meta_description', $page->meta_description)

@section('content')
<section class="page-header">
    <div class="container">
        <h1>{{ $page->title }}</h1>
    </div>
</section>

<div class="container">
    <div class="page-content">
        {!! $page->content !!}
    </div>
</div>
@endsection
