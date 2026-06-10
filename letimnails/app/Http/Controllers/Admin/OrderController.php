<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $orders = Order::with('user', 'items')
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->when(request('search'), fn($q) => $q->where('order_number', 'like', '%' . request('search') . '%'))
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'payment_status' => 'nullable|string|in:pending,paid,failed,refunded',
            'tracking_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $updateData = ['status' => $validated['status']];

        if (isset($validated['payment_status'])) {
            $updateData['payment_status'] = $validated['payment_status'];
            if ($validated['payment_status'] === 'paid') {
                $updateData['paid_at'] = now();
            }
        }

        if (isset($validated['tracking_number'])) {
            $updateData['tracking_number'] = $validated['tracking_number'];
        }

        if (isset($validated['notes'])) {
            $updateData['notes'] = $validated['notes'];
        }

        if ($validated['status'] === 'shipped') {
            $updateData['shipped_at'] = now();
        }

        $order->update($updateData);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Commande mise à jour');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
            ->with('success', 'Commande supprimée');
    }
}
