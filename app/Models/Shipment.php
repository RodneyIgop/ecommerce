<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'courier', 'tracking_number', 'status',
        'weight', 'origin_address', 'destination_address',
        'shipped_at', 'delivered_at', 'estimated_delivery_date', 'shipping_cost'
    ];

    protected function casts(): array
    {
        return [
            'origin_address' => 'array',
            'destination_address' => 'array',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
            'estimated_delivery_date' => 'date',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function timelines()
    {
        return $this->hasMany(ShipmentTimeline::class);
    }
}
