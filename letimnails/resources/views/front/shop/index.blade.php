@extends('layouts.front')
@section('title', 'Boutique - LetiMNails')
@section('content')

<section class="page-header">
    <div class="container">
        <h1>Boutique</h1>
        <p>Consultez, achetez, portez ! Retrouvez tous nos sets prêts à poser, nos bijoux et accessoires.</p>
    </div>
</section>

<div class="container" style="display:grid;grid-template-columns:280px 1fr;gap:40px;padding:40px 0">
    <aside>
        <h3 style="margin-bottom:15px">Catégories</h3>
        <nav style="display:flex;flex-direction:column;gap:8px">
            <a href="{{ route('boutique') }}" style="padding:10px 15px;border-radius:var(--radius-sm);background:!request('category') ? 'var(--primary)' : 'transparent';color:var(--text);">Tous les produits</a>
            @foreach($categories as $cat)
            <a href="{{ route('boutique', ['category' => $cat->id]) }}" style="padding:10px 15px;border-radius:var(--radius-sm);background:request('category') == $cat->id ? 'var(--primary)' : 'transparent';color:var(--text);">
                {{ $cat->name }}
            </a>
            @endforeach
        </nav>
    </aside>

    <div>
        @if($products->count() > 0)
        <div class="products-grid">
            @foreach($products as $product)
            <a href="{{ route('product.show', $product->slug) }}" class="product-card">
                <div class="product-image">
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                    @else
                    <div style="height:100%;display:flex;align-items:center;justify-content:center;color:var(--text-light)">Aucune image</div>
                    @endif
                    @if($product->hasDiscount)
                    <span class="product-badge">-{{ $product->discount_percentage }}%</span>
                    @endif
                </div>
                <div class="product-info">
                    @if($product->category)
                    <p class="category">{{ $product->category->name }}</p>
                    @endif
                    <h3>{{ $product->name }}</h3>
                    <p class="price">
                        {{ number_format($product->price, 2) }} €
                        @if($product->hasDiscount)
                        <span class="original">{{ number_format($product->compare_price, 2) }} €</span>
                        @endif
                    </p>
                </div>
            </a>
            @endforeach
        </div>
        <div class="pagination">
            {{ $products->links() }}
        </div>
        @else
        <div style="text-align:center;padding:60px 0">
            <h3>Aucun produit pour le moment</h3>
            <p style="color:var(--text-light);margin-top:10px">Revenez bientôt, de nouveaux articles arrivent !</p>
        </div>
        @endif
    </div>
</div>
@endsection
