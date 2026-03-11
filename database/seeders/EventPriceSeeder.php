<?php

namespace Database\Seeders;

use App\Models\EventPrice;
use Illuminate\Database\Seeder;

class EventPriceSeeder extends Seeder
{
    public function run(): void
    {
        $individualPrices = [
            // [category, event_code, event_label, base_price]
            ['alumni', 'simposium', 'Simposium', 1000000],
            ['alumni', 'handson', 'Hands-on Workshop', 1500000],
            ['alumni', 'funrun', 'Fun Run 5K', 350000],
            ['alumni', 'pengmas', 'Pengabdian Masyarakat', 250000],

            ['civitas', 'simposium', 'Simposium', 750000],
            ['civitas', 'handson', 'Hands-on Workshop', 1500000],
            ['civitas', 'funrun', 'Fun Run 5K', 250000],
            ['civitas', 'pengmas', 'Pengabdian Masyarakat', 150000],

            ['umum', 'simposium', 'Simposium', 1150000],
            ['umum', 'handson', 'Hands-on Workshop', 1500000],
            ['umum', 'funrun', 'Fun Run 5K', 400000],
            ['umum', 'pengmas', 'Pengabdian Masyarakat', 300000],
        ];

        $sortOrder = 1;
        foreach ($individualPrices as [$category, $eventCode, $eventLabel, $basePrice]) {
            EventPrice::updateOrCreate(
                ['category' => $category, 'event_code' => $eventCode, 'is_bundle' => false, 'bundle_code' => null],
                [
                    'event_label' => $eventLabel,
                    'base_price' => $basePrice,
                    'display_price' => (int) round($basePrice * 1.10 * 1.11),
                    'is_active' => true,
                    'sort_order' => $sortOrder++,
                ]
            );
        }

        $bundles = [
            // [category, bundle_code, bundle_label, bundle_events, base_price]
            ['alumni', 'sim+run+pm', '3-Paket (Simposium + Fun Run + PM)', ['simposium', 'funrun', 'pengmas'], 1400000],
            ['alumni', 'sim+run', 'Simposium + Fun Run', ['simposium', 'funrun'], 1200000],
            ['alumni', 'sim+pm', 'Simposium + PM', ['simposium', 'pengmas'], 1100000],
            ['alumni', 'pm+run', 'PM + Fun Run', ['pengmas', 'funrun'], 450000],

            ['civitas', 'sim+run+pm', '3-Paket (Simposium + Fun Run + PM)', ['simposium', 'funrun', 'pengmas'], 1100000],
            ['civitas', 'sim+run', 'Simposium + Fun Run', ['simposium', 'funrun'], 900000],
            ['civitas', 'sim+pm', 'Simposium + PM', ['simposium', 'pengmas'], 800000],
            ['civitas', 'pm+run', 'PM + Fun Run', ['pengmas', 'funrun'], 300000],

            ['umum', 'sim+run+pm', '3-Paket (Simposium + Fun Run + PM)', ['simposium', 'funrun', 'pengmas'], 1600000],
            ['umum', 'sim+run', 'Simposium + Fun Run', ['simposium', 'funrun'], 1400000],
            ['umum', 'sim+pm', 'Simposium + PM', ['simposium', 'pengmas'], 1300000],
            ['umum', 'pm+run', 'PM + Fun Run', ['pengmas', 'funrun'], 650000],
        ];

        $sortOrder = 1;
        foreach ($bundles as [$category, $bundleCode, $bundleLabel, $bundleEvents, $basePrice]) {
            EventPrice::updateOrCreate(
                ['category' => $category, 'event_code' => $bundleCode, 'is_bundle' => true, 'bundle_code' => $bundleCode],
                [
                    'event_label' => $bundleLabel,
                    'bundle_label' => $bundleLabel,
                    'bundle_events' => $bundleEvents,
                    'base_price' => $basePrice,
                    'display_price' => (int) round($basePrice * 1.10 * 1.11),
                    'is_active' => true,
                    'sort_order' => $sortOrder++,
                ]
            );
        }
    }
}
