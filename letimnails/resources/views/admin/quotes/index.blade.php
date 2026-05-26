@extends('layouts.admin')
@section('title', 'Devis')

@section('content')
<div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap">
    <a href="{{ route('admin.quotes') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline' }}">Tous</a>
    <a href="{{ route('admin.quotes', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-primary' : 'btn-outline' }}">En attente</a>
    <a href="{{ route('admin.quotes', ['status' => 'contacted']) }}" class="btn btn-sm {{ request('status') == 'contacted' ? 'btn-primary' : 'btn-outline' }}">Contactés</a>
    <a href="{{ route('admin.quotes', ['status' => 'quoted']) }}" class="btn btn-sm {{ request('status') == 'quoted' ? 'btn-primary' : 'btn-outline' }}">Devis envoyé</a>
</div>
<div style="overflow-x:auto">
    <table class="admin-table">
        <thead>
            <tr><th>N°</th><th>Nom</th><th>Email</th><th>Forme</th><th>Statut</th><th>Date</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($quotes as $quote)
            <tr>
                <td><strong>{{ $quote->quote_number }}</strong></td>
                <td>{{ $quote->name }}</td>
                <td>{{ $quote->email }}</td>
                <td>{{ $quote->nail_shape ?? '-' }}</td>
                <td><span class="status-badge status-{{ $quote->status }}">{{ $quote->status }}</span></td>
                <td>{{ $quote->created_at->format('d/m/Y') }}</td>
                <td class="actions">
                    <a href="{{ route('admin.quotes.show', $quote) }}" class="btn btn-sm btn-primary">Voir</a>
                    <form action="{{ route('admin.quotes.delete', $quote) }}" method="POST" class="inline-form" onsubmit="return confirm('Supprimer ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Suppr.</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light)">Aucun devis</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $quotes->links() }}</div>
@endsection
