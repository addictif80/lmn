@extends('layouts.front')
@section('title', 'Liste de souhaits - LetiMNails')

@section('content')
<section class="page-header">
    <div class="container">
        <h1>Ma liste de souhaits</h1>
    </div>
</section>

<div class="container" style="padding:40px 0;text-align:center">
    <div style="font-size:4rem;margin-bottom:20px;color:var(--text-light)">&#9825;</div>
    <h3 style="margin-bottom:10px">Votre liste de souhaits est vide</h3>
    <p style="color:var(--text-light);margin-bottom:30px">Ajoutez des produits à votre liste pour les retrouver facilement</p>
    <a href="{{ route('boutique') }}" class="btn btn-primary">Découvrir la boutique</a>
</div>
@endsection
