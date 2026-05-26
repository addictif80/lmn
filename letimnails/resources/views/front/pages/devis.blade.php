@extends('layouts.front')
@section('title', 'Demander un devis - LetiMNails')
@section('content')

<section class="page-header">
    <div class="container">
        <h1>Demander un devis</h1>
        <p>Pour une commande personnalisée, laissez-vous guider</p>
    </div>
</section>

<div class="container" style="max-width:700px;margin:0 auto;padding:40px 0">
    <form action="{{ route('devis.submit') }}" method="POST">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px">
            <div class="form-group">
                <label for="name">Nom complet *</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()?->name) }}" required>
                @error('name') <small style="color:var(--error)">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()?->email) }}" required>
                @error('email') <small style="color:var(--error)">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="phone">Téléphone</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', auth()->user()?->phone) }}">
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:15px">
            <div class="form-group">
                <label for="nail_shape">Forme d'ongle</label>
                <select class="form-control" id="nail_shape" name="nail_shape">
                    <option value="">Sélectionnez</option>
                    <option value="coffin">Coffin</option>
                    <option value="stiletto">Stiletto</option>
                    <option value="carre">Carré</option>
                    <option value="amande">Amande</option>
                    <option value="rond">Rond</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nail_size">Taille</label>
                <select class="form-control" id="nail_size" name="nail_size">
                    <option value="">Sélectionnez</option>
                    <option value="xs">XS</option>
                    <option value="s">S</option>
                    <option value="m">M</option>
                    <option value="l">L</option>
                    <option value="xl">XL</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nail_length">Longueur</label>
                <select class="form-control" id="nail_length" name="nail_length">
                    <option value="">Sélectionnez</option>
                    <option value="extra-court">Extra court</option>
                    <option value="court">Court</option>
                    <option value="medium">Medium</option>
                    <option value="long">Long</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="design_ideas">Idées de design / Références</label>
            <textarea class="form-control" id="design_ideas" name="design_ideas" rows="3" placeholder="Vous pouvez indiquer des références vues dans notre galerie, ou décrire votre projet">{{ old('design_ideas') }}</textarea>
        </div>

        <div class="form-group">
            <label for="description">Description de votre projet *</label>
            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Décrivez-nous votre projet en détail : couleurs, motifs, inspirations..." required>{{ old('description') }}</textarea>
            @error('description') <small style="color:var(--error)">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center">
            Envoyer ma demande de devis
        </button>
    </form>
</div>
@endsection
