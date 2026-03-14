<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $fillable = [
        'ip_address',
        'url',
        'method',
        'user_agent',
        'referer',
        'session_id',
        'email',
        'order_uuid',
        'order_status',
        'page_type',
    ];

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeByIp($query, string $ip)
    {
        return $query->where('ip_address', $ip);
    }

    public function scopeWithRegistration($query)
    {
        return $query->whereNotNull('email');
    }

    public function scopeWithPayment($query)
    {
        return $query->where('order_status', 'paid');
    }
}
