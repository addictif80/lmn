@extends('layouts.admin')
@section('title', 'Tableau de bord')

@section('content')
<div class="grid-3">
    <div class="stat-card-admin">
        <div class="num">{{ $stats['products_count'] }}</div>
        <div class="lbl">Produits</div>
    </div>
    <div class="stat-card-admin">
        <div class="num">{{ $stats['orders_count'] }}</div>
        <div class="lbl">Commandes totales</div>
    </div>
    <div class="stat-card-admin">
        <div class="num">{{ $stats['pending_orders'] }}</div>
        <div class="lbl">Commandes en attente</div>
    </div>
    <div class="stat-card-admin">
        <div class="num">{{ $stats['quotes_count'] }}</div>
        <div class="lbl">Devis reçus</div>
    </div>
    <div class="stat-card-admin">
        <div class="num">{{ $stats['pending_quotes'] }}</div>
        <div class="lbl">Devis en attente</div>
    </div>
    <div class="stat-card-admin">
        <div class="num">{{ $stats['appointments_count'] }}</div>
        <div class="lbl">Rendez-vous</div>
    </div>
    <div class="stat-card-admin">
        <div class="num">{{ $stats['users_count'] }}</div>
        <div class="lbl">Clients</div>
    </div>
    <div class="stat-card-admin">
        <div class="num">{{ number_format($stats['revenue'], 0) }} €</div>
        <div class="lbl">Revenu total</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:25px;margin-top:30px">
    <div class="admin-card">
        <h3>Dernières commandes</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stats['recent_orders'] as $order)
                <tr>
                    <td><a href="{{ route('admin.orders.show', $order) }}" style="font-weight:600">{{ $order->order_number }}</a></td>
                    <td>{{ $order->user?->name ?? 'Visiteur' }}</td>
                    <td>{{ number_format($order->total, 2) }} €</td>
                    <td><span class="status-badge status-{{ $order->status }}">{{ $order->status }}</span></td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;padding:20px;color:var(--text-light)">Aucune commande</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-card">
        <h3>Derniers devis</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Client</th>
                    <th>Email</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stats['recent_quotes'] as $quote)
                <tr>
                    <td><a href="{{ route('admin.quotes.show', $quote) }}" style="font-weight:600">{{ $quote->quote_number }}</a></td>
                    <td>{{ $quote->name }}</td>
                    <td>{{ $quote->email }}</td>
                    <td><span class="status-badge status-{{ $quote->status }}">{{ $quote->status }}</span></td>
                    <td>{{ $quote->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;padding:20px;color:var(--text-light)">Aucun devis</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
