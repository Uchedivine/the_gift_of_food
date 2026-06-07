<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'menu_item_id',
        'quantity',
        'price_at_time',
        'special_note',
    ];

    protected function casts(): array
    {
        return [
            'price_at_time' => 'decimal:2',
            'quantity'      => 'integer',
        ];
    }

    // ─── Relationships ───────────────────────────────────────
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    // ─── Helpers ─────────────────────────────────────────────
    public function getSubtotalAttribute(): float
    {
        return $this->price_at_time * $this->quantity;
    }
}