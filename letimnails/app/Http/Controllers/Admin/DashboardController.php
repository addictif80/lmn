<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Order, Product, Quote, Appointment, User};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $stats = [
            'products_count' => Product::count(),
            'orders_count' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'quotes_count' => Quote::count(),
            'pending_quotes' => Quote::where('status', 'pending')->count(),
            'appointments_count' => Appointment::count(),
            'upcoming_appointments' => Appointment::where('date', '>=', now())
                ->where('status', 'confirmed')
                ->count(),
            'users_count' => User::count(),
            'revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
            'recent_quotes' => Quote::latest()->take(5)->get(),
        ];

        // Monthly revenue chart data
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        return view('admin.pages.dashboard', compact('stats', 'monthlyRevenue'));
    }
}
