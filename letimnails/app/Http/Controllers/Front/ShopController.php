<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\{Product, Order, OrderItem, Quote};
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function cart()
    {
        $cartItems = Cart::instance('default')->content();
        $subtotal = Cart::instance('default')->subtotal();
        $shipping = Setting::get('shipping_cost', 0);
        $freeShippingThreshold = Setting::get('free_shipping_threshold', 50);
        $total = Cart::instance('default')->total();

        return view('front.shop.cart', compact(
            'cartItems', 'subtotal', 'shipping', 'freeShippingThreshold', 'total'
        ));
    }

    public function addToCart(Request $request, $slug)
    {
        $product = Product::active()->where('slug', $slug)->firstOrFail();
        $options = [
            'image' => $product->image,
            'sku' => $product->sku,
        ];

        if ($request->variation_id) {
            $variation = $product->variations()->findOrFail($request->variation_id);
            $options['variation'] = $variation->name;
            $options['variation_id'] = $variation->id;
        }

        Cart::instance('default')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->quantity ?? 1,
            'price' => $request->variation_id
                ? ($variation->price ?? $product->price)
                : $product->price,
            'options' => $options,
        ])->associate(Product::class);

        return redirect()->route('cart')->with('success', 'Produit ajouté au panier');
    }

    public function updateCart(Request $request)
    {
        if ($request->rowId && $request->qty) {
            Cart::instance('default')->update($request->rowId, $request->qty);
        }
        return redirect()->route('cart')->with('success', 'Panier mis à jour');
    }

    public function removeFromCart($rowId)
    {
        Cart::instance('default')->remove($rowId);
        return redirect()->route('cart')->with('success', 'Produit retiré du panier');
    }

    public function checkout()
    {
        if (Cart::instance('default')->count() === 0) {
            return redirect()->route('boutique')->with('error', 'Votre panier est vide');
        }

        $cartItems = Cart::instance('default')->content();
        $total = Cart::instance('default')->total();

        return view('front.shop.checkout', compact('cartItems', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $orderNumber = 'CMD-' . strtoupper(Str::random(8));

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => $orderNumber,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'subtotal' => Cart::instance('default')->subtotal(),
            'shipping_cost' => Setting::get('shipping_cost', 0),
            'discount' => 0,
            'total' => Cart::instance('default')->total(),
            'shipping_address' => [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
            ],
            'billing_address' => [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
            ],
        ]);

        foreach (Cart::instance('default')->content() as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'product_name' => $item->name,
                'product_sku' => $item->options->sku ?? null,
                'price' => $item->price,
                'quantity' => $item->qty,
                'subtotal' => $item->subtotal,
                'options' => $item->options->toArray(),
            ]);
        }

        Cart::instance('default')->destroy();

        return redirect()->route('order.confirmation', $orderNumber)
            ->with('success', 'Commande confirmée !');
    }

    public function confirmation($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items')->firstOrFail();
        return view('front.shop.confirmation', compact('order'));
    }
}
