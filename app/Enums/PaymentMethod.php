<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case PaymentGateway = 'payment_gateway';
    case Manual = 'manual';

    public function label(): string
    {
        return match ($this) {
            self::PaymentGateway => 'Payment Gateway',
            self::Manual => 'Manual',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PaymentGateway => 'primary',
            self::Manual => 'warning',
        };
    }
}
