@extends('layouts.front')
@section('title', 'Commande confirmée - LetiMNails')
@section('content')

<div class="container" style="text-align:center;padding:80px 0;max-width:600px;margin:0 auto">
    <div style="font-size:4rem;color:#4caf50;margin-bottom:20px">&#10003;</div>
    <h1 style="margin-bottom:10px">Merci pour votre commande !</h1>
    <p style="color:var(--text-light);margin-bottom:30px">Votre commande <strong>#{{ $order->order_number }}</strong> a bien été confirmée. Vous recevrez un email de confirmation sous peu.</p>

    <div style="background:var(--bg-alt);border-radius:var(--radius);padding:30px;text-align:left;margin-bottom:30px">
        <h3 style="margin-bottom:15px">Récapitulatif</h3>
        @foreach($order->items as $item)
        <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border)">
            <span>{{ $item->product_name }} x{{ $item->quantity }}</span>
            <span>{{ number_format($item->subtotal, 2) }} €</span>
        </div>
        @endforeach
        <div style="display:flex;justify-content:space-between;font-weight:700;font-size:1.2rem;margin-top:15px;padding-top:15px;border-top:2px solid var(--border)">
            <span>Total</span>
            <span>{{ number_format($order->total, 2) }} €</span>
        </div>
    </div>

    <div style="display:flex;gap:15px;justify-content:center;flex-wrap:wrap">
        <a href="{{ route('boutique') }}" class="btn btn-primary">Continuer mes achats</a>
        @auth
        <a href="{{ route('account.orders') }}" class="btn btn-outline">Voir mes commandes</a>
        @endauth
    </div>
</div>
@endsection
