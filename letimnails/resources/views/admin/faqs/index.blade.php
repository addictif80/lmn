@extends('layouts.admin')
@section('title', 'FAQ')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:25px">
    <div class="admin-card">
        <h3>Nouvelle FAQ</h3>
        <form action="{{ route('admin.faqs.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Question</label>
                <input type="text" class="form-control" name="question" required>
            </div>
            <div class="form-group">
                <label>Réponse</label>
                <textarea class="form-control" name="answer" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>

    <div class="admin-card">
        <h3>FAQs existantes ({{ $faqs->count() }})</h3>
        @forelse($faqs as $faq)
        <form action="{{ route('admin.faqs.update', $faq) }}" method="POST" style="margin-bottom:15px;padding-bottom:15px;border-bottom:1px solid #eee">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="question" value="{{ $faq->question }}" required>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="answer" rows="3" required>{{ $faq->answer }}</textarea>
            </div>
            <div style="display:flex;gap:10px;align-items:center">
                <input type="number" name="position" value="{{ $faq->position }}" style="width:60px;padding:5px;border:1px solid #eee;border-radius:5px" placeholder="Pos">
                <label><input type="checkbox" name="is_active" value="1" {{ $faq->is_active ? 'checked' : '' }}> Actif</label>
                <button type="submit" class="btn btn-sm btn-primary">OK</button>
                <form action="{{ route('admin.faqs.delete', $faq) }}" method="POST" class="inline-form" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Suppr.</button>
                </form>
            </div>
        </form>
        @empty
        <p style="color:var(--text-light);padding:20px 0">Aucune FAQ</p>
        @endforelse
    </div>
</div>
@endsection
