<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
    ];

    // ─── Relationships ───────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // ─── Helpers ─────────────────────────────────────────────
    public function getTotalAttribute(): float
    {
        return $this->items->sum('subtotal');
    }

    public function getItemCountAttribute(): int
    {
        return $this->items->sum('quantity');
    }
}