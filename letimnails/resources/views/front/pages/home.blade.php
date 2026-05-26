@extends('layouts.front')

@section('title', 'LetiMNails - Press On Nails Personnalisables')
@section('meta_description', 'Bienvenue sur LetiMNails. Commandez des Press On Nails sur mesure et 100% personnalisables. Faux ongles fabriqués main, tenue jusqu\'à 1 mois.')

@section('content')
<!-- Hero Slider -->
<section class="hero-section">
    @forelse($sliders as $slider)
    <div class="hero-slide">
        <div class="hero-bg" style="background-image: url('{{ asset('storage/' . $slider->image) }}')"></div>
        <div class="hero-content">
            @if($slider->title)
            <h1>{{ $slider->title }}</h1>
            @endif
            @if($slider->subtitle)
            <p>{{ $slider->subtitle }}</p>
            @endif
            @if($slider->button_text && $slider->button_url)
            <a href="{{ $slider->button_url }}" class="btn btn-lg btn-primary">{{ $slider->button_text }}</a>
            @endif
        </div>
    </div>
    @empty
    <div class="hero-slide">
        <div class="hero-bg" style="background-image: linear-gradient(135deg, #eecccc 0%, #d4a0a0 100%)"></div>
        <div class="hero-content">
            <h1>LetiMNails</h1>
            <p>Des ongles sublimes, 100% personnalisables, fabriqués main avec amour</p>
            <a href="{{ route('boutique') }}" class="btn btn-lg btn-primary">Découvrir la boutique</a>
        </div>
    </div>
    @endforelse
</section>

<!-- Features Bar -->
<section class="features-bar">
    <div class="container">
        <div class="feature-item">
            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            <span>Fait main avec amour</span>
        </div>
        <div class="feature-item">
            <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
            <span>{{ $shippingInfo }}</span>
        </div>
        <div class="feature-item">
            <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            <span>Réutilisables à l'infini</span>
        </div>
        <div class="feature-item">
            <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            <span>Colle ou gel pads inclus</span>
        </div>
    </div>
</section>

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Nos produits phares</h2>
            <p>Découvrez nos sets les plus populaires</p>
        </div>
        <div class="products-grid">
            @foreach($featuredProducts as $product)
            <a href="{{ route('product.show', $product->slug) }}" class="product-card">
                <div class="product-image">
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                    @else
                    <div style="height:100%;display:flex;align-items:center;justify-content:center;color:var(--text-light);font-size:3rem">&#9998;</div>
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
        <div style="text-align:center;margin-top:40px">
            <a href="{{ route('boutique') }}" class="btn btn-outline btn-lg">Voir toute la boutique</a>
        </div>
    </div>
</section>
@endif

<!-- Nail Shapes -->
@if($shapes->count() > 0)
<section class="section section-alt">
    <div class="container">
        <div class="section-title">
            <h2>Nos formes</h2>
            <p>Choisissez la forme qui vous ressemble</p>
        </div>
        <div class="shapes-grid">
            @foreach($shapes as $shape)
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
            </div>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:40px">
            <a href="{{ route('formes') }}" class="btn btn-outline">Voir toutes les formes</a>
        </div>
    </div>
</section>
@endif

<!-- Gallery -->
@if($galleryCategories->count() > 0)
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Galerie</h2>
            <p>Inspirez-vous de nos réalisations</p>
        </div>
        <div class="gallery-categories">
            @foreach($galleryCategories as $cat)
            <a href="{{ route('galerie.category', $cat->slug) }}" class="gallery-cat-card">
                <img src="{{ $cat->image ? asset('storage/' . $cat->image) : 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 400 300%22%3E%3Crect fill=%22%23eecccc%22 width=%22400%22 height=%22300%22/%3E%3Ctext x=%22200%22 y=%22150%22 text-anchor=%22middle%22 fill=%22%232d2d2d%22 font-size=%2220%22%3E' . $cat->name . '%3C/text%3E%3C/svg%3E' }}" alt="{{ $cat->name }}" loading="lazy">
                <div class="cat-overlay">
                    <h3>{{ $cat->name }}</h3>
                </div>
            </a>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:20px">
            <a href="{{ route('galerie') }}" class="btn btn-outline">Voir toute la galerie</a>
        </div>
    </div>
</section>
@endif

<!-- Quote CTA -->
<section class="cta-section">
    <div class="container">
        <h2>Envie d'un projet unique ?</h2>
        <p>Créez vos press on nails 100% personnalisés selon vos envies</p>
        <a href="{{ route('devis') }}" class="btn btn-lg btn-secondary">Demander un devis personnalisé</a>
    </div>
</section>

<!-- Testimonials -->
@if($testimonials->count() > 0)
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Ce que nos clientes disent</h2>
            <p>Leurs avis parlent pour nous</p>
        </div>
        <div class="testimonials-grid">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-card">
                <div class="stars">
                    @for($i = 0; $i < $testimonial->rating; $i++)
                    &#9733;
                    @endfor
                    @for($i = $testimonial->rating; $i < 5; $i++)
                    &#9734;
                    @endfor
                </div>
                <p>&laquo; {{ $testimonial->content }} &raquo;</p>
                <div class="author">- {{ $testimonial->name }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- FAQ -->
@if($faqs->count() > 0)
<section class="section section-alt">
    <div class="container">
        <div class="section-title">
            <h2>Foire aux questions</h2>
            <p>Tout ce que vous devez savoir</p>
        </div>
        <div class="faq-list">
            @foreach($faqs as $faq)
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    {{ $faq->question }}
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="faq-answer">
                    {{ $faq->answer }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Bottom CTA -->
<section class="cta-section">
    <div class="container">
        <h2>Prête à craquer ?</h2>
        <p>Rejoignez l'aventure LetiMNails et sublimez vos ongles</p>
        <div style="display:flex;gap:15px;justify-content:center;flex-wrap:wrap">
            <a href="{{ route('boutique') }}" class="btn btn-lg btn-secondary">Acheter maintenant</a>
            <a href="{{ route('reservation') }}" class="btn btn-lg btn-outline" style="border-color:var(--secondary);color:var(--secondary)">Réserver une prestation</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function toggleFaq(element) {
    const item = element.parentElement;
    item.classList.toggle('active');
}
</script>
@endpush
