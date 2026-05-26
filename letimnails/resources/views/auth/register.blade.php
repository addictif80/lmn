@extends('layouts.front')
@section('title', 'Inscription - LetiMNails')

@section('content')
<div class="container" style="max-width:450px;margin:0 auto;padding:80px 0">
    <h1 style="text-align:center;margin-bottom:10px;font-family:var(--font-display);font-size:2.5rem">Inscription</h1>
    <p style="text-align:center;color:var(--text-light);margin-bottom:40px">Créez votre compte client</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nom complet *</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name') <small style="color:var(--error)">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email') <small style="color:var(--error)">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="password">Mot de passe *</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required minlength="8">
            @error('password') <small style="color:var(--error)">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe *</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center">Créer mon compte</button>

        <p style="text-align:center;margin-top:20px">
            <a href="{{ route('login') }}">Déjà un compte ? Se connecter</a>
        </p>
    </form>
</div>
@endsection
