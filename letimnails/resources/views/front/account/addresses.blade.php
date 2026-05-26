@extends('layouts.front')
@section('title', 'Mes adresses - LetiMNails')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Mes adresses</h1>
    </div>
</section>

<div class="container" style="padding:40px 0">
    @if($addresses->count() > 0)
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px">
        @foreach($addresses as $address)
        <div style="border:1px solid var(--border);border-radius:var(--radius);padding:20px">
            <p><strong>{{ $address->full_name }}</strong></p>
            <p style="color:var(--text-light)">{{ $address->full_address }}</p>
            <p style="color:var(--text-light)">{{ $address->phone }}</p>
            <p style="margin-top:10px">
                <span class="status-badge status-confirmed">{{ $address->type }}</span>
                @if($address->is_default)
                <span class="status-badge status-paid">Par défaut</span>
                @endif
            </p>
        </div>
        @endforeach
    </div>
    @else
    <div style="text-align:center;padding:60px 0">
        <p style="color:var(--text-light)">Aucune adresse enregistrée</p>
    </div>
    @endif
</div>
@endsection
