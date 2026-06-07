<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'gateway',
        'gateway_reference',
        'gateway_response',
        'amount',
        'expected_amount',
        'currency',
        'status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'gateway_response' => 'array',
            'amount'           => 'decimal:2',
            'expected_amount'  => 'decimal:2',
            'paid_at'          => 'datetime',
        ];
    }

    // ─── Helpers ──────────────────────────────────────────────
    public function isSuccessful(): bool
    {
        return $this->status === 'paid';
    }

    public function isPartial(): bool
    {
        return $this->status === 'partial_payment';
    }

    public function hasShortfall(): bool
    {
        return $this->amount < $this->expected_amount;
    }

    public function getShortfallAttribute(): float
    {
        return max(0, $this->expected_amount - $this->amount);
    }

    // ─── Relationships ────────────────────────────────────────
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}