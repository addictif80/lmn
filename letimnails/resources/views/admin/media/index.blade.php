@extends('layouts.admin')
@section('title', 'Médiathèque')

@section('content')
<div class="admin-card">
    <h3>Uploader un fichier</h3>
    <form action="{{ route('admin.media.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display:flex;gap:15px;align-items:end;flex-wrap:wrap">
            <div class="form-group" style="flex:1;min-width:200px">
                <input type="file" class="form-control" name="file" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="alt" placeholder="Texte alternatif">
            </div>
            <button type="submit" class="btn btn-primary">Uploader</button>
        </div>
    </form>
</div>

@if($media->count() > 0)
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:15px">
    @foreach($media as $m)
    <div style="border:1px solid #eee;border-radius:8px;overflow:hidden;position:relative">
        @if(in_array($m->mime_type, ['image/jpeg','image/png','image/webp','image/gif']))
        <img src="{{ asset('storage/' . $m->path) }}" alt="{{ $m->alt }}" style="width:100%;height:120px;object-fit:cover" loading="lazy">
        @else
        <div style="height:120px;display:flex;align-items:center;justify-content:center;background:var(--bg-alt);font-size:2rem">&#128196;</div>
        @endif
        <div style="padding:8px;font-size:0.8rem">
            <p style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $m->name }}</p>
            <p style="color:var(--text-light)">{{ number_format($m->size / 1024, 1) }} KB</p>
            <form action="{{ route('admin.media.delete', $m) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" style="width:100%;margin-top:5px" onclick="return confirm('Supprimer ?')">Supprimer</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
<div class="pagination">{{ $media->links() }}</div>
@else
<p style="color:var(--text-light);padding:40px 0;text-align:center">Aucun fichier dans la médiathèque</p>
@endif
@endsection
