<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Page, Faq, Testimonial, Slider, Setting, Media};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // Pages
    public function pages()
    {
        $pages = Page::orderBy('title')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function editPage(Page $page)
    {
        return view('admin.pages.form', compact('page'));
    }

    public function updatePage(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $page->update($validated);

        return redirect()->route('admin.pages')
            ->with('success', 'Page mise à jour');
    }

    // FAQ
    public function faqs()
    {
        $faqs = Faq::ordered()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function storeFaq(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        Faq::create($validated);

        return redirect()->route('admin.faqs')
            ->with('success', 'FAQ créée');
    }

    public function updateFaq(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'position' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $faq->update($validated);

        return redirect()->route('admin.faqs')
            ->with('success', 'FAQ mise à jour');
    }

    public function deleteFaq(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs')
            ->with('success', 'FAQ supprimée');
    }

    // Testimonials
    public function testimonials()
    {
        $testimonials = Testimonial::ordered()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'source' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials')
            ->with('success', 'Avis créé');
    }

    public function updateTestimonial(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'source' => 'nullable|string',
            'position' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials')
            ->with('success', 'Avis mis à jour');
    }

    public function deleteTestimonial(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials')
            ->with('success', 'Avis supprimé');
    }

    // Sliders
    public function sliders()
    {
        $sliders = Slider::ordered()->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function storeSlider(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'image' => 'required|image|mimes:jpeg,png,webp|max:5120',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,webp|max:5120',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['image'] = $request->file('image')->store('sliders', 'public');

        if ($request->hasFile('image_mobile')) {
            $validated['image_mobile'] = $request->file('image_mobile')->store('sliders', 'public');
        }

        Slider::create($validated);

        return redirect()->route('admin.sliders')
            ->with('success', 'Slider créé');
    }

    public function updateSlider(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:500',
            'position' => 'integer',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,webp|max:5120',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,webp|max:5120',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }
        if ($request->hasFile('image_mobile')) {
            $validated['image_mobile'] = $request->file('image_mobile')->store('sliders', 'public');
        }

        $slider->update($validated);

        return redirect()->route('admin.sliders')
            ->with('success', 'Slider mis à jour');
    }

    public function deleteSlider(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.sliders')
            ->with('success', 'Slider supprimé');
    }

    // General Settings
    public function general()
    {
        $settings = Setting::getGroup('general');
        return view('admin.settings.general', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'tiktok_url' => 'nullable|url|max:500',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'general');
        }

        return redirect()->route('admin.settings.general')
            ->with('success', 'Paramètres mis à jour');
    }

    public function shipping()
    {
        $settings = Setting::getGroup('shipping');
        return view('admin.settings.shipping', compact('settings'));
    }

    public function updateShipping(Request $request)
    {
        $validated = $request->validate([
            'shipping_cost' => 'required|numeric|min:0|max:999',
            'free_shipping_threshold' => 'required|numeric|min:0|max:9999',
            'shipping_delay' => 'nullable|string|max:100',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'shipping');
        }

        return redirect()->route('admin.settings.shipping')
            ->with('success', 'Paramètres de livraison mis à jour');
    }

    public function appearance()
    {
        $settings = Setting::getGroup('appearance');
        return view('admin.settings.appearance', compact('settings'));
    }

    public function updateAppearance(Request $request)
    {
        $validated = $request->validate([
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'font_family' => 'nullable|string|max:100',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'appearance');
        }

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('settings', 'public');
            Setting::set('logo', $path, 'appearance');
        }

        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('settings', 'public');
            Setting::set('favicon', $path, 'appearance');
        }

        return redirect()->route('admin.settings.appearance')
            ->with('success', 'Paramètres d\'apparence mis à jour');
    }

    // Media Library
    public function media()
    {
        $media = Media::latest()->paginate(30);
        return view('admin.media.index', compact('media'));
    }

    public function uploadMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,webp,gif,svg,pdf|max:5120',
            'collection' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('media/' . date('Y/m'), 'public');

            Media::create([
                'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'path' => $path,
                'size' => $file->getSize(),
                'collection' => $request->collection,
                'alt' => $request->alt ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            ]);
        }

        return redirect()->route('admin.media')
            ->with('success', 'Fichier uploadé');
    }

    public function deleteMedia(Media $media)
    {
        Storage::disk('public')->delete($media->path);
        $media->delete();
        return redirect()->route('admin.media')
            ->with('success', 'Fichier supprimé');
    }

    // Users
    public function users()
    {
        $users = User::where('is_admin', false)->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }
}
