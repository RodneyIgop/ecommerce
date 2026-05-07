<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'total', 'discount_total', 'shipping_total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function recalculate(): void
    {
        $subtotal = 0;
        $discount = 0;
        $shipping = 0;

        foreach ($this->items as $item) {
            $itemTotal = $item->quantity * $item->unit_price;
            $subtotal += $itemTotal;
            $discount += $item->discount_amount;
            $shipping += $item->shipping_estimate;
        }

        $this->total = $subtotal - $discount;
        $this->discount_total = $discount;
        $this->shipping_total = $shipping;
        $this->save();
    }
}
