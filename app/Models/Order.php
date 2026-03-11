<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'tanggal_lahir',
        'nama_satusehat',
        'email_satusehat',
        'email',
        'whatsapp_satusehat',
        'whatsapp',
        'lembaga',
        'category',
        'jersey_type',
        'jersey_size',
        'quantity',
        'subtotal',
        'fee_amount',
        'total_amount',
        'status',
        'xendit_invoice_id',
        'xendit_invoice_url',
        'xendit_payment_method',
        'paid_at',
        'expired_at',
        'is_bundle',
        'bundle_code',
        'email_sent',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'quantity' => 'integer',
        'is_bundle' => 'boolean',
        'email_sent' => 'boolean',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'subtotal' => 'integer',
        'fee_amount' => 'integer',
        'total_amount' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $order->uuid = (string) Str::uuid();
            $order->order_number = 'DN78-'.now()->format('Ymd').'-'.strtoupper(Str::random(4));
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired';
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp '.number_format($this->total_amount, 0, ',', '.');
    }
}
