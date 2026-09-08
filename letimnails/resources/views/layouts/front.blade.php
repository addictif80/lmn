<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LetiMNails') - Press On Nails Personnalisables</title>
    <meta name="description" content="@yield('meta_description', 'LetiMNails - Press On Nails sur mesure et 100% personnalisables. Faux ongles fabriqués main, tenue jusqu\'à 1 mois.')">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garant:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&family=Jost:wght@300;400;500;600&family=Arizonia&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div id="app">
        @include('front.partials.header')

        <main>
            @yield('content')
        </main>

        @include('front.partials.footer')
    </div>

    @if(session('success'))
    <div class="modal-overlay open" id="success-modal">
        <div class="modal" style="text-align:center">
            <div style="font-size:3rem;color:#4caf50;margin-bottom:15px">&#10003;</div>
            <h3 style="margin-bottom:10px">Succès !</h3>
            <p style="color:var(--text-light);margin-bottom:20px">{{ session('success') }}</p>
            <button class="btn btn-primary" onclick="document.getElementById('success-modal').classList.remove('open')">Fermer</button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="modal-overlay open" id="error-modal">
        <div class="modal" style="text-align:center">
            <div style="font-size:3rem;color:#e74c3c;margin-bottom:15px">&#10007;</div>
            <h3 style="margin-bottom:10px">Erreur</h3>
            <p style="color:var(--text-light);margin-bottom:20px">{{ session('error') }}</p>
            <button class="btn btn-primary" onclick="document.getElementById('error-modal').classList.remove('open')">Fermer</button>
        </div>
    </div>
    @endif

    @stack('scripts')
</body>
</html>
