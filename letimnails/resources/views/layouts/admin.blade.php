<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration LetiMNails')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .admin-sidebar { background: #1a1a2e; }
        .admin-sidebar nav a svg { width:18px;height:18px; }
        .admin-table .actions { display:flex;gap:5px; }
        .admin-table .actions form { display:inline; }
        .admin-card { background:var(--white);border-radius:var(--radius);padding:25px;margin-bottom:25px;border:1px solid #eee; }
        .admin-card h3 { margin-bottom:15px;font-size:1.1rem; }
        .form-row { display:grid;grid-template-columns:1fr 1fr;gap:15px; }
        .btn-danger { background:#e74c3c;color:white; }
        .btn-danger:hover { background:#c0392b;color:white; }
        .btn-warning { background:#f39c12;color:white; }
        .btn-warning:hover { background:#d68910;color:white; }
        .grid-3 { display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:15px; }
        .stat-card-admin { background:var(--white);border-radius:var(--radius);padding:20px;text-align:center;border:1px solid #eee; }
        .stat-card-admin .num { font-size:2rem;font-weight:700;color:var(--primary-dark); }
        .stat-card-admin .lbl { font-size:0.85rem;color:var(--text-light);margin-top:5px; }
        .inline-form { display:inline; }
        .admin-sidebar .section-title { padding:10px 15px;font-size:0.75rem;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,0.4);margin-top:15px; }
        @media(max-width:768px) { .form-row { grid-template-columns:1fr; } .admin-main { padding:15px; } }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="logo">
                <a href="{{ route('admin.dashboard') }}">LetiMNails</a>
                <p style="font-size:0.75rem;opacity:0.5;font-weight:400">Administration</p>
            </div>
            <nav>
                <div class="section-title">Gestion</div>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Tableau de bord
                </a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                    Produits
                </a>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Commandes
                </a>
                <a href="{{ route('admin.quotes') }}" class="{{ request()->routeIs('admin.quotes*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    Devis
                </a>
                <a href="{{ route('admin.appointments') }}" class="{{ request()->routeIs('admin.appointments*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Rendez-vous
                </a>

                <div class="section-title">Contenu</div>
                <a href="{{ route('admin.gallery.categories') }}" class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Galerie
                </a>
                <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/></svg>
                    Catégories
                </a>
                <a href="{{ route('admin.shapes') }}" class="{{ request()->routeIs('admin.shapes*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 22 22 2 22 12 2"/></svg>
                    Formes d'ongles
                </a>
                <a href="{{ route('admin.pages') }}" class="{{ request()->routeIs('admin.pages*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    Pages CMS
                </a>
                <a href="{{ route('admin.faqs') }}" class="{{ request()->routeIs('admin.faqs*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    FAQ
                </a>
                <a href="{{ route('admin.testimonials') }}" class="{{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    Avis
                </a>
                <a href="{{ route('admin.sliders') }}" class="{{ request()->routeIs('admin.sliders*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Sliders
                </a>

                <div class="section-title">Configuration</div>
                <a href="{{ route('admin.appointments.types') }}" class="{{ request()->routeIs('admin.appointments.types*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>
                    Types de prestation
                </a>
                <a href="{{ route('admin.settings.general') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    Paramètres
                </a>
                <a href="{{ route('admin.media') }}" class="{{ request()->routeIs('admin.media*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Médiathèque
                </a>
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Utilisateurs
                </a>

                <div class="section-title">Site</div>
                <a href="{{ route('home') }}" target="_blank">&#8599; Voir le site</a>
                <form method="POST" action="{{ route('logout') }}" style="margin-top:5px">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:rgba(255,255,255,0.7);padding:12px 15px;cursor:pointer;width:100%;text-align:left;border-radius:var(--radius-sm);font-size:0.9rem">&#8592; Déconnexion</button>
                </form>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-header">
                <h1>@yield('title', 'Tableau de bord')</h1>
                <div style="display:flex;align-items:center;gap:15px">
                    <span style="font-size:0.9rem;color:var(--text-light)">{{ auth()->user()?->name }}</span>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
