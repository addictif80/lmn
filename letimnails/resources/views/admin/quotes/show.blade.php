@extends('layouts.admin')
@section('title', 'Devis ' . $quote->quote_number)

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:25px">
    <div class="admin-card">
        <h3>Demande de devis</h3>
        <p><strong>N° :</strong> {{ $quote->quote_number }}</p>
        <p><strong>Date :</strong> {{ $quote->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Nom :</strong> {{ $quote->name }}</p>
        <p><strong>Email :</strong> {{ $quote->email }}</p>
        <p><strong>Tél :</strong> {{ $quote->phone ?? '-' }}</p>
        <p><strong>Forme :</strong> {{ $quote->nail_shape ?? '-' }}</p>
        <p><strong>Taille :</strong> {{ $quote->nail_size ?? '-' }}</p>
        <p><strong>Longueur :</strong> {{ $quote->nail_length ?? '-' }}</p>
        <p><strong>Statut :</strong> <span class="status-badge status-{{ $quote->status }}">{{ $quote->status }}</span></p>
        @if($quote->quoted_price)
        <p><strong>Prix proposé :</strong> {{ number_format($quote->quoted_price, 2) }} €</p>
        @endif
    </div>

    <div class="admin-card">
        <h3>Mettre à jour</h3>
        <form action="{{ route('admin.quotes.update', $quote) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Statut</label>
                <select class="form-control" name="status">
                    <option value="pending" {{ $quote->status == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="contacted" {{ $quote->status == 'contacted' ? 'selected' : '' }}>Contacté</option>
                    <option value="quoted" {{ $quote->status == 'quoted' ? 'selected' : '' }}>Devis envoyé</option>
                    <option value="accepted" {{ $quote->status == 'accepted' ? 'selected' : '' }}>Accepté</option>
                    <option value="declined" {{ $quote->status == 'declined' ? 'selected' : '' }}>Refusé</option>
                </select>
            </div>
            <div class="form-group">
                <label>Prix proposé (€)</label>
                <input type="number" step="0.01" class="form-control" name="quoted_price" value="{{ $quote->quoted_price }}">
            </div>
            <div class="form-group">
                <label>Notes internes</label>
                <textarea class="form-control" name="admin_notes" rows="4">{{ $quote->admin_notes }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>

<div class="admin-card" style="margin-top:25px">
    <h3>Description du projet</h3>
    <p style="line-height:1.8">{{ $quote->description }}</p>
</div>

@if($quote->design_ideas)
<div class="admin-card">
    <h3>Idées de design / Références</h3>
    <p>{{ $quote->design_ideas }}</p>
</div>
@endif
@endsection
