@extends('layouts.front')
@section('title', 'Nos formes - LetiMNails')
@section('content')

<section class="page-header">
    <div class="container">
        <h1>Nos formes</h1>
        <p>Découvrez toutes les formes disponibles pour vos press on nails</p>
    </div>
</section>

<div class="container section">
    <div class="shapes-grid">
        @forelse($shapes as $shape)
        <div class="shape-card">
            <div class="shape-image">
                @if($shape->image)
                <img src="{{ asset('storage/' . $shape->image) }}" alt="{{ $shape->name }}" loading="lazy">
                @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--primary-light);font-size:2rem">&#9998;</div>
                @endif
            </div>
            <h3>{{ $shape->name }}</h3>
            @if($shape->sizes->count() > 0)
            <div class="sizes">
                @foreach($shape->sizes as $size)
                <span>{{ $size->name }}</span>
                @endforeach
            </div>
            @endif
            @if($shape->description)
            <p style="font-size:0.85rem;color:var(--text-light);margin-top:10px">{{ $shape->description }}</p>
            @endif
        </div>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:60px 0">
            <h3>Les formes arrivent bientôt</h3>
        </div>
        @endforelse
    </div>
</div>
@endsection
