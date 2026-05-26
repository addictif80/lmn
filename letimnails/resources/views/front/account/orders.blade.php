@extends('layouts.front')
@section('title', 'Mes commandes - LetiMNails')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Mes commandes</h1>
    </div>
</section>

<div class="container" style="padding:40px 0">
    <table class="admin-table" style="width:100%">
        <thead>
            <tr><th>N° commande</th><th>Date</th><th>Articles</th><th>Total</th><th>Statut</th><th>Paiement</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td><strong>{{ $order->order_number }}</strong></td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>{{ $order->items->count() }}</td>
                <td>{{ number_format($order->total, 2) }} €</td>
                <td><span class="status-badge status-{{ $order->status }}">{{ $order->status }}</span></td>
                <td><span class="status-badge status-{{ $order->payment_status }}">{{ $order->payment_status }}</span></td>
                <td><a href="{{ route('account.order.detail', $order->order_number) }}" class="btn btn-sm btn-outline">Détails</a></td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light)">Aucune commande</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $orders->links() }}</div>
</div>
@endsection
