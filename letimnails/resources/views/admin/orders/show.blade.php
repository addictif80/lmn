@extends('layouts.admin')
@section('title', 'Commande #' . $order->order_number)

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:25px">
    <div class="admin-card">
        <h3>Détails de la commande</h3>
        <p><strong>Numéro :</strong> {{ $order->order_number }}</p>
        <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Client :</strong> {{ $order->user?->name ?? 'Visiteur' }}</p>
        <p><strong>Email :</strong> {{ $order->user?->email ?? $order->billing_address['email'] ?? '-' }}</p>
        <p><strong>Statut :</strong> <span class="status-badge status-{{ $order->status }}">{{ $order->status }}</span></p>
        <p><strong>Paiement :</strong> <span class="status-badge status-{{ $order->payment_status }}">{{ $order->payment_status }}</span></p>
        @if($order->tracking_number)
        <p><strong>Suivi :</strong> {{ $order->tracking_number }}</p>
        @endif
    </div>

    <div class="admin-card">
        <h3>Mettre à jour le statut</h3>
        <form action="{{ route('admin.orders.status', $order) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Statut</label>
                <select class="form-control" name="status" required>
                    @foreach(['pending','confirmed','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Statut paiement</label>
                <select class="form-control" name="payment_status">
                    <option value="">Ne pas changer</option>
                    @foreach(['pending','paid','failed','refunded'] as $ps)
                    <option value="{{ $ps }}" {{ $order->payment_status == $ps ? 'selected' : '' }}>{{ $ps }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Numéro de suivi</label>
                <input type="text" class="form-control" name="tracking_number" value="{{ $order->tracking_number }}">
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
</div>

<div class="admin-card" style="margin-top:25px">
    <h3>Articles commandés</h3>
    <table class="admin-table">
        <thead>
            <tr><th>Produit</th><th>SKU</th><th>Prix</th><th>Quantité</th><th>Total</th></tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->product_sku ?? '-' }}</td>
                <td>{{ number_format($item->price, 2) }} €</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->subtotal, 2) }} €</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr><th colspan="4" style="text-align:right">Sous-total</th><th>{{ number_format($order->subtotal, 2) }} €</th></tr>
            <tr><th colspan="4" style="text-align:right">Livraison</th><th>{{ number_format($order->shipping_cost, 2) }} €</th></tr>
            <tr><th colspan="4" style="text-align:right">Total</th><th>{{ number_format($order->total, 2) }} €</th></tr>
        </tfoot>
    </table>
</div>

@if($order->shipping_address)
<div class="admin-card">
    <h3>Adresse de livraison</h3>
    @php $addr = $order->shipping_address; @endphp
    <p>{{ $addr['first_name'] ?? '' }} {{ $addr['last_name'] ?? '' }}</p>
    <p>{{ $addr['address'] ?? '' }}</p>
    <p>{{ $addr['postal_code'] ?? '' }} {{ $addr['city'] ?? '' }}</p>
</div>
@endif
@endsection
