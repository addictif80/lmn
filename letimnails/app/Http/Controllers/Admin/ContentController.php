<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Category, GalleryCategory, GalleryItem, NailShape, NailSize};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // Categories
    public function categories()
    {
        $categories = Category::ordered()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:product,gallery,shape',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('admin.categories')
            ->with('success', 'Catégorie créée');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:product,gallery,shape',
            'position' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('slug')) {
            $validated['slug'] = Str::slug($request->slug);
        }
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()->route('admin.categories')
            ->with('success', 'Catégorie mise à jour');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories')
            ->with('success', 'Catégorie supprimée');
    }

    // Gallery
    public function galleryCategories()
    {
        $categories = GalleryCategory::ordered()->get();
        return view('admin.gallery.categories', compact('categories'));
    }

    public function storeGalleryCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        GalleryCategory::create($validated);

        return redirect()->route('admin.gallery.categories')
            ->with('success', 'Catégorie galerie créée');
    }

    public function updateGalleryCategory(Request $request, GalleryCategory $galleryCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'position' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        $galleryCategory->update($validated);

        return redirect()->route('admin.gallery.categories')
            ->with('success', 'Catégorie galerie mise à jour');
    }

    public function deleteGalleryCategory(GalleryCategory $galleryCategory)
    {
        $galleryCategory->delete();
        return redirect()->route('admin.gallery.categories')
            ->with('success', 'Catégorie galerie supprimée');
    }

    public function galleryItems($categoryId)
    {
        $category = GalleryCategory::findOrFail($categoryId);
        $items = $category->items()->ordered()->get();
        return view('admin.gallery.items', compact('category', 'items'));
    }

    public function storeGalleryItem(Request $request, $categoryId)
    {
        $category = GalleryCategory::findOrFail($categoryId);
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gallery/items', 'public');
        }

        $category->items()->create($validated);

        return redirect()->route('admin.gallery.items', $category)
            ->with('success', 'Image ajoutée à la galerie');
    }

    public function updateGalleryItem(Request $request, GalleryItem $galleryItem)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'position' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gallery/items', 'public');
        }

        $galleryItem->update($validated);

        return redirect()->route('admin.gallery.items', $galleryItem->gallery_category_id)
            ->with('success', 'Image mise à jour');
    }

    public function deleteGalleryItem(GalleryItem $galleryItem)
    {
        $categoryId = $galleryItem->gallery_category_id;
        $galleryItem->delete();
        return redirect()->route('admin.gallery.items', $categoryId)
            ->with('success', 'Image supprimée');
    }

    // Nail Shapes
    public function shapes()
    {
        $shapes = NailShape::ordered()->with('sizes')->get();
        return view('admin.shapes.index', compact('shapes'));
    }

    public function storeShape(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('shapes', 'public');
        }

        NailShape::create($validated);

        return redirect()->route('admin.shapes')
            ->with('success', 'Forme créée');
    }

    public function updateShape(Request $request, NailShape $nailShape)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'position' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('shapes', 'public');
        }

        $nailShape->update($validated);

        return redirect()->route('admin.shapes')
            ->with('success', 'Forme mise à jour');
    }

    public function deleteShape(NailShape $nailShape)
    {
        $nailShape->delete();
        return redirect()->route('admin.shapes')
            ->with('success', 'Forme supprimée');
    }
}
