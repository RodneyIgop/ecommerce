<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'invoice_number', 'user_id',
        'amount_due', 'amount_paid', 'due_date', 'status', 'pdf_path'
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
