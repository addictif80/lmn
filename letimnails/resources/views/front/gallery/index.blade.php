@extends('layouts.front')
@section('title', 'Galerie - LetiMNails')
@section('content')

<section class="page-header">
    <div class="container">
        <h1>Galerie</h1>
        <p>Grâce à notre galerie, consultez les différentes possibilités de personnalisation. Chaque création possède une référence, que vous pouvez indiquer lors de votre demande de devis.</p>
    </div>
</section>

<div class="container">
    <div class="gallery-categories">
        @forelse($categories as $cat)
        <a href="{{ route('galerie.category', $cat->slug) }}" class="gallery-cat-card">
            <img src="{{ $cat->image ? asset('storage/' . $cat->image) : 'https://placehold.co/600x400/eecccc/2d2d2d?text=' . urlencode($cat->name) }}" alt="{{ $cat->name }}" loading="lazy">
            <div class="cat-overlay">
                <h3>{{ $cat->name }}</h3>
                @if($cat->description)
                <p style="font-size:0.85rem;opacity:0.8">{{ $cat->description }}</p>
                @endif
            </div>
        </a>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:60px 0">
            <h3>Galerie en cours de construction</h3>
            <p style="color:var(--text-light)">Revenez bientôt pour découvrir nos réalisations !</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
