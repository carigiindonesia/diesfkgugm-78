<?php

namespace App\Services;

use App\Models\EventPrice;

class PricingService
{
    const PLATFORM_FEE_PERCENTAGE = 0.10;

    const PPN_PERCENTAGE = 0.11;

    public static function calculateDisplayPrice(int $basePrice): int
    {
        $afterPlatformFee = $basePrice * (1 + self::PLATFORM_FEE_PERCENTAGE);
        $afterPpn = $afterPlatformFee * (1 + self::PPN_PERCENTAGE);

        return (int) round($afterPpn);
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
