@extends('layouts.admin')
@section('title', 'Catégories galerie')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:25px">
    <div class="admin-card">
        <h3>Nouvelle catégorie</h3>
        <form action="{{ route('admin.gallery.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Nom *</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" name="description" rows="2"></textarea>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>

    <div class="admin-card">
        <h3>Catégories existantes</h3>
        @forelse($categories as $cat)
        <form action="{{ route('admin.gallery.categories.update', $cat) }}" method="POST" enctype="multipart/form-data" style="margin-bottom:12px;padding:12px;border:1px solid #eee;border-radius:8px">
            @csrf
            <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                <input type="text" name="name" value="{{ $cat->name }}" style="flex:1;padding:8px;border:1px solid #ddd;border-radius:6px">
                <input type="number" name="position" value="{{ $cat->position }}" style="width:50px;padding:8px;border:1px solid #ddd;border-radius:6px">
                <label>Actif <input type="checkbox" name="is_active" value="1" {{ $cat->is_active ? 'checked' : '' }}></label>
                <a href="{{ route('admin.gallery.items', $cat->id) }}" class="btn btn-sm btn-outline">Images</a>
                <button type="submit" class="btn btn-sm btn-primary">OK</button>
                <form action="{{ route('admin.gallery.categories.delete', $cat) }}" method="POST" class="inline-form" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Suppr.</button>
                </form>
            </div>
        </form>
        @empty
        <p style="color:var(--text-light)">Aucune catégorie</p>
        @endforelse
    </div>
</div>
@endsection
