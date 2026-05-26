@extends('layouts.admin')
@section('title', 'Utilisateurs')

@section('content')
<div style="overflow-x:auto">
    <table class="admin-table">
        <thead>
            <tr><th>Nom</th><th>Email</th><th>Tél</th><th>Inscription</th><th>Commandes</th></tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? '-' }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>{{ $user->orders->count() }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--text-light)">Aucun client</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $users->links() }}</div>
@endsection
