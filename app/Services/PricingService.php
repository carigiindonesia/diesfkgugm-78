<?php

namespace App\Services;

use App\Models\EventPrice;

class PricingService
{
    const FEE_PERCENTAGE = 0.10;

    public static function calculateDisplayPrice(int $basePrice): int
    {
        return $basePrice + (int) round($basePrice * self::FEE_PERCENTAGE);
    }

    public static function calculateFee(int $basePrice): int
    {
        return self::calculateDisplayPrice($basePrice) - $basePrice;
    }

    public static function buildOrderTotals(EventPrice $eventPrice): array
    {
        return [
            'subtotal' => $eventPrice->base_price,
            'fee_amount' => self::calculateFee($eventPrice->base_price),
            'total_amount' => $eventPrice->display_price,
        ];
    }

    public static function formatRupiah(int $amount): string
    {
        return 'Rp '.number_format($amount, 0, ',', '.');
    }
}
