<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\{User, Order, Quote, Appointment};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $ordersCount = Order::where('user_id', $user->id)->count();
        $quotesCount = Quote::where('user_id', $user->id)->count();
        $appointmentsCount = Appointment::where('user_id', $user->id)->count();
        $recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();

        return view('front.account.dashboard', compact(
            'user', 'ordersCount', 'quotesCount', 'appointmentsCount', 'recentOrders'
        ));
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('front.account.orders', compact('orders'));
    }

    public function orderDetail($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with('items')
            ->firstOrFail();

        return view('front.account.order-detail', compact('order'));
    }

    public function profile()
    {
        return view('front.account.profile');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
        ]);

        auth()->user()->update($validated);

        return redirect()->route('account.profile')
            ->with('success', 'Profil mis à jour avec succès');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:12|confirmed',
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('account.profile')
            ->with('success', 'Mot de passe mis à jour avec succès');
    }

    public function wishlist()
    {
        return view('front.account.wishlist');
    }

    public function addresses()
    {
        $addresses = auth()->user()->addresses;
        return view('front.account.addresses', compact('addresses'));
    }
}
