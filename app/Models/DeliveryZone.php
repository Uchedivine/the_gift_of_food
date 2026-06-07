<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'areas',
        'delivery_fee',
        'estimated_minutes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'areas'             => 'array',
            'delivery_fee'      => 'decimal:2',
            'estimated_minutes' => 'integer',
            'is_active'         => 'boolean',
        ];
    }

    // ─── Scopes ───────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ─── Helpers ──────────────────────────────────────────────
    public function getEstimatedTimeAttribute(): string
    {
        if ($this->estimated_minutes < 60) {
            return "{$this->estimated_minutes} mins";
        }

        $hours = floor($this->estimated_minutes / 60);
        $mins  = $this->estimated_minutes % 60;

        return $mins > 0 ? "{$hours}hr {$mins}mins" : "{$hours}hr";
    }
}