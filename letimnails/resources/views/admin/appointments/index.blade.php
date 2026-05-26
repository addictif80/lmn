@extends('layouts.admin')
@section('title', 'Rendez-vous')

@section('content')
<div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap">
    <a href="{{ route('admin.appointments') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline' }}">Tous</a>
    <a href="{{ route('admin.appointments', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-primary' : 'btn-outline' }}">En attente</a>
    <a href="{{ route('admin.appointments', ['status' => 'confirmed']) }}" class="btn btn-sm {{ request('status') == 'confirmed' ? 'btn-primary' : 'btn-outline' }}">Confirmés</a>
    <a href="{{ route('admin.appointments', ['status' => 'completed']) }}" class="btn btn-sm {{ request('status') == 'completed' ? 'btn-primary' : 'btn-outline' }}">Terminés</a>
</div>
<div style="overflow-x:auto">
    <table class="admin-table">
        <thead>
            <tr><th>Client</th><th>Type</th><th>Date</th><th>Horaire</th><th>Statut</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($appointments as $a)
            <tr>
                <td>{{ $a->first_name }} {{ $a->last_name }}</td>
                <td>{{ $a->type?->name ?? '-' }}</td>
                <td>{{ $a->date->format('d/m/Y') }}</td>
                <td>{{ substr($a->time, 0, 5) }}</td>
                <td><span class="status-badge status-{{ $a->status }}">{{ $a->status }}</span></td>
                <td class="actions">
                    <a href="{{ route('admin.appointments.show', $a) }}" class="btn btn-sm btn-primary">Voir</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-light)">Aucun rendez-vous</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $appointments->links() }}</div>
@endsection
