<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'category_id', 'product_group_id', 'name', 'description',
        'retail_price', 'wholesale_price', 'stock', 'reserved_stock', 'status', 'image', 'gender',
        'sku', 'weight', 'dimensions', 'moq', 'is_preorder', 'preorder_deposit_percent',
        'estimated_production_days', 'shipping_base_rate', 'shipping_weight_rate',
        'shipping_handling_fee', 'is_wholesale_enabled'
    ];

    public function business()
    {
        return $this->belongsTo(User::class, 'business_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productGroup()
    {
        return $this->belongsTo(ProductGroup::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function discountTiers()
    {
        return $this->hasMany(DiscountTier::class)->orderBy('min_quantity');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }

    public function productViews()
    {
        return $this->hasMany(ProductView::class);
    }

    public function preorderQueues()
    {
        return $this->hasMany(PreorderQueue::class);
    }

    public function getAvailableStock(): int
    {
        return $this->stock - ($this->reserved_stock ?? 0);
    }

    public function getDiscountTier(int $quantity): ?DiscountTier
    {
        return $this->discountTiers()
            ->where('is_active', true)
            ->where('min_quantity', '<=', $quantity)
            ->where(function ($query) use ($quantity) {
                $query->whereNull('max_quantity')
                      ->orWhere('max_quantity', '>=', $quantity);
            })
            ->orderBy('discount_percent', 'desc')
            ->first();
    }

    public function getBusinessDiscountTier(int $quantity): ?DiscountTier
    {
        return DiscountTier::where('business_id', $this->business_id)
            ->whereNull('product_id')
            ->where('is_active', true)
            ->where('min_quantity', '<=', $quantity)
            ->where(function ($query) use ($quantity) {
                $query->whereNull('max_quantity')
                      ->orWhere('max_quantity', '>=', $quantity);
            })
            ->orderBy('discount_percent', 'desc')
            ->first();
    }

    public function getFinalPrice(float $quantity, string $type = 'retail'): float
    {
        $basePrice = $type === 'wholesale' && $this->wholesale_price > 0
            ? $this->wholesale_price
            : $this->retail_price;

        $tier = $this->getDiscountTier((int) $quantity)
            ?? $this->getBusinessDiscountTier((int) $quantity);

        $discount = $tier ? ($tier->discount_percent / 100) : 0;

        return $basePrice * (1 - $discount);
    }

    public function getShippingFee(float $weight, float $distance = 1): float
    {
        return $this->shipping_base_rate
            + ($weight * $this->shipping_weight_rate)
            + $this->shipping_handling_fee;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWholesaleEnabled($query)
    {
        return $query->where('is_wholesale_enabled', true);
    }

    public function scopeInStock($query)
    {
        return $query->whereRaw('stock - COALESCE(reserved_stock, 0) > 0');
    }
}
