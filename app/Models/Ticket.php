<?php

namespace App\Models;

use App\Enums\EventType;
use App\Enums\ParticipantCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_item_id',
        'ticket_code',
        'event_code',
        'event_label',
        'participant_name',
        'participant_lembaga',
        'category',
        'is_checked_in',
        'checked_in_at',
        'checked_in_by',
    ];

    protected $casts = [
        'is_checked_in' => 'boolean',
        'checked_in_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function getRouteKeyName(): string
    {
        return 'ticket_code';
    }

    public static function generateCode(string $eventCode, string $category): string
    {
        $evtEnum = EventType::from($eventCode);
        $catEnum = ParticipantCategory::from($category);
        $prefix = "DN78-{$evtEnum->shortCode()}-{$catEnum->shortCode()}";

        $lastTicket = static::where('ticket_code', 'like', "{$prefix}%")
            ->orderByDesc('ticket_code')
            ->first();

        $nextNum = $lastTicket
            ? ((int) substr($lastTicket->ticket_code, -5)) + 1
            : 1;

        return $prefix . str_pad($nextNum, 5, '0', STR_PAD_LEFT);
    }
}
