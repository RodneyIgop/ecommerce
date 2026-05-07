<?php

namespace App\Services;

use App\Models\Order;
use App\Models\TransactionLog;
use App\Models\Notification;

class OrderStateMachine
{
    public static function transition(Order $order, string $newStatus, ?int $userId = null, ?string $reason = null): bool
    {
        if (!$order->canTransitionTo($newStatus)) {
            return false;
        }

        $oldStatus = $order->status;
        $order->transitionTo($newStatus, $reason);

        self::logTransition($order, $oldStatus, $newStatus, $userId, $reason);
        self::notifyTransition($order, $newStatus);

        match ($newStatus) {
            Order::STATUS_PAID => self::onPaid($order),
            Order::STATUS_PROCESSING => self::onProcessing($order),
            Order::STATUS_SHIPPED => self::onShipped($order),
            Order::STATUS_DELIVERED => self::onDelivered($order),
            Order::STATUS_CANCELLED => self::onCancelled($order),
            Order::STATUS_REFUNDED => self::onRefunded($order),
            default => null,
        };

        return true;
    }

    private static function onPaid(Order $order): void
    {
        InventoryManager::reserve(
            $order->items->first()->product,
            $order->items->sum('quantity'),
            $order->id,
            $order->buyer_id
        );
    }

    private static function onProcessing(Order $order): void
    {
        foreach ($order->items as $item) {
            InventoryManager::deduct(
                $item->product,
                $item->quantity,
                $order->id,
                $order->buyer_id,
                $item->variant_id
            );
        }
    }

    private static function onShipped(Order $order): void
    {
        if ($order->shipments->isNotEmpty()) {
            $shipment = $order->shipments->first();
            $shipment->timelines()->create([
                'status' => 'shipped',
                'location' => $shipment->origin_address['city'] ?? 'Warehouse',
                'timestamp' => now(),
                'notes' => 'Order has been shipped',
            ]);
        }
    }

    private static function onDelivered(Order $order): void
    {
        if ($order->shipments->isNotEmpty()) {
            $order->shipments->first()->timelines()->create([
                'status' => 'delivered',
                'location' => $order->shipping_address['city'] ?? 'Destination',
                'timestamp' => now(),
                'notes' => 'Order delivered successfully',
            ]);
        }
    }

    private static function onCancelled(Order $order): void
    {
        foreach ($order->items as $item) {
            InventoryManager::release(
                $item->product,
                $item->quantity,
                $order->id,
                $order->buyer_id,
                $item->variant_id
            );
        }
    }

    private static function onRefunded(Order $order): void
    {
        foreach ($order->items as $item) {
            InventoryManager::release(
                $item->product,
                $item->quantity,
                $order->id,
                $order->buyer_id,
                $item->variant_id
            );
        }
    }

    private static function logTransition(Order $order, string $oldStatus, string $newStatus, ?int $userId, ?string $reason): void
    {
        TransactionLog::create([
            'user_id' => $userId,
            'action' => 'order_status_change',
            'entity_type' => Order::class,
            'entity_id' => $order->id,
            'metadata' => [
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'reason' => $reason,
            ],
            'ip_address' => request()->ip(),
        ]);
    }

    private static function notifyTransition(Order $order, string $status): void
    {
        $messages = [
            Order::STATUS_CONFIRMED => 'Your order has been confirmed.',
            Order::STATUS_PAID => 'Payment received for your order.',
            Order::STATUS_PROCESSING => 'Your order is being processed.',
            Order::STATUS_PACKED => 'Your order has been packed.',
            Order::STATUS_SHIPPED => 'Your order has been shipped.',
            Order::STATUS_IN_TRANSIT => 'Your order is in transit.',
            Order::STATUS_DELIVERED => 'Your order has been delivered.',
            Order::STATUS_COMPLETED => 'Your order is complete.',
            Order::STATUS_CANCELLED => 'Your order has been cancelled.',
            Order::STATUS_REFUNDED => 'Refund processed for your order.',
        ];

        $title = match ($status) {
            Order::STATUS_CONFIRMED => 'Order Confirmed',
            Order::STATUS_PAID => 'Payment Received',
            Order::STATUS_PROCESSING => 'Order Processing',
            Order::STATUS_PACKED => 'Order Packed',
            Order::STATUS_SHIPPED => 'Order Shipped',
            Order::STATUS_IN_TRANSIT => 'In Transit',
            Order::STATUS_DELIVERED => 'Order Delivered',
            Order::STATUS_COMPLETED => 'Order Completed',
            Order::STATUS_CANCELLED => 'Order Cancelled',
            Order::STATUS_REFUNDED => 'Order Refunded',
            default => 'Order Update',
        };

        Notification::create([
            'user_id' => $order->buyer_id,
            'type' => 'order_update',
            'title' => $title,
            'message' => $messages[$status] ?? 'Your order has been updated.',
            'data' => ['order_id' => $order->id, 'status' => $status],
            'channel' => 'in_app',
        ]);
    }
}
