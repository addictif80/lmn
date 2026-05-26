@extends('layouts.front')
@section('title', 'Demande de devis envoyée - LetiMNails')

@section('content')
<div class="container" style="text-align:center;padding:80px 0;max-width:600px;margin:0 auto">
    <div style="font-size:4rem;color:#4caf50;margin-bottom:20px">&#10003;</div>
    <h1 style="margin-bottom:10px">Votre demande de devis a bien été envoyée !</h1>
    <p style="color:var(--text-light);margin-bottom:30px">Nous étudions votre projet et vous recontacterons dans les plus brefs délais.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Retour à l'accueil</a>
</div>
@endsection
