<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountTier extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'product_id', 'min_quantity',
        'max_quantity', 'discount_percent', 'is_active'
    ];

    public function business()
    {
        return $this->belongsTo(User::class, 'business_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
