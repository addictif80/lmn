<header class="site-header" id="site-header">
    <div class="container">
        <div class="header-inner">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="LetiMNails" loading="lazy">
            </a>

            <nav class="main-nav" id="main-nav">
                <a href="{{ route('boutique') }}" class="{{ request()->routeIs('boutique') || request()->routeIs('product.show') ? 'active' : '' }}">Boutique</a>
                <a href="{{ route('galerie') }}" class="{{ request()->routeIs('galerie*') ? 'active' : '' }}">Galerie</a>
                <a href="{{ route('formes') }}" class="{{ request()->routeIs('formes') ? 'active' : '' }}">Nos formes</a>
                <a href="{{ route('conseils') }}" class="{{ request()->routeIs('conseils') ? 'active' : '' }}">Conseils</a>
                @auth
                <a href="{{ route('account.dashboard') }}" class="{{ request()->routeIs('account.*') ? 'active' : '' }}">Mon compte</a>
                @else
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Connexion</a>
                @endauth
                <a href="{{ route('support') }}" class="{{ request()->routeIs('support') ? 'active' : '' }}">Support</a>
            </nav>

            <div class="header-actions">
                <div class="dual-btn-group">
                    <a href="{{ route('devis') }}" class="dbtn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        Devis
                    </a>
                    <span class="sep">|</span>
                    <a href="{{ route('reservation') }}" class="dbtn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Réservation
                    </a>
                </div>

                <a href="{{ route('cart') }}" class="cart-icon" title="Panier">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    @if(Cart::instance('default')->count() > 0)
                    <span class="cart-count">{{ Cart::instance('default')->count() }}</span>
                    @endif
                </a>

                <button class="mobile-toggle" id="mobile-toggle" aria-label="Menu">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('mobile-toggle');
    const nav = document.getElementById('main-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', function() {
            nav.classList.toggle('open');
        });
    }

    const header = document.getElementById('site-header');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
});
</script>
@endpush
