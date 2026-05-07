<?php

namespace App\Services;

use App\Models\PreorderQueue;
use App\Models\Product;
use App\Models\User;

class PreorderManager
{
    public static function queue(Product $product, User $user, int $quantity, ?int $variantId = null): PreorderQueue
    {
        $estimatedDate = $product->estimated_production_days
            ? now()->addDays($product->estimated_production_days)
            : now()->addDays(14);

        $fullAmount = $product->retail_price * $quantity;
        $deposit = $product->preorder_deposit_percent > 0
            ? $fullAmount * ($product->preorder_deposit_percent / 100)
            : 0;

        $queue = PreorderQueue::create([
            'product_id' => $product->id,
            'variant_id' => $variantId,
            'user_id' => $user->id,
            'quantity' => $quantity,
            'status' => 'queued',
            'deposit_paid' => $deposit,
            'full_amount' => $fullAmount,
            'estimated_fulfillment_date' => $estimatedDate,
        ]);

        $product->reserved_stock = ($product->reserved_stock ?? 0) + $quantity;
        $product->save();

        return $queue;
    }

    public static function fulfillNext(Product $product, int $quantityFulfilled): void
    {
        $queues = PreorderQueue::where('product_id', $product->id)
            ->where('status', 'queued')
            ->orderBy('created_at')
            ->get();

        $remaining = $quantityFulfilled;

        foreach ($queues as $queue) {
            if ($remaining <= 0) {
                break;
            }

            if ($remaining >= $queue->quantity) {
                $queue->update([
                    'status' => 'fulfilled',
                    'fulfilled_at' => now(),
                ]);
                $remaining -= $queue->quantity;
            } else {
                $queue->update([
                    'status' => 'partially_fulfilled',
                    'quantity' => $queue->quantity - $remaining,
                ]);
                $remaining = 0;
            }
        }

        $product->reserved_stock = max(0, ($product->reserved_stock ?? 0) - ($quantityFulfilled - $remaining));
        $product->stock += $remaining;
        $product->save();
    }

    public static function cancel(PreorderQueue $queue): void
    {
        $product = $queue->product;
        $product->reserved_stock = max(0, ($product->reserved_stock ?? 0) - $queue->quantity);
        $product->save();

        $queue->update(['status' => 'cancelled']);
    }

    public static function getQueuePosition(PreorderQueue $queue): int
    {
        return PreorderQueue::where('product_id', $queue->product_id)
            ->where('status', 'queued')
            ->where('created_at', '<', $queue->created_at)
            ->count() + 1;
    }
}
