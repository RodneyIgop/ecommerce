<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'name', 'type', 'base_rate',
        'weight_rate', 'distance_rate', 'handling_fee',
        'min_weight', 'max_weight', 'regions', 'couriers', 'is_active'
    ];

    protected function casts(): array
    {
        return [
            'regions' => 'array',
            'couriers' => 'array',
        ];
    }

    public function business()
    {
        return $this->belongsTo(User::class, 'business_id');
    }

    public function calculate(float $weight, float $distance = 1): float
    {
        if ($this->min_weight !== null && $weight < $this->min_weight) {
            return 0;
        }
        if ($this->max_weight !== null && $weight > $this->max_weight) {
            return 0;
        }

        return $this->base_rate
            + ($weight * $this->weight_rate)
            + ($distance * $this->distance_rate)
            + $this->handling_fee;
    }
}
