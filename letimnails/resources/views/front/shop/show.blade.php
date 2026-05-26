@extends('layouts.front')
@section('title', $product->name . ' - LetiMNails')
@section('meta_description', $product->meta_description ?? Str::limit($product->short_description ?? $product->description, 160))
@section('content')

<div class="container">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a>
        <span>/</span>
        <a href="{{ route('boutique') }}">Boutique</a>
        @if($product->category)
        <span>/</span>
        <a href="{{ route('boutique', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a>
        @endif
        <span>/</span>
        <span>{{ $product->name }}</span>
    </div>

    <div class="product-detail">
        <div>
            <div class="gallery-main">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" id="main-image">
                @else
                <div style="height:500px;display:flex;align-items:center;justify-content:center;color:var(--text-light);font-size:4rem">&#9998;</div>
                @endif
            </div>
            @if($product->images->count() > 1)
            <div style="display:flex;gap:10px;margin-top:15px;overflow-x:auto;padding-bottom:10px">
                @foreach($product->images as $img)
                <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $img->alt ?? $product->name }}" style="width:80px;height:80px;object-fit:cover;border-radius:8px;cursor:pointer;border:2px solid transparent" onclick="document.getElementById('main-image').src=this.src;document.querySelectorAll('[onclick]').forEach(i=>i.style.borderColor='transparent');this.style.borderColor='var(--primary)'" loading="lazy">
                @endforeach
            </div>
            @endif
        </div>

        <div class="info">
            <h1>{{ $product->name }}</h1>
            @if($product->category)
            <p style="color:var(--text-light);font-size:0.9rem;margin-bottom:15px">{{ $product->category->name }}</p>
            @endif
            <div class="price">
                {{ number_format($product->price, 2) }} €
                @if($product->hasDiscount)
                <span style="text-decoration:line-through;color:var(--text-light);font-weight:400;font-size:1.1rem;margin-left:10px">{{ number_format($product->compare_price, 2) }} €</span>
                <span style="background:var(--primary);padding:3px 10px;border-radius:50px;font-size:0.8rem;margin-left:10px">-{{ $product->discount_percentage }}%</span>
                @endif
            </div>

            @if($product->short_description)
            <div class="description">{{ $product->short_description }}</div>
            @endif

            @if($product->description)
            <div class="description">{{ $product->description }}</div>
            @endif

            @if($product->variations->count() > 0)
            <div style="margin:20px 0">
                <label style="font-weight:600;display:block;margin-bottom:10px">Variante :</label>
                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    @foreach($product->variations as $variation)
                    <label style="display:flex;align-items:center;gap:5px;padding:8px 15px;border:1px solid var(--border);border-radius:50px;cursor:pointer">
                        <input type="radio" name="variation" value="{{ $variation->id }}" data-price="{{ $variation->price ?? $product->price }}" onchange="updatePrice(this)">
                        {{ $variation->name }}
                        @if($variation->price)
                        <span style="color:var(--primary-dark);font-weight:600">+{{ number_format($variation->price - $product->price, 2) }} €</span>
                        @endif
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            @if($product->is_active)
            <form action="{{ route('cart.add', $product->slug) }}" method="POST" style="margin-top:20px">
                @csrf
                <div style="display:flex;gap:15px;align-items:center;flex-wrap:wrap">
                    <div style="display:flex;align-items:center;border:1px solid var(--border);border-radius:50px;overflow:hidden">
                        <button type="button" style="border:none;background:none;padding:10px 15px;cursor:pointer;font-size:1.2rem" onclick="updateQty(-1)">-</button>
                        <input type="number" name="quantity" id="qty" value="1" min="1" max="99" style="width:50px;text-align:center;border:none;outline:none;font-size:1rem">
                        <button type="button" style="border:none;background:none;padding:10px 15px;cursor:pointer;font-size:1.2rem" onclick="updateQty(1)">+</button>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        Ajouter au panier
                    </button>
                </div>
            </form>
            @else
            <p style="color:var(--text-light);margin-top:20px;font-style:italic">Ce produit est temporairement indisponible.</p>
            @endif

            @if($product->is_available_for_quote)
            <div style="margin-top:20px;padding:20px;background:var(--bg-alt);border-radius:var(--radius);text-align:center">
                <p style="margin-bottom:10px">Vous souhaitez une version personnalisée ?</p>
                <a href="{{ route('devis') }}" class="btn btn-outline">Demander un devis personnalisé</a>
            </div>
            @endif
        </div>
    </div>
</div>

@if($relatedProducts->count() > 0)
<section class="section section-alt">
    <div class="container">
        <div class="section-title">
            <h2>Vous aimerez aussi</h2>
        </div>
        <div class="products-grid">
            @foreach($relatedProducts as $related)
            <a href="{{ route('product.show', $related->slug) }}" class="product-card">
                <div class="product-image">
                    @if($related->image)
                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" loading="lazy">
                    @else
                    <div style="height:100%;display:flex;align-items:center;justify-content:center;color:var(--text-light)">&#9998;</div>
                    @endif
                </div>
                <div class="product-info">
                    <h3>{{ $related->name }}</h3>
                    <p class="price">{{ number_format($related->price, 2) }} €</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
function updateQty(delta) {
    const input = document.getElementById('qty');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > 99) val = 99;
    input.value = val;
}
</script>
@endpush
