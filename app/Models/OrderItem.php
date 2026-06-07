<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_item_id',
        'item_name',
        'quantity',
        'unit_price',
        'subtotal',
        'special_note',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'subtotal'   => 'decimal:2',
            'quantity'   => 'integer',
        ];
    }

    // ─── Relationships ────────────────────────────────────────
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Soft-deleted menu items are still accessible here
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class)->withTrashed();
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}