@extends('layouts.admin')
@section('title', $page->title)

@section('content')
<div style="max-width:900px">
    <form action="{{ route('admin.pages.update', $page) }}" method="POST">
        @csrf
        <div class="admin-card">
            <h3>Contenu de la page</h3>
            <div class="form-group">
                <label>Titre</label>
                <input type="text" class="form-control" name="title" value="{{ old('title', $page->title) }}" required>
            </div>
            <div class="form-group">
                <label>Contenu (HTML)</label>
                <textarea class="form-control" name="content" rows="20" style="font-family:monospace;font-size:0.9rem">{{ old('content', $page->content) }}</textarea>
            </div>
        </div>
        <div class="admin-card">
            <h3>SEO</h3>
            <div class="form-group">
                <label>Titre SEO</label>
                <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}">
            </div>
            <div class="form-group">
                <label>Description SEO</label>
                <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description', $page->meta_description) }}</textarea>
            </div>
            <label><input type="checkbox" name="is_active" value="1" {{ $page->is_active ? 'checked' : '' }}> Page active</label>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
