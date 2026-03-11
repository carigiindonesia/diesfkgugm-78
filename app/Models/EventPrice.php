<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'event_code',
        'event_variant',
        'event_label',
        'event_description',
        'is_bundle',
        'bundle_code',
        'bundle_label',
        'bundle_events',
        'base_price',
        'display_price',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_bundle' => 'boolean',
        'is_active' => 'boolean',
        'bundle_events' => 'array',
        'base_price' => 'integer',
        'display_price' => 'integer',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (EventPrice $price) {
            $price->display_price = (int) round($price->base_price * 1.10 * 1.11);
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeIndividual($query)
    {
        return $query->where('is_bundle', false);
    }

    public function scopeBundle($query)
    {
        return $query->where('is_bundle', true);
    }

    public function scopeForCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function getFormattedDisplayPriceAttribute(): string
    {
        return 'Rp '.number_format($this->display_price, 0, ',', '.');
    }

    public function getFormattedBasePriceAttribute(): string
    {
        return 'Rp '.number_format($this->base_price, 0, ',', '.');
    }
}
