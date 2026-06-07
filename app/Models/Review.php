<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_item_id',
        'order_item_id',
        'rating',
        'body',
        'is_approved',
    ];

    protected function casts(): array
    {
        return [
            'rating'      => 'integer',
            'is_approved' => 'boolean',
        ];
    }

    // ─── Scopes ───────────────────────────────────────────────
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // ─── Relationships ────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class)->withTrashed();
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}