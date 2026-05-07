<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id', 'business_id', 'type', 'status',
        'total', 'commission', 'platform_fee'
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function business()
    {
        return $this->belongsTo(User::class, 'business_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function disputes()
    {
        return $this->hasMany(Dispute::class);
    }
}
