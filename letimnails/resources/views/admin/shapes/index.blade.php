@extends('layouts.admin')
@section('title', 'Formes d\'ongles')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:25px">
    <div class="admin-card">
        <h3>Nouvelle forme</h3>
        <form action="{{ route('admin.shapes.store') }}" method="POST" enctype="multipart/form-data">
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
        <h3>Formes existantes</h3>
        @forelse($shapes as $shape)
        <form action="{{ route('admin.shapes.update', $shape) }}" method="POST" enctype="multipart/form-data" style="margin-bottom:15px;padding:15px;border:1px solid #eee;border-radius:8px">
            @csrf
            <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
                @if($shape->image)
                <img src="{{ asset('storage/' . $shape->image) }}" alt="" style="width:50px;height:50px;object-fit:cover;border-radius:50%">
                @endif
                <input type="text" name="name" value="{{ $shape->name }}" style="flex:1;padding:8px;border:1px solid #ddd;border-radius:6px">
                <input type="number" name="position" value="{{ $shape->position }}" style="width:50px;padding:8px;border:1px solid #ddd;border-radius:6px">
                <label>Actif <input type="checkbox" name="is_active" value="1" {{ $shape->is_active ? 'checked' : '' }}></label>
                <button type="submit" class="btn btn-sm btn-primary">OK</button>
                <form action="{{ route('admin.shapes.delete', $shape) }}" method="POST" class="inline-form" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Suppr.</button>
                </form>
            </div>
            @if($shape->sizes->count() > 0)
            <div style="margin-top:8px;font-size:0.85rem;color:var(--text-light)">
                Tailles : {{ $shape->sizes->pluck('name')->implode(', ') }}
            </div>
            @endif
        </form>
        @empty
        <p style="color:var(--text-light)">Aucune forme</p>
        @endforelse
    </div>
</div>
@endsection
