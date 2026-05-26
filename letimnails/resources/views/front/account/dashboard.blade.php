@extends('layouts.front')
@section('title', 'Mon compte - LetiMNails')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Mon compte</h1>
    </div>
</section>

<div class="container">
    <div class="account-layout">
        <aside class="account-sidebar">
            <div class="user-info">
                <div style="font-size:3rem;margin-bottom:10px;color:var(--primary-dark)">&#128100;</div>
                <h3>{{ $user->name }}</h3>
                <p style="color:var(--text-light);font-size:0.9rem">{{ $user->email }}</p>
            </div>
            <nav>
                <a href="{{ route('account.dashboard') }}" class="{{ request()->routeIs('account.dashboard') ? 'active' : '' }}">&#9654; Tableau de bord</a>
                <a href="{{ route('account.orders') }}" class="{{ request()->routeIs('account.orders*') ? 'active' : '' }}">&#9654; Mes commandes</a>
                <a href="{{ route('account.profile') }}" class="{{ request()->routeIs('account.profile') ? 'active' : '' }}">&#9654; Mon profil</a>
                <a href="{{ route('account.wishlist') }}" class="{{ request()->routeIs('account.wishlist') ? 'active' : '' }}">&#9654; Liste de souhaits</a>
                <a href="{{ route('account.addresses') }}" class="{{ request()->routeIs('account.addresses') ? 'active' : '' }}">&#9654; Mes adresses</a>
                <form method="POST" action="{{ route('logout') }}" style="margin-top:10px">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:var(--error);cursor:pointer;padding:12px 15px;width:100%;text-align:left;border-radius:8px;font-size:0.95rem">&#9654; Déconnexion</button>
                </form>
            </nav>
        </aside>

        <div>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="number">{{ $ordersCount }}</div>
                    <div class="label">Commandes</div>
                </div>
                <div class="stat-card">
                    <div class="number">{{ $quotesCount }}</div>
                    <div class="label">Devis</div>
                </div>
                <div class="stat-card">
                    <div class="number">{{ $appointmentsCount }}</div>
                    <div class="label">Rendez-vous</div>
                </div>
            </div>

            @if($recentOrders->count() > 0)
            <h3 style="margin-bottom:15px">Dernières commandes</h3>
            <div style="overflow-x:auto">
                <table class="admin-table" style="width:100%">
                    <thead>
                        <tr><th>N°</th><th>Date</th><th>Total</th><th>Statut</th><th></th></tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>{{ number_format($order->total, 2) }} €</td>
                            <td><span class="status-badge status-{{ $order->status }}">{{ $order->status }}</span></td>
                            <td><a href="{{ route('account.order.detail', $order->order_number) }}" style="font-size:0.85rem">Voir</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
