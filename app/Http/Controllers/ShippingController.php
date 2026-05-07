<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\ShipmentTimeline;
use App\Services\OrderStateMachine;
use App\Services\NotificationService;

class ShippingController extends Controller
{
    public function update(Request $request, Order $order)
    {
        if ($order->business_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'courier' => 'required|string',
            'tracking_number' => 'required|string',
            'weight' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $shipment = Shipment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'courier' => $validated['courier'],
                'tracking_number' => $validated['tracking_number'],
                'weight' => $validated['weight'] ?? 0,
                'status' => 'shipped',
                'shipped_at' => now(),
            ]
        );

        ShipmentTimeline::create([
            'shipment_id' => $shipment->id,
            'status' => 'shipped',
            'location' => $order->shipping_address['city'] ?? 'Warehouse',
            'timestamp' => now(),
            'notes' => $validated['notes'] ?? 'Order shipped',
        ]);

        OrderStateMachine::transition($order, Order::STATUS_SHIPPED, auth()->id());

        NotificationService::notifyShipmentUpdate(
            $order->buyer,
            $order->id,
            $validated['tracking_number']
        );

        return back()->with('success', 'Shipment updated successfully.');
    }

    public function addTimeline(Request $request, Shipment $shipment)
    {
        $order = $shipment->order;
        if ($order->business_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|string',
            'location' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        ShipmentTimeline::create([
            'shipment_id' => $shipment->id,
            'status' => $validated['status'],
            'location' => $validated['location'],
            'timestamp' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('success', 'Timeline updated.');
    }
}
