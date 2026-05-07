<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreorderQueue extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'variant_id', 'user_id', 'quantity',
        'status', 'deposit_paid', 'full_amount', 'estimated_fulfillment_date', 'fulfilled_at'
    ];

    protected function casts(): array
    {
        return [
            'estimated_fulfillment_date' => 'date',
            'fulfilled_at' => 'datetime',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeQueued($query)
    {
        return $query->where('status', 'queued');
    }

    public function scopeFulfilled($query)
    {
        return $query->where('status', 'fulfilled');
    }
}
