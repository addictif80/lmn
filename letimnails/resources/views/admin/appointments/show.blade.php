@extends('layouts.admin')
@section('title', 'Rendez-vous ' . $appointment->first_name . ' ' . $appointment->last_name)

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:25px">
    <div class="admin-card">
        <h3>Détails du rendez-vous</h3>
        <p><strong>Client :</strong> {{ $appointment->first_name }} {{ $appointment->last_name }}</p>
        <p><strong>Email :</strong> {{ $appointment->email }}</p>
        <p><strong>Tél :</strong> {{ $appointment->phone }}</p>
        <p><strong>Type :</strong> {{ $appointment->type?->name ?? '-' }}</p>
        <p><strong>Date :</strong> {{ $appointment->date->format('d/m/Y') }}</p>
        <p><strong>Horaire :</strong> {{ substr($appointment->time, 0, 5) }}</p>
        <p><strong>Statut :</strong> <span class="status-badge status-{{ $appointment->status }}">{{ $appointment->status }}</span></p>
    </div>

    <div class="admin-card">
        <h3>Mettre à jour</h3>
        <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Statut</label>
                <select class="form-control" name="status">
                    <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                    <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Terminé</option>
                    <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>
            <div class="form-group">
                <label>Notes</label>
                <textarea class="form-control" name="admin_notes" rows="3">{{ $appointment->admin_notes }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>
@endsection
