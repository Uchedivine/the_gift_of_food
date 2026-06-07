<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'request_details',
        'occasion',
        'quantity_estimate',
        'budget',
        'preferred_date',
        'status',
        'admin_note',
        'quoted_amount',
        'admin_response',
    ];

    protected function casts(): array
    {
        return [
            'budget'            => 'decimal:2',
            'quoted_amount'     => 'decimal:2',
            'preferred_date'    => 'date',
            'quantity_estimate' => 'integer',
        ];
    }

    // ─── Status Constants ─────────────────────────────────────
    const STATUS_NEW        = 'new';
    const STATUS_REVIEWING  = 'reviewing';
    const STATUS_QUOTED     = 'quoted';
    const STATUS_ACCEPTED   = 'accepted';
    const STATUS_DECLINED   = 'declined';

    // ─── Scopes ───────────────────────────────────────────────
    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', [
            self::STATUS_NEW,
            self::STATUS_REVIEWING,
        ]);
    }

    // ─── Relationships ────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Helpers ──────────────────────────────────────────────
    public function getRequesterNameAttribute(): string
    {
        return $this->user?->name ?? $this->name ?? 'Guest';
    }
}