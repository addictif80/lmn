@extends('layouts.front')
@section('title', $category->name . ' - Galerie LetiMNails')
@section('content')

<section class="page-header">
    <div class="container">
        <div class="breadcrumb" style="justify-content:center">
            <a href="{{ route('galerie') }}">Galerie</a>
            <span>/</span>
            <span>{{ $category->name }}</span>
        </div>
        <h1>{{ $category->name }}</h1>
        @if($category->description)
        <p>{{ $category->description }}</p>
        @endif
    </div>
</section>

<div class="container section">
    @if($items->count() > 0)
    <div class="gallery-grid">
        @foreach($items as $item)
        <div class="gallery-card" onclick="openLightbox('{{ asset('storage/' . $item->image) }}', '{{ $item->reference ? 'Réf: ' . $item->reference : '' }}')">
            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title ?? $category->name }}" loading="lazy">
            <div class="gallery-overlay">
                @if($item->title)
                <h3>{{ $item->title }}</h3>
                @endif
                @if($item->reference)
                <p style="font-size:0.9rem;font-weight:600">Réf: {{ $item->reference }}</p>
                @endif
                @if($item->description)
                <p style="font-size:0.85rem;margin-top:5px">{{ $item->description }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div style="text-align:center;padding:60px 0">
        <h3>Aucune image dans cette catégorie</h3>
        <a href="{{ route('galerie') }}" class="btn btn-outline" style="margin-top:15px">Retour à la galerie</a>
    </div>
    @endif
</div>

<div class="modal-overlay" id="lightbox">
    <div class="modal" style="max-width:800px;padding:20px;text-align:center;background:transparent;box-shadow:none">
        <img id="lightbox-img" src="" alt="" style="max-height:80vh;border-radius:12px;margin:0 auto;box-shadow:0 20px 60px rgba(0,0,0,0.3)">
        <p id="lightbox-ref" style="color:white;margin-top:15px;font-weight:500"></p>
        <button style="position:absolute;top:20px;right:20px;background:white;border:none;width:40px;height:40px;border-radius:50%;font-size:1.5rem;cursor:pointer" onclick="closeLightbox()">&times;</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openLightbox(src, ref) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox-ref').textContent = ref;
    document.getElementById('lightbox').classList.add('open');
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
}
document.getElementById('lightbox')?.addEventListener('click', function(e) {
    if (e.target === this) closeLightbox();
});
</script>
@endpush
