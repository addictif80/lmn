@extends('layouts.admin')
@section('title', 'Images - ' . $category->name)

@section('content')
<div class="admin-card">
    <h3>Ajouter une image à "{{ $category->name }}"</h3>
    <form action="{{ route('admin.gallery.items.store', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display:flex;gap:15px;flex-wrap:wrap;align-items:end">
            <div class="form-group">
                <label>Image *</label>
                <input type="file" class="form-control" name="image" required accept="image/*">
            </div>
            <div class="form-group">
                <label>Titre</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="form-group">
                <label>Référence</label>
                <input type="text" class="form-control" name="reference">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
    </form>
</div>

@if($items->count() > 0)
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:15px">
    @foreach($items as $item)
    <div style="border:1px solid #eee;border-radius:8px;overflow:hidden">
        <img src="{{ asset('storage/' . $item->image) }}" alt="" style="width:100%;height:150px;object-fit:cover" loading="lazy">
        <div style="padding:10px">
            <form action="{{ route('admin.gallery.items.update', $item) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="title" value="{{ $item->title }}" style="width:100%;padding:5px;border:1px solid #ddd;border-radius:4px;margin-bottom:5px" placeholder="Titre">
                <input type="text" name="reference" value="{{ $item->reference }}" style="width:100%;padding:5px;border:1px solid #ddd;border-radius:4px;margin-bottom:5px" placeholder="Réf">
                <label style="font-size:0.8rem">Actif <input type="checkbox" name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }}></label>
                <div style="display:flex;gap:5px;margin-top:5px">
                    <button type="submit" class="btn btn-sm btn-primary">OK</button>
                    <form action="{{ route('admin.gallery.items.delete', $item) }}" method="POST" class="inline-form" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Suppr.</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>
@else
<p style="color:var(--text-light);text-align:center;padding:40px 0">Aucune image dans cette catégorie</p>
@endif
<p style="margin-top:20px"><a href="{{ route('admin.gallery.categories') }}">&larr; Retour aux catégories</a></p>
@endsection
