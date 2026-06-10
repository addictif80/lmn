@extends('layouts.admin')
@section('title', 'Pages CMS')

@section('content')
<div style="margin-bottom:15px">
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">+ Nouvelle page</a>
</div>
<div style="overflow-x:auto">
    <table class="admin-table">
        <thead>
            <tr><th>Titre</th><th>Slug</th><th>Template</th><th>Statut</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($pages as $page)
            <tr>
                <td><strong>{{ $page->title }}</strong></td>
                <td>/{{ $page->slug }}</td>
                <td>{{ $page->template }}</td>
                <td><span class="status-badge status-{{ $page->is_active ? 'confirmed' : 'cancelled' }}">{{ $page->is_active ? 'Publiée' : 'Brouillon' }}</span></td>
                <td class="actions">
                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-primary">Modifier</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--text-light)">Aucune page</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
