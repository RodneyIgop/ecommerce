<?php

namespace App\Services;

use App\Models\Product;
use App\Models\OrderItem;
use App\Models\ProductView;
use Illuminate\Support\Facades\DB;

class RecommendationEngine
{
    public static function alsoBought(int $productId, int $limit = 6): array
    {
        $productIds = OrderItem::select('product_id')
            ->whereIn('order_id', function ($query) use ($productId) {
                $query->select('order_id')
                    ->from('order_items')
                    ->where('product_id', $productId);
            })
            ->where('product_id', '!=', $productId)
            ->groupBy('product_id')
            ->orderByDesc(DB::raw('COUNT(*)'))
            ->limit($limit)
            ->pluck('product_id')
            ->toArray();

        return Product::whereIn('id', $productIds)
            ->where('status', 'active')
            ->get()
            ->toArray();
    }

    public static function trending(int $limit = 8): array
    {
        $productIds = OrderItem::select('product_id')
            ->whereHas('order', function ($q) {
                $q->where('created_at', '>=', now()->subDays(30));
            })
            ->groupBy('product_id')
            ->orderByDesc(DB::raw('SUM(quantity)'))
            ->limit($limit)
            ->pluck('product_id')
            ->toArray();

        return Product::whereIn('id', $productIds)
            ->where('status', 'active')
            ->get()
            ->toArray();
    }

    public static function related(int $productId, int $limit = 6): array
    {
        $product = Product::find($productId);
        if (!$product) {
            return [];
        }

        return Product::where(function ($query) use ($product) {
                $query->where('category_id', $product->category_id)
                      ->orWhere('product_group_id', $product->product_group_id);
            })
            ->where('id', '!=', $productId)
            ->where('status', 'active')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public static function recentlyViewed(?int $userId, ?string $sessionId, int $limit = 8): array
    {
        $query = ProductView::select('product_id')
            ->orderByDesc('created_at')
            ->limit(50);

        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($sessionId) {
            $query->where('session_id', $sessionId);
        }

        $productIds = $query->pluck('product_id')->unique()->take($limit)->toArray();

        return Product::whereIn('id', $productIds)
            ->where('status', 'active')
            ->get()
            ->toArray();
    }

    public static function recommendedSuppliers(int $businessId, int $limit = 6): array
    {
        $categoryIds = Product::where('business_id', $businessId)
            ->pluck('category_id')
            ->unique()
            ->toArray();

        return Product::whereIn('category_id', $categoryIds)
            ->where('business_id', '!=', $businessId)
            ->where('is_wholesale_enabled', true)
            ->where('status', 'active')
            ->with('business.businessProfile')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public static function trendingWholesale(int $limit = 8): array
    {
        $productIds = OrderItem::select('product_id')
            ->whereHas('order', function ($q) {
                $q->where('type', 'b2b')
                  ->where('created_at', '>=', now()->subDays(60));
            })
            ->groupBy('product_id')
            ->orderByDesc(DB::raw('SUM(quantity)'))
            ->limit($limit)
            ->pluck('product_id')
            ->toArray();

        return Product::whereIn('id', $productIds)
            ->where('status', 'active')
            ->get()
            ->toArray();
    }

    public static function bestSellingCategories(int $limit = 5): array
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.id', 'categories.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public static function recordView(int $productId, ?int $userId = null, ?string $sessionId = null): void
    {
        ProductView::create([
            'product_id' => $productId,
            'user_id' => $userId,
            'session_id' => $sessionId,
            'ip_address' => request()->ip(),
        ]);
    }
}
