<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\{HomeController, ShopController, ServiceController, AccountController};
use App\Http\Controllers\Admin\{DashboardController, ProductController, OrderController,
    ServiceController as AdminServiceController, ContentController, SettingsController};

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/boutique', [HomeController::class, 'boutique'])->name('boutique');
Route::get('/produit/{slug}', [HomeController::class, 'product'])->name('product.show');
Route::get('/galerie', [HomeController::class, 'galerie'])->name('galerie');
Route::get('/galerie/{slug}', [HomeController::class, 'galerieCategory'])->name('galerie.category');
Route::get('/nos-formes', [HomeController::class, 'formes'])->name('formes');
Route::get('/nos-conseils-dutilisation', [HomeController::class, 'conseils'])->name('conseils');
Route::get('/support', [HomeController::class, 'support'])->name('support');
Route::get('/page/{slug}', [HomeController::class, 'page'])->name('page');

// Shop & Cart
Route::get('/panier', [ShopController::class, 'cart'])->name('cart');
Route::post('/panier/ajouter/{slug}', [ShopController::class, 'addToCart'])->name('cart.add');
Route::post('/panier/mettre-a-jour', [ShopController::class, 'updateCart'])->name('cart.update');
Route::post('/panier/supprimer/{rowId}', [ShopController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/commander', [ShopController::class, 'checkout'])->name('checkout');
Route::post('/commander', [ShopController::class, 'placeOrder'])->name('checkout.place')->middleware('throttle:10,1');
Route::get('/commande/{orderNumber}', [ShopController::class, 'confirmation'])->name('order.confirmation')->middleware('auth');

// Services
Route::get('/demander-un-devis', [ServiceController::class, 'demandeDevis'])->name('devis');
Route::post('/demander-un-devis', [ServiceController::class, 'soumettreDevis'])->name('devis.submit')->middleware('throttle:5,1');
Route::get('/devis-confirme', [ServiceController::class, 'devisConfirmation'])->name('devis.confirmation');
Route::get('/reservation-prestation', [ServiceController::class, 'reservation'])->name('reservation');
Route::post('/reservation-prestation', [ServiceController::class, 'reserver'])->name('reservation.submit')->middleware('throttle:5,1');
Route::get('/reservation-confirmee', [ServiceController::class, 'reservationConfirmation'])->name('reservation.confirmation');

// Account
Route::middleware('auth')->prefix('mon-compte')->name('account.')->group(function () {
    Route::get('/', [AccountController::class, 'dashboard'])->name('dashboard');
    Route::get('/commandes', [AccountController::class, 'orders'])->name('orders');
    Route::get('/commandes/{orderNumber}', [AccountController::class, 'orderDetail'])->name('order.detail');
    Route::get('/profil', [AccountController::class, 'profile'])->name('profile');
    Route::post('/profil', [AccountController::class, 'updateProfile']);
    Route::post('/mot-de-passe', [AccountController::class, 'updatePassword'])->name('password.update');
    Route::get('/liste-souhaits', [AccountController::class, 'wishlist'])->name('wishlist');
    Route::get('/adresses', [AccountController::class, 'addresses'])->name('addresses');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', ProductController::class)->except(['show']);
    Route::post('/products/{product}/images/{image}/delete', [ProductController::class, 'deleteImage'])->name('products.image.delete');
    Route::post('/products/images/{image}/primary', [ProductController::class, 'setPrimaryImage'])->name('products.image.primary');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Quotes
    Route::get('/quotes', [AdminServiceController::class, 'quotes'])->name('quotes');
    Route::get('/quotes/{quote}', [AdminServiceController::class, 'showQuote'])->name('quotes.show');
    Route::post('/quotes/{quote}', [AdminServiceController::class, 'updateQuote'])->name('quotes.update');
    Route::delete('/quotes/{quote}', [AdminServiceController::class, 'deleteQuote'])->name('quotes.delete');

    // Appointments
    Route::get('/appointments', [AdminServiceController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/{appointment}', [AdminServiceController::class, 'showAppointment'])->name('appointments.show');
    Route::post('/appointments/{appointment}', [AdminServiceController::class, 'updateAppointment'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AdminServiceController::class, 'deleteAppointment'])->name('appointments.delete');

    // Appointment Types
    Route::get('/appointment-types', [AdminServiceController::class, 'appointmentTypes'])->name('appointments.types');
    Route::post('/appointment-types', [AdminServiceController::class, 'storeAppointmentType'])->name('appointments.types.store');
    Route::post('/appointment-types/{appointmentType}', [AdminServiceController::class, 'updateAppointmentType'])->name('appointments.types.update');
    Route::delete('/appointment-types/{appointmentType}', [AdminServiceController::class, 'deleteAppointmentType'])->name('appointments.types.delete');

    // Categories (products)
    Route::get('/categories', [ContentController::class, 'categories'])->name('categories');
    Route::post('/categories', [ContentController::class, 'storeCategory'])->name('categories.store');
    Route::post('/categories/{category}', [ContentController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [ContentController::class, 'deleteCategory'])->name('categories.delete');

    // Gallery Categories
    Route::get('/gallery/categories', [ContentController::class, 'galleryCategories'])->name('gallery.categories');
    Route::post('/gallery/categories', [ContentController::class, 'storeGalleryCategory'])->name('gallery.categories.store');
    Route::post('/gallery/categories/{galleryCategory}', [ContentController::class, 'updateGalleryCategory'])->name('gallery.categories.update');
    Route::delete('/gallery/categories/{galleryCategory}', [ContentController::class, 'deleteGalleryCategory'])->name('gallery.categories.delete');

    // Gallery Items
    Route::get('/gallery/{categoryId}/items', [ContentController::class, 'galleryItems'])->name('gallery.items');
    Route::post('/gallery/{categoryId}/items', [ContentController::class, 'storeGalleryItem'])->name('gallery.items.store');
    Route::post('/gallery/items/{galleryItem}', [ContentController::class, 'updateGalleryItem'])->name('gallery.items.update');
    Route::delete('/gallery/items/{galleryItem}', [ContentController::class, 'deleteGalleryItem'])->name('gallery.items.delete');

    // Nail Shapes
    Route::get('/shapes', [ContentController::class, 'shapes'])->name('shapes');
    Route::post('/shapes', [ContentController::class, 'storeShape'])->name('shapes.store');
    Route::post('/shapes/{nailShape}', [ContentController::class, 'updateShape'])->name('shapes.update');
    Route::delete('/shapes/{nailShape}', [ContentController::class, 'deleteShape'])->name('shapes.delete');

    // Pages CMS
    Route::get('/pages', [SettingsController::class, 'pages'])->name('pages');
    Route::get('/pages/{page}/edit', [SettingsController::class, 'editPage'])->name('pages.edit');
    Route::post('/pages/{page}', [SettingsController::class, 'updatePage'])->name('pages.update');

    // FAQs
    Route::get('/faqs', [SettingsController::class, 'faqs'])->name('faqs');
    Route::post('/faqs', [SettingsController::class, 'storeFaq'])->name('faqs.store');
    Route::post('/faqs/{faq}', [SettingsController::class, 'updateFaq'])->name('faqs.update');
    Route::delete('/faqs/{faq}', [SettingsController::class, 'deleteFaq'])->name('faqs.delete');

    // Testimonials
    Route::get('/testimonials', [SettingsController::class, 'testimonials'])->name('testimonials');
    Route::post('/testimonials', [SettingsController::class, 'storeTestimonial'])->name('testimonials.store');
    Route::post('/testimonials/{testimonial}', [SettingsController::class, 'updateTestimonial'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}', [SettingsController::class, 'deleteTestimonial'])->name('testimonials.delete');

    // Sliders
    Route::get('/sliders', [SettingsController::class, 'sliders'])->name('sliders');
    Route::post('/sliders', [SettingsController::class, 'storeSlider'])->name('sliders.store');
    Route::post('/sliders/{slider}', [SettingsController::class, 'updateSlider'])->name('sliders.update');
    Route::delete('/sliders/{slider}', [SettingsController::class, 'deleteSlider'])->name('sliders.delete');

    // Settings
    Route::get('/settings/general', [SettingsController::class, 'general'])->name('settings.general');
    Route::post('/settings/general', [SettingsController::class, 'updateGeneral']);
    Route::get('/settings/shipping', [SettingsController::class, 'shipping'])->name('settings.shipping');
    Route::post('/settings/shipping', [SettingsController::class, 'updateShipping']);
    Route::get('/settings/appearance', [SettingsController::class, 'appearance'])->name('settings.appearance');
    Route::post('/settings/appearance', [SettingsController::class, 'updateAppearance']);

    // Media
    Route::get('/media', [SettingsController::class, 'media'])->name('media');
    Route::post('/media', [SettingsController::class, 'uploadMedia'])->name('media.upload');
    Route::delete('/media/{media}', [SettingsController::class, 'deleteMedia'])->name('media.delete');

    // Users
    Route::get('/users', [SettingsController::class, 'users'])->name('users');
});

// Auth Routes
Route::get('/connexion', [App\Http\Controllers\Auth\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/connexion', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('/deconnexion', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
Route::get('/inscription', [App\Http\Controllers\Auth\AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/inscription', [App\Http\Controllers\Auth\AuthController::class, 'register']);
