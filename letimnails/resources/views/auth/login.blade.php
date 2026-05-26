@extends('layouts.front')
@section('title', 'Connexion - LetiMNails')

@section('content')
<div class="container" style="max-width:450px;margin:0 auto;padding:80px 0">
    <h1 style="text-align:center;margin-bottom:10px;font-family:var(--font-display);font-size:2.5rem">Connexion</h1>
    <p style="text-align:center;color:var(--text-light);margin-bottom:40px">Connectez-vous à votre compte</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email') <small style="color:var(--error)">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="password">Mot de passe *</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password') <small style="color:var(--error)">{{ $message }}</small> @enderror
        </div>

        <div class="form-group" style="display:flex;align-items:center;gap:10px">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember" style="margin:0">Se souvenir de moi</label>
        </div>

        <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center">Se connecter</button>

        <p style="text-align:center;margin-top:20px">
            <a href="{{ route('register') }}">Créer un compte</a>
        </p>
    </form>
</div>
@endsection
