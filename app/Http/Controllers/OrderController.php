<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('buyer_id', auth()->id())
            ->with('business.businessProfile', 'items.product')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->buyer_id !== auth()->id() && $order->business_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product', 'items.variant', 'payments', 'invoices', 'shipments.timelines', 'disputes');

        return view('orders.show', compact('order'));
    }
}
