<?php

namespace App\Services;

use App\Models\InventoryLog;
use App\Models\Product;
use App\Models\ProductVariant;

class InventoryManager
{
    public static function reserve(Product $product, int $quantity, int $orderId, int $userId, ?int $variantId = null): bool
    {
        $available = $product->getAvailableStock();
        if ($available < $quantity) {
            return false;
        }

        $product->reserved_stock = ($product->reserved_stock ?? 0) + $quantity;
        $product->save();

        InventoryLog::create([
            'product_id' => $product->id,
            'variant_id' => $variantId,
            'action' => 'reserve',
            'quantity_change' => -$quantity,
            'stock_after' => $product->stock,
            'reserved_after' => $product->reserved_stock,
            'reason' => 'Order reservation',
            'order_id' => $orderId,
            'user_id' => $userId,
        ]);

        return true;
    }

    public static function release(Product $product, int $quantity, int $orderId, int $userId, ?int $variantId = null): void
    {
        $product->reserved_stock = max(0, ($product->reserved_stock ?? 0) - $quantity);
        $product->save();

        InventoryLog::create([
            'product_id' => $product->id,
            'variant_id' => $variantId,
            'action' => 'release',
            'quantity_change' => 0,
            'stock_after' => $product->stock,
            'reserved_after' => $product->reserved_stock,
            'reason' => 'Order cancellation or release',
            'order_id' => $orderId,
            'user_id' => $userId,
        ]);
    }

    public static function deduct(Product $product, int $quantity, int $orderId, int $userId, ?int $variantId = null): bool
    {
        if ($product->stock < $quantity) {
            return false;
        }

        $product->stock -= $quantity;
        $product->reserved_stock = max(0, ($product->reserved_stock ?? 0) - $quantity);
        $product->save();

        InventoryLog::create([
            'product_id' => $product->id,
            'variant_id' => $variantId,
            'action' => 'deduct',
            'quantity_change' => -$quantity,
            'stock_after' => $product->stock,
            'reserved_after' => $product->reserved_stock,
            'reason' => 'Order fulfillment',
            'order_id' => $orderId,
            'user_id' => $userId,
        ]);

        return true;
    }

    public static function restock(Product $product, int $quantity, string $reason, int $userId, ?int $variantId = null): void
    {
        $product->stock += $quantity;
        $product->save();

        InventoryLog::create([
            'product_id' => $product->id,
            'variant_id' => $variantId,
            'action' => 'restock',
            'quantity_change' => $quantity,
            'stock_after' => $product->stock,
            'reserved_after' => $product->reserved_stock ?? 0,
            'reason' => $reason,
            'order_id' => null,
            'user_id' => $userId,
        ]);
    }

    public static function checkLowStock(Product $product): bool
    {
        $available = $product->getAvailableStock();
        return $available > 0 && $available <= 10;
    }
}
