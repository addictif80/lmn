@extends('layouts.admin')
@section('title', 'Sliders')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:25px">
    <div class="admin-card">
        <h3>Nouveau slider</h3>
        <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Titre</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="form-group">
                <label>Sous-titre</label>
                <textarea class="form-control" name="subtitle" rows="2"></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Texte du bouton</label>
                    <input type="text" class="form-control" name="button_text">
                </div>
                <div class="form-group">
                    <label>URL du bouton</label>
                    <input type="text" class="form-control" name="button_url">
                </div>
            </div>
            <div class="form-group">
                <label>Image * (1920x800 recommandé)</label>
                <input type="file" class="form-control" name="image" required accept="image/*">
            </div>
            <div class="form-group">
                <label>Image mobile (optionnelle)</label>
                <input type="file" class="form-control" name="image_mobile" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>

    <div class="admin-card">
        <h3>Sliders existants</h3>
        @forelse($sliders as $s)
        <div style="margin-bottom:20px;padding:15px;border:1px solid #eee;border-radius:12px">
            @if($s->image)
            <img src="{{ asset('storage/' . $s->image) }}" alt="" style="width:100%;height:120px;object-fit:cover;border-radius:8px;margin-bottom:10px">
            @endif
            <form action="{{ route('admin.sliders.update', $s) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" class="form-control" name="title" value="{{ $s->title }}" style="margin-bottom:5px">
                <textarea class="form-control" name="subtitle" rows="2" style="margin-bottom:5px">{{ $s->subtitle }}</textarea>
                <div style="display:flex;gap:5px;margin-bottom:5px">
                    <input type="text" class="form-control" name="button_text" value="{{ $s->button_text }}" placeholder="Bouton">
                    <input type="text" class="form-control" name="button_url" value="{{ $s->button_url }}" placeholder="URL">
                </div>
                <div style="display:flex;gap:10px;align-items:center">
                    <label>Actif <input type="checkbox" name="is_active" value="1" {{ $s->is_active ? 'checked' : '' }}></label>
                    <button type="submit" class="btn btn-sm btn-primary">OK</button>
                    <form action="{{ route('admin.sliders.delete', $s) }}" method="POST" class="inline-form" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Suppr.</button>
                    </form>
                </div>
            </form>
        </div>
        @empty
        <p style="color:var(--text-light)">Aucun slider</p>
        @endforelse
    </div>
</div>
@endsection
