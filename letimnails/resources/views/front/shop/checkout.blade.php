@extends('layouts.front')
@section('title', 'Finaliser la commande - LetiMNails')
@section('content')

<section class="page-header">
    <div class="container">
        <h1>Finaliser la commande</h1>
    </div>
</section>

<div class="container">
    <div class="checkout-grid">
        <div>
            <form action="{{ route('checkout.place') }}" method="POST" id="checkout-form">
                @csrf
                <h3 style="margin-bottom:20px">Adresse de livraison</h3>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px">
                    <div class="form-group">
                        <label for="first_name">Prénom *</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ auth()->user()?->name ? explode(' ', auth()->user()->name)[0] : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Nom *</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ auth()->user()?->name ? array_slice(explode(' ', auth()->user()->name), 1) ? implode(' ', array_slice(explode(' ', auth()->user()->name), 1)) : '' : '' }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()?->email }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">Téléphone *</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ auth()->user()?->phone }}" required>
                </div>

                <div class="form-group">
                    <label for="address">Adresse *</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Numéro et rue" required>
                </div>

                <div style="display:grid;grid-template-columns:2fr 1fr;gap:15px">
                    <div class="form-group">
                        <label for="city">Ville *</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Code postal *</label>
                        <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                    </div>
                </div>

                <h3 style="margin:30px 0 20px">Mode de paiement</h3>
                <div style="display:flex;flex-direction:column;gap:10px">
                    <label style="display:flex;align-items:center;gap:10px;padding:15px;border:1px solid var(--border);border-radius:var(--radius-sm);cursor:pointer">
                        <input type="radio" name="payment_method" value="card" checked>
                        <span>Carte bancaire</span>
                    </label>
                    <label style="display:flex;align-items:center;gap:10px;padding:15px;border:1px solid var(--border);border-radius:var(--radius-sm);cursor:pointer">
                        <input type="radio" name="payment_method" value="paypal">
                        <span>PayPal</span>
                    </label>
                    <label style="display:flex;align-items:center;gap:10px;padding:15px;border:1px solid var(--border);border-radius:var(--radius-sm);cursor:pointer">
                        <input type="radio" name="payment_method" value="transfer">
                        <span>Virement bancaire</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;margin-top:30px">
                    Confirmer la commande
                </button>
            </form>
        </div>

        <div>
            <div class="order-summary">
                <h3 style="margin-bottom:20px">Votre commande</h3>
                @foreach($cartItems as $item)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border)">
                    <div>
                        <p style="font-weight:500">{{ $item->name }}</p>
                        <p style="font-size:0.85rem;color:var(--text-light)">Qty : {{ $item->qty }}</p>
                    </div>
                    <span>{{ number_format($item->subtotal, 2) }} €</span>
                </div>
                @endforeach
                <div style="margin-top:20px">
                    <div style="display:flex;justify-content:space-between;margin-bottom:8px">
                        <span>Sous-total</span>
                        <span>{{ number_format(Cart::instance('default')->subtotal(), 2) }} €</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:8px">
                        <span>Livraison</span>
                        <span>Offerte</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:1.3rem;font-weight:700;border-top:2px solid var(--border);padding-top:15px;margin-top:10px">
                        <span>Total</span>
                        <span>{{ number_format(Cart::instance('default')->total(), 2) }} €</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
