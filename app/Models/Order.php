<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'guest_name',
        'guest_phone',
        'guest_email',
        'status',
        'order_type',
        'payment_method',
        'payment_status',
        'subtotal',
        'discount_amount',
        'delivery_fee',
        'total',
        'coupon_id',
        'delivery_address',
        'notes',
        'estimated_ready_at',
        'requires_verification',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'               => 'decimal:2',
            'discount_amount'        => 'decimal:2',
            'delivery_fee'           => 'decimal:2',
            'total'                  => 'decimal:2',
            'estimated_ready_at'     => 'datetime',
            'requires_verification'  => 'boolean',
        ];
    }

    // ─── Status Constants ─────────────────────────────────────
    const STATUS_PENDING    = 'pending';
    const STATUS_CONFIRMED  = 'confirmed';
    const STATUS_PREPARING  = 'preparing';
    const STATUS_READY      = 'ready';
    const STATUS_DELIVERED  = 'delivered';
    const STATUS_CANCELLED  = 'cancelled';

    const PAYMENT_UNPAID    = 'unpaid';
    const PAYMENT_PAID      = 'paid';
    const PAYMENT_PARTIAL   = 'partial_payment';
    const PAYMENT_REFUNDED  = 'refunded';

    // ─── Scopes ───────────────────────────────────────────────
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeNeedsVerification($query)
    {
        return $query->where('requires_verification', true);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // ─── Relationships ────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    // ─── Helpers ──────────────────────────────────────────────
    public function getCustomerNameAttribute(): string
    {
        return $this->user?->name ?? $this->guest_name ?? 'Guest';
    }

    public function getCustomerPhoneAttribute(): string
    {
        return $this->user?->phone ?? $this->guest_phone ?? 'N/A';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    public function isCancellable(): bool
    {
        return in_array($this->status, [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
        ]);
    }
}