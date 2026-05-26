<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\{Slider, Product, Category, Testimonial, Faq, NailShape, GalleryCategory, Page, Setting};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();
        $featuredProducts = Product::active()->featured()->with('primaryImage')->take(8)->get();
        $categories = Category::active()->byType('product')->ordered()->get();
        $testimonials = Testimonial::active()->ordered()->get();
        $faqs = Faq::active()->ordered()->get();
        $shapes = NailShape::active()->ordered()->with('sizes')->get();
        $galleryCategories = GalleryCategory::active()->ordered()->get();
        $shippingInfo = Setting::get('shipping_info', 'Dès 50€ d\'achat en France Métropolitaine');

        return view('front.pages.home', compact(
            'sliders', 'featuredProducts', 'categories', 'testimonials',
            'faqs', 'shapes', 'galleryCategories', 'shippingInfo'
        ));
    }

    public function boutique()
    {
        $categories = Category::active()->byType('product')->ordered()->get();
        $products = Product::active()->with('primaryImage', 'category')
            ->when(request('category'), fn($q) => $q->where('category_id', request('category')))
            ->when(request('search'), fn($q) => $q->where('name', 'like', '%'.request('search').'%'))
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('front.shop.index', compact('products', 'categories'));
    }

    public function product($slug)
    {
        $product = Product::active()->where('slug', $slug)
            ->with('images', 'variations', 'category')
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('primaryImage')
            ->take(4)
            ->get();

        return view('front.shop.show', compact('product', 'relatedProducts'));
    }

    public function page($slug)
    {
        $page = Page::active()->where('slug', $slug)->firstOrFail();
        return view('front.pages.static', compact('page'));
    }

    public function galerie()
    {
        $categories = GalleryCategory::active()->ordered()->get();
        return view('front.gallery.index', compact('categories'));
    }

    public function galerieCategory($slug)
    {
        $category = GalleryCategory::active()->where('slug', $slug)->firstOrFail();
        $items = $category->items()->active()->ordered()->get();
        return view('front.gallery.category', compact('category', 'items'));
    }

    public function formes()
    {
        $shapes = NailShape::active()->ordered()->with('sizes')->get();
        return view('front.pages.formes', compact('shapes'));
    }

    public function conseils()
    {
        return view('front.pages.conseils');
    }

    public function support()
    {
        $faqs = Faq::active()->ordered()->get();
        return view('front.pages.support', compact('faqs'));
    }
}
