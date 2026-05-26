@extends('layouts.admin')
@section('title', 'Paramètres généraux')

@section('content')
<div style="max-width:700px">
    <form action="{{ route('admin.settings.general') }}" method="POST">
        @csrf
        <div class="admin-card">
            <h3>Informations du site</h3>
            <div class="form-group">
                <label>Nom du site</label>
                <input type="text" class="form-control" name="site_name" value="{{ $settings['site_name'] ?? 'LetiMNails' }}">
            </div>
            <div class="form-group">
                <label>Description du site</label>
                <textarea class="form-control" name="site_description" rows="3">{{ $settings['site_description'] ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label>Email de contact</label>
                <input type="email" class="form-control" name="contact_email" value="{{ $settings['contact_email'] ?? 'support@letimnails.fr' }}">
            </div>
            <div class="form-group">
                <label>Téléphone</label>
                <input type="text" class="form-control" name="contact_phone" value="{{ $settings['contact_phone'] ?? '07 56 81 35 64' }}">
            </div>
            <div class="form-group">
                <label>Adresse</label>
                <textarea class="form-control" name="contact_address" rows="2">{{ $settings['contact_address'] ?? "58 Lotissement Armand Flottes\n12220 Les Albres" }}</textarea>
            </div>
        </div>

        <div class="admin-card">
            <h3>Réseaux sociaux</h3>
            <div class="form-group">
                <label>Facebook</label>
                <input type="url" class="form-control" name="facebook_url" value="{{ $settings['facebook_url'] ?? 'https://www.facebook.com/letimnails' }}">
            </div>
            <div class="form-group">
                <label>Instagram</label>
                <input type="url" class="form-control" name="instagram_url" value="{{ $settings['instagram_url'] ?? 'https://www.instagram.com/leti_mnails/' }}">
            </div>
            <div class="form-group">
                <label>YouTube</label>
                <input type="url" class="form-control" name="youtube_url" value="{{ $settings['youtube_url'] ?? 'https://www.youtube.com/@LetimNails' }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
