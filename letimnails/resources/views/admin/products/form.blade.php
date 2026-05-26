@extends('layouts.admin')
@section('title', isset($product) ? 'Modifier : ' . $product->name : 'Nouveau produit')

@section('content')
<div style="max-width:900px">
    <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($product)) @method('PUT') @endif

        <div class="admin-card">
            <h3>Informations générales</h3>
            <div class="form-group">
                <label>Nom du produit *</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $product->name ?? '') }}" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Catégorie</label>
                    <select class="form-control" name="category_id">
                        <option value="">Sélectionnez</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" name="type" required>
                        <option value="simple" {{ old('type', $product->type ?? '') == 'simple' ? 'selected' : '' }}>Simple</option>
                        <option value="variable" {{ old('type', $product->type ?? '') == 'variable' ? 'selected' : '' }}>Variable</option>
                        <option value="customizable" {{ old('type', $product->type ?? '') == 'customizable' ? 'selected' : '' }}>Personnalisable</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Prix (€) *</label>
                    <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $product->price ?? 0) }}" required>
                </div>
                <div class="form-group">
                    <label>Prix barré (€)</label>
                    <input type="number" step="0.01" class="form-control" name="compare_price" value="{{ old('compare_price', $product->compare_price ?? '') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>SKU</label>
                    <input type="text" class="form-control" name="sku" value="{{ old('sku', $product->sku ?? '') }}">
                </div>
                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" class="form-control" name="stock" value="{{ old('stock', $product->stock ?? 0) }}">
                </div>
            </div>
            <div class="form-group">
                <label>Description courte</label>
                <textarea class="form-control" name="short_description" rows="2">{{ old('short_description', $product->short_description ?? '') }}</textarea>
            </div>
            <div class="form-group">
                <label>Description longue</label>
                <textarea class="form-control" name="description" rows="5">{{ old('description', $product->description ?? '') }}</textarea>
            </div>
        </div>

        <div class="admin-card">
            <h3>Options</h3>
            <div style="display:flex;gap:20px;flex-wrap:wrap">
                <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}> Actif</label>
                <label><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}> Mis en avant</label>
                <label><input type="checkbox" name="is_customizable" value="1" {{ old('is_customizable', $product->is_customizable ?? false) ? 'checked' : '' }}> Personnalisable</label>
                <label><input type="checkbox" name="is_available_for_quote" value="1" {{ old('is_available_for_quote', $product->is_available_for_quote ?? false) ? 'checked' : '' }}> Disponible pour devis</label>
                <label><input type="checkbox" name="track_stock" value="1" {{ old('track_stock', $product->track_stock ?? false) ? 'checked' : '' }}> Suivre le stock</label>
            </div>
        </div>

        <div class="admin-card">
            <h3>Images</h3>
            <div class="form-group">
                <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                <small style="color:var(--text-light)">Formats acceptés : JPG, PNG, WebP</small>
            </div>
            @if(isset($product) && $product->images->count() > 0)
            <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:15px">
                @foreach($product->images as $img)
                <div style="position:relative;width:100px;height:100px">
                    <img src="{{ asset('storage/' . $img->path) }}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:8px;border:2px solid {{ $img->is_primary ? 'var(--primary)' : 'transparent' }}">
                    <div style="position:absolute;top:5px;right:5px;display:flex;gap:3px">
                        @if(!$img->is_primary)
                        <form action="{{ route('admin.products.image.primary', $img) }}" method="POST" class="inline-form">
                            @csrf
                            <button type="submit" style="background:white;border:none;padding:3px 5px;border-radius:4px;font-size:0.7rem;cursor:pointer" title="Définir comme principale">★</button>
                        </form>
                        @endif
                        <form action="{{ route('admin.products.image.delete', [$product, $img]) }}" method="POST" class="inline-form">
                            @csrf
                            <button type="submit" style="background:#e74c3c;color:white;border:none;padding:3px 5px;border-radius:4px;font-size:0.7rem;cursor:pointer" title="Supprimer">&times;</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="admin-card">
            <h3>SEO</h3>
            <div class="form-group">
                <label>Titre SEO (meta title)</label>
                <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $product->meta_title ?? '') }}">
            </div>
            <div class="form-group">
                <label>Description SEO (meta description)</label>
                <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
            </div>
        </div>

        <div style="display:flex;gap:10px">
            <button type="submit" class="btn btn-primary">
                {{ isset($product) ? 'Mettre à jour' : 'Créer le produit' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Annuler</a>
        </div>
    </form>
</div>
@endsection
