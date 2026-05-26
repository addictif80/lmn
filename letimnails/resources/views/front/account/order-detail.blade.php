@extends('layouts.front')
@section('title', 'Commande #' . $order->order_number)

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Commande #{{ $order->order_number }}</h1>
    </div>
</section>

<div class="container" style="padding:40px 0;max-width:700px;margin:0 auto">
    <div style="background:var(--bg-alt);border-radius:var(--radius);padding:30px;margin-bottom:30px">
        <div style="display:flex;justify-content:space-between;margin-bottom:20px">
            <div>
                <p style="color:var(--text-light)">Date</p>
                <p><strong>{{ $order->created_at->format('d/m/Y H:i') }}</strong></p>
            </div>
            <div>
                <p style="color:var(--text-light)">Statut</p>
                <span class="status-badge status-{{ $order->status }}">{{ $order->status }}</span>
            </div>
            <div>
                <p style="color:var(--text-light)">Paiement</p>
                <span class="status-badge status-{{ $order->payment_status }}">{{ $order->payment_status }}</span>
            </div>
        </div>

        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="border-bottom:1px solid var(--border)">
                    <th style="text-align:left;padding:10px;color:var(--text-light);font-size:0.9rem">Produit</th>
                    <th style="text-align:center;padding:10px;color:var(--text-light);font-size:0.9rem">Qté</th>
                    <th style="text-align:right;padding:10px;color:var(--text-light);font-size:0.9rem">Prix</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr style="border-bottom:1px solid var(--border)">
                    <td style="padding:10px">{{ $item->product_name }}</td>
                    <td style="padding:10px;text-align:center">{{ $item->quantity }}</td>
                    <td style="padding:10px;text-align:right">{{ number_format($item->subtotal, 2) }} €</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="padding:10px;text-align:right;font-weight:600">Total</td>
                    <td style="padding:10px;text-align:right;font-weight:700;font-size:1.2rem">{{ number_format($order->total, 2) }} €</td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if($order->shipping_address)
    <div style="background:var(--bg-alt);border-radius:var(--radius);padding:30px">
        <h3 style="margin-bottom:15px">Adresse de livraison</h3>
        @php $a = $order->shipping_address; @endphp
        <p>{{ $a['first_name'] ?? '' }} {{ $a['last_name'] ?? '' }}</p>
        <p>{{ $a['address'] ?? '' }}</p>
        <p>{{ $a['postal_code'] ?? '' }} {{ $a['city'] ?? '' }}</p>
    </div>
    @endif
</div>
@endsection
