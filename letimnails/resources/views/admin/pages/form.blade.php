@extends('layouts.admin')
@section('title', isset($page) ? $page->title : 'Nouvelle page')

@section('content')
<div style="max-width:900px">
    <form action="{{ isset($page) ? route('admin.pages.update', $page) : route('admin.pages.store') }}" method="POST">
        @csrf
        <div class="admin-card">
            <h3>Contenu de la page</h3>
            <div class="form-group">
                <label>Titre</label>
                <input type="text" class="form-control" name="title" value="{{ old('title', $page->title ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Slug (URL)</label>
                <input type="text" class="form-control" name="slug" value="{{ old('slug', $page->slug ?? '') }}" required placeholder="mon-url-de-page">
                <small style="color:#888">Uniquement des lettres minuscules, chiffres et tirets. Ex: mentions-legales</small>
            </div>
            <div class="form-group">
                <label>Contenu (HTML)</label>
                <textarea class="form-control" name="content" rows="20" style="font-family:monospace;font-size:0.9rem">{{ old('content', $page->content ?? '') }}</textarea>
            </div>
        </div>
        <div class="admin-card">
            <h3>SEO</h3>
            <div class="form-group">
                <label>Titre SEO</label>
                <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $page->meta_title ?? '') }}">
            </div>
            <div class="form-group">
                <label>Description SEO</label>
                <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
            </div>
            <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }}> Page active</label>
        </div>
        @if ($errors->any())
            <div style="color:red;margin-bottom:10px">
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('admin.pages') }}" class="btn" style="margin-left:10px">Annuler</a>
    </form>
</div>
@endsection
