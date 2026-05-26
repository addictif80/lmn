@extends('layouts.front')
@section('title', 'Profil - LetiMNails')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Mon profil</h1>
    </div>
</section>

<div class="container" style="max-width:600px;margin:0 auto;padding:40px 0">
    <form action="{{ route('account.profile') }}" method="POST">
        @csrf
        <h3 style="margin-bottom:20px">Informations personnelles</h3>
        <div class="form-group">
            <label for="name">Nom complet</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
        </div>
        <div class="form-group">
            <label for="phone">Téléphone</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="{{ auth()->user()->phone }}">
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>

    <form action="{{ route('account.password.update') }}" method="POST" style="margin-top:50px">
        @csrf
        <h3 style="margin-bottom:20px">Changer le mot de passe</h3>
        <div class="form-group">
            <label for="current_password">Mot de passe actuel</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
        </div>
        <div class="form-group">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required minlength="8">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmer</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
