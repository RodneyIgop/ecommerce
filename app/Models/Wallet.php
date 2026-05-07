<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'balance', 'currency', 'is_active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function credit(float $amount, string $description, Model $related): WalletTransaction
    {
        $this->balance += $amount;
        $this->save();

        return $this->transactions()->create([
            'type' => 'credit',
            'amount' => $amount,
            'balance_after' => $this->balance,
            'description' => $description,
            'related_id' => $related->id,
            'related_type' => get_class($related),
        ]);
    }

    public function debit(float $amount, string $description, Model $related): ?WalletTransaction
    {
        if ($this->balance < $amount) {
            return null;
        }

        $this->balance -= $amount;
        $this->save();

        return $this->transactions()->create([
            'type' => 'debit',
            'amount' => $amount,
            'balance_after' => $this->balance,
            'description' => $description,
            'related_id' => $related->id,
            'related_type' => get_class($related),
        ]);
    }
}
