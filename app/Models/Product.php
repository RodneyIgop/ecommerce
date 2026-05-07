<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'category_id', 'name', 'description',
        'retail_price', 'wholesale_price', 'stock', 'status', 'image', 'gender'
    ];

    public function business()
    {
        return $this->belongsTo(User::class, 'business_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function bulkPricing()
    {
        return $this->hasMany(BulkPricing::class)->orderBy('min_quantity');
    }

    public function getBulkPriceForQuantity($quantity)
    {
        $bulkPrice = $this->bulkPricing()
            ->where('min_quantity', '<=', $quantity)
            ->where(function($query) use ($quantity) {
                $query->whereNull('max_quantity')
                      ->orWhere('max_quantity', '>=', $quantity);
            })
            ->first();

        if ($bulkPrice) {
            // Calculate discount based on quantity range
            if ($quantity >= 100 && $quantity <= 200) {
                $discount = 0.10; // 10% discount for 100-200 pieces
            } elseif ($quantity > 200) {
                $discount = 0.15; // 15% discount for 200+ pieces
            } else {
                $discount = 0.05; // 5% discount for less than 100 pieces
            }
            
            return $this->retail_price * (1 - $discount);
        }

        return $this->retail_price;
    }
}
