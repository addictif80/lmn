@extends('layouts.admin')
@section('title', 'Commandes')

@section('content')
<div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline' }}">Toutes</a>
    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-primary' : 'btn-outline' }}">En attente</a>
    <a href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}" class="btn btn-sm {{ request('status') == 'confirmed' ? 'btn-primary' : 'btn-outline' }}">Confirmées</a>
    <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="btn btn-sm {{ request('status') == 'processing' ? 'btn-primary' : 'btn-outline' }}">En cours</a>
    <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="btn btn-sm {{ request('status') == 'shipped' ? 'btn-primary' : 'btn-outline' }}">Expédiées</a>
    <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="btn btn-sm {{ request('status') == 'delivered' ? 'btn-primary' : 'btn-outline' }}">Livrées</a>
    <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="btn btn-sm {{ request('status') == 'cancelled' ? 'btn-primary' : 'btn-outline' }}">Annulées</a>
</div>
<div style="overflow-x:auto">
    <table class="admin-table">
        <thead>
            <tr>
                <th>N° commande</th>
                <th>Client</th>
                <th>Total</th>
                <th>Paiement</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td><strong>{{ $order->order_number }}</strong></td>
                <td>{{ $order->user?->name ?? 'Visiteur' }}</td>
                <td>{{ number_format($order->total, 2) }} €</td>
                <td><span class="status-badge status-{{ $order->payment_status }}">{{ $order->payment_status }}</span></td>
                <td><span class="status-badge status-{{ $order->status }}">{{ $order->status }}</span></td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td class="actions">
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">Voir</a>
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline-form" onsubmit="return confirm('Supprimer ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Suppr.</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light)">Aucune commande</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $orders->links() }}</div>
@endsection
