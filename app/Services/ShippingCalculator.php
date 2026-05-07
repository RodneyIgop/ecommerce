<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ShippingRule;
use App\Models\User;

class ShippingCalculator
{
    public static function calculateForProduct(Product $product, float $weight = 0, float $distance = 1, ?string $region = null): float
    {
        $rule = self::findRule($product->business_id, $weight, $distance, $region);

        if ($rule) {
            return $rule->calculate($weight, $distance);
        }

        return $product->getShippingFee($weight, $distance);
    }

    public static function calculateForCart(User $business, float $totalWeight, float $distance = 1, ?string $region = null, array $itemWeights = []): float
    {
        $rule = self::findRule($business->id, $totalWeight, $distance, $region);

        if ($rule) {
            return $rule->calculate($totalWeight, $distance);
        }

        $total = 0;
        foreach ($itemWeights as $item) {
            $product = $item['product'] ?? Product::find($item['product_id']);
            $weight = $item['weight'] ?? 0;
            $total += $product->getShippingFee($weight, $distance);
        }

        return $total;
    }

    public static function findRule(int $businessId, float $weight, float $distance, ?string $region = null): ?ShippingRule
    {
        $query = ShippingRule::where('business_id', $businessId)
            ->where('is_active', true)
            ->where(function ($q) use ($weight) {
                $q->whereNull('min_weight')->orWhere('min_weight', '<=', $weight);
            })
            ->where(function ($q) use ($weight) {
                $q->whereNull('max_weight')->orWhere('max_weight', '>=', $weight);
            })
            ->orderBy('base_rate', 'asc');

        if ($region) {
            $query->where(function ($q) use ($region) {
                $q->whereNull('regions')
                  ->orWhereJsonContains('regions', $region);
            });
        }

        return $query->first();
    }

    public static function estimateDeliveryDate(?string $courier = null, string $type = 'local'): ?\DateTime
    {
        $days = match ($type) {
            'local' => rand(2, 5),
            'national' => rand(3, 7),
            'international' => rand(7, 21),
            default => 5,
        };

        return now()->addDays($days);
    }
}
