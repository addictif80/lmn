@extends('layouts.admin')
@section('title', 'Produits')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <p style="color:var(--text-light)">{{ $products->total() }} produit(s)</p>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Nouveau produit</a>
</div>

<div style="overflow-x:auto">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="" style="width:50px;height:50px;object-fit:cover;border-radius:8px">
                    @else
                    <div style="width:50px;height:50px;background:var(--bg-alt);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.2rem">&#9998;</div>
                    @endif
                </td>
                <td><strong>{{ $product->name }}</strong></td>
                <td>{{ $product->category?->name ?? '-' }}</td>
                <td>{{ number_format($product->price, 2) }} €</td>
                <td>{{ $product->track_stock ? $product->stock : '-' }}</td>
                <td>
                    <span class="status-badge status-{{ $product->is_active ? 'confirmed' : 'cancelled' }}">
                        {{ $product->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </td>
                <td class="actions">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">Modifier</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-form" onsubmit="return confirm('Supprimer ce produit ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light)">Aucun produit. <a href="{{ route('admin.products.create') }}">Créer le premier produit</a></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $products->links() }}</div>
@endsection
