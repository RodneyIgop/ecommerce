<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BulkPricing extends Model
{
    protected $table = 'bulk_pricing';
    
    protected $fillable = [
        'product_id',
        'min_quantity',
        'max_quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
