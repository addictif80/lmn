@extends('layouts.admin')
@section('title', 'Types de prestation')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:25px">
    <div class="admin-card">
        <h3>Nouveau type</h3>
        <form action="{{ route('admin.appointments.types.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nom *</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" name="description" rows="2"></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Prix (€)</label>
                    <input type="number" step="0.01" class="form-control" name="price">
                </div>
                <div class="form-group">
                    <label>Durée (minutes) *</label>
                    <input type="number" class="form-control" name="duration_minutes" value="60" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>

    <div class="admin-card">
        <h3>Types existants</h3>
        @forelse($types as $t)
        <form action="{{ route('admin.appointments.types.update', $t) }}" method="POST" style="margin-bottom:12px;padding:12px;border:1px solid #eee;border-radius:8px">
            @csrf
            <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
                <input type="text" name="name" value="{{ $t->name }}" style="flex:1;min-width:120px;padding:8px;border:1px solid #ddd;border-radius:6px">
                <input type="number" step="0.01" name="price" value="{{ $t->price }}" style="width:80px;padding:8px;border:1px solid #ddd;border-radius:6px" placeholder="Prix">
                <input type="number" name="duration_minutes" value="{{ $t->duration_minutes }}" style="width:60px;padding:8px;border:1px solid #ddd;border-radius:6px">
                <label>Actif <input type="checkbox" name="is_active" value="1" {{ $t->is_active ? 'checked' : '' }}></label>
                <button type="submit" class="btn btn-sm btn-primary">OK</button>
                <form action="{{ route('admin.appointments.types.delete', $t) }}" method="POST" class="inline-form" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Suppr.</button>
                </form>
            </div>
        </form>
        @empty
        <p style="color:var(--text-light)">Aucun type de prestation</p>
        @endforelse
    </div>
</div>
@endsection
