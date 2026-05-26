@extends('layouts.front')
@section('title', 'Panier - LetiMNails')
@section('content')

<section class="page-header">
    <div class="container">
        <h1>Mon panier</h1>
    </div>
</section>

<div class="container cart-page">
    @if($cartItems->count() > 0)
    <div style="overflow-x:auto">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:15px">
                            <div class="product-thumb">
                                @if($item->options->image)
                                <img src="{{ asset('storage/' . $item->options->image) }}" alt="{{ $item->name }}">
                                @else
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--bg-alt)">&#9998;</div>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('product.show', $item->options->slug ?? $item->id) }}" style="font-weight:600;color:var(--text)">{{ $item->name }}</a>
                                @if($item->options->variation)
                                <p style="font-size:0.85rem;color:var(--text-light)">{{ $item->options->variation }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ number_format($item->price, 2) }} €</td>
                    <td>
                        <form action="{{ route('cart.update') }}" method="POST" style="display:flex;align-items:center;gap:5px">
                            @csrf
                            <input type="hidden" name="rowId" value="{{ $item->rowId }}">
                            <input type="number" name="qty" value="{{ $item->qty }}" min="1" max="99" style="width:60px;padding:8px;border:1px solid var(--border);border-radius:8px;text-align:center">
                            <button type="submit" style="border:none;background:var(--primary);padding:8px 12px;border-radius:8px;cursor:pointer">OK</button>
                        </form>
                    </td>
                    <td><strong>{{ number_format($item->subtotal, 2) }} €</strong></td>
                    <td>
                        <form action="{{ route('cart.remove', $item->rowId) }}" method="POST">
                            @csrf
                            <button type="submit" style="border:none;background:none;cursor:pointer;color:var(--error);font-size:1.2rem" title="Supprimer">&times;</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="cart-summary" style="max-width:400px;margin-left:auto">
        <h3 style="margin-bottom:20px">Récapitulatif</h3>
        <div class="total-row">
            <span>Sous-total</span>
            <span>{{ number_format($subtotal, 2) }} €</span>
        </div>
        <div class="total-row">
            <span>Livraison</span>
            <span>Offerte</span>
        </div>
        <div class="grand-total total-row">
            <span>Total</span>
            <span>{{ number_format($total, 2) }} €</span>
        </div>
        <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;margin-top:20px">
            Commander
        </a>
        <a href="{{ route('boutique') }}" style="display:block;text-align:center;margin-top:10px;font-size:0.9rem">Continuer mes achats</a>
    </div>
    @else
    <div style="text-align:center;padding:80px 0">
        <div style="font-size:4rem;margin-bottom:20px;color:var(--text-light)">&#128722;</div>
        <h2 style="margin-bottom:10px">Votre panier est vide</h2>
        <p style="color:var(--text-light);margin-bottom:30px">Découvrez nos magnifiques press on nails</p>
        <a href="{{ route('boutique') }}" class="btn btn-primary btn-lg">Découvrir la boutique</a>
    </div>
    @endif
</div>
@endsection
