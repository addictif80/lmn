@extends('layouts.admin')
@section('title', 'Avis clients')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:25px">
    <div class="admin-card">
        <h3>Nouvel avis</h3>
        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Nom</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label>Avis</label>
                <textarea class="form-control" name="content" rows="4" required></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Note (1-5)</label>
                    <input type="number" class="form-control" name="rating" min="1" max="5" value="5">
                </div>
                <div class="form-group">
                    <label>Source</label>
                    <select class="form-control" name="source">
                        <option value="google">Google</option>
                        <option value="manual">Manuel</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Image (optionnelle)</label>
                <input type="file" class="form-control" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>

    <div class="admin-card">
        <h3>Avis existants</h3>
        @forelse($testimonials as $t)
        <form action="{{ route('admin.testimonials.update', $t) }}" method="POST" enctype="multipart/form-data" style="margin-bottom:15px;padding-bottom:15px;border-bottom:1px solid #eee">
            @csrf
            <input type="text" class="form-control" name="name" value="{{ $t->name }}" style="margin-bottom:8px">
            <textarea class="form-control" name="content" rows="2" style="margin-bottom:8px">{{ $t->content }}</textarea>
            <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
                <input type="number" name="rating" value="{{ $t->rating }}" min="1" max="5" style="width:50px;padding:5px;border:1px solid #eee;border-radius:5px">
                <label>Actif <input type="checkbox" name="is_active" value="1" {{ $t->is_active ? 'checked' : '' }}></label>
                <button type="submit" class="btn btn-sm btn-primary">OK</button>
                <form action="{{ route('admin.testimonials.delete', $t) }}" method="POST" class="inline-form" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Suppr.</button>
                </form>
            </div>
        </form>
        @empty
        <p style="color:var(--text-light)">Aucun avis</p>
        @endforelse
    </div>
</div>
@endsection
