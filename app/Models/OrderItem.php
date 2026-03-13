<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'event_code',
        'event_label',
        'base_price',
        'display_price',
        'participant_name',
        'participant_tanggal_lahir',
        'participant_nik',
        'participant_lembaga',
        'participant_nama_satusehat',
        'participant_jersey_type',
        'participant_jersey_size',
        'participant_emergency_contact_name',
        'participant_emergency_contact_whatsapp',
    ];

    protected $casts = [
        'base_price' => 'integer',
        'display_price' => 'integer',
        'participant_tanggal_lahir' => 'date',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }
}
