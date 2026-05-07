<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public static function notify(User $user, string $type, string $title, string $message, array $data = [], string $channel = 'in_app'): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'channel' => $channel,
            'sent_at' => now(),
        ]);
    }

    public static function notifyOrderUpdate(User $user, int $orderId, string $status): Notification
    {
        $titles = [
            'confirmed' => 'Order Confirmed',
            'paid' => 'Payment Received',
            'processing' => 'Order Processing',
            'packed' => 'Order Packed',
            'shipped' => 'Order Shipped',
            'in_transit' => 'In Transit',
            'delivered' => 'Order Delivered',
            'completed' => 'Order Completed',
            'cancelled' => 'Order Cancelled',
            'refunded' => 'Order Refunded',
        ];

        return self::notify(
            $user,
            'order_update',
            $titles[$status] ?? 'Order Update',
            "Your order #{$orderId} has been updated to: " . ucfirst(str_replace('_', ' ', $status)),
            ['order_id' => $orderId, 'status' => $status],
            'in_app'
        );
    }

    public static function notifyPreorderUpdate(User $user, int $preorderId, string $status): Notification
    {
        return self::notify(
            $user,
            'preorder_update',
            'Preorder Update',
            "Your preorder #{$preorderId} status: " . ucfirst($status),
            ['preorder_id' => $preorderId, 'status' => $status]
        );
    }

    public static function notifyPaymentConfirmation(User $user, int $orderId, float $amount): Notification
    {
        return self::notify(
            $user,
            'payment_confirmation',
            'Payment Confirmed',
            "Payment of $" . number_format($amount, 2) . " received for order #{$orderId}.",
            ['order_id' => $orderId, 'amount' => $amount]
        );
    }

    public static function notifyShipmentUpdate(User $user, int $orderId, string $trackingNumber): Notification
    {
        return self::notify(
            $user,
            'shipment_update',
            'Shipment Update',
            "Order #{$orderId} has been shipped. Tracking: {$trackingNumber}",
            ['order_id' => $orderId, 'tracking_number' => $trackingNumber]
        );
    }

    public static function notifyLowStock(User $user, int $productId, string $productName): Notification
    {
        return self::notify(
            $user,
            'low_stock',
            'Low Stock Alert',
            "Product '{$productName}' is running low on stock.",
            ['product_id' => $productId, 'product_name' => $productName]
        );
    }

    public static function notifyDisputeUpdate(User $user, int $disputeId, string $status): Notification
    {
        return self::notify(
            $user,
            'dispute_update',
            'Dispute Update',
            "Dispute #{$disputeId} status updated to: " . ucfirst($status),
            ['dispute_id' => $disputeId, 'status' => $status]
        );
    }

    public static function getUnreadCount(User $user): int
    {
        return Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();
    }
}
