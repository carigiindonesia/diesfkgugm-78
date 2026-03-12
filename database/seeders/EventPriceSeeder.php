<?php

namespace Database\Seeders;

use App\Models\EventPrice;
use Illuminate\Database\Seeder;

class EventPriceSeeder extends Seeder
{
    public function run(): void
    {
        // [category, event_code, event_variant, event_label, event_description, base_price]
        $individualPrices = [
            // Simposium
            ['alumni', 'simposium', null, 'Simposium', null, 1000000],
            ['civitas', 'simposium', null, 'Simposium', null, 750000],
            ['umum', 'simposium', null, 'Simposium', null, 1150000],

            // Hands-on Workshops (each sold separately)
            ['alumni', 'handson', 'ho1', 'HO 1 — drg. Ryant Ganda S., Sp.B.M.Mf', 'Basic Digital Implantology: Step by Step from Planning to Guide Fabrication', 1500000],
            ['alumni', 'handson', 'ho2', 'HO 2 — drg. Rahmat Hidayat, Sp.Pros', 'Mastering Suction Dentures: Hands-On Techniques for Maximum Retention and Stabilization', 1500000],
            ['alumni', 'handson', 'ho3', 'HO 3 — drg. Pribadi Santosa, M.S., Sp.KG, Subsp.KR(K)', 'Secrets of Successful Class II Restorations (Disponsori oleh Revoden Asia)', 1500000],
            ['alumni', 'handson', 'ho5', 'HO 5 — drg. Rifqie Al Haris', 'AI-Driven Dentistry: Education, Innovation, and Business (Disponsori oleh Stoothdy - Kortugi)', 1500000],
            ['alumni', 'handson', 'ho6', 'HO 6 — drg. Anrizandy Narwidina, MDSc, Sp.KGA, Ph.D', 'Basic Clinical Assessment for Early Detection of Orofacial Functional and Airway Indicators in Children (Disponsori oleh Carigi Indonesia)', 1500000],
            ['alumni', 'handson', 'ho7', 'HO 7 — Dr. drg. Bramasto Purbo Sejati, Sp.B.M.Mf.,Subsp.Tr.Mf.S.Tm. & Dr. drg. Ananto Ali Alhasyimi, MDSc, Sp.Ort, Subsp.DDTK(K)', 'Dari Klinik ke Manuskrip Bereputasi, Solusi bagi Residen Menjawab Tuntutan Publikasi', 1500000],

            ['civitas', 'handson', 'ho1', 'HO 1 — drg. Ryant Ganda S., Sp.B.M.Mf', 'Basic Digital Implantology: Step by Step from Planning to Guide Fabrication', 1500000],
            ['civitas', 'handson', 'ho2', 'HO 2 — drg. Rahmat Hidayat, Sp.Pros', 'Mastering Suction Dentures: Hands-On Techniques for Maximum Retention and Stabilization', 1500000],
            ['civitas', 'handson', 'ho3', 'HO 3 — drg. Pribadi Santosa, M.S., Sp.KG, Subsp.KR(K)', 'Secrets of Successful Class II Restorations (Disponsori oleh Revoden Asia)', 1500000],
            ['civitas', 'handson', 'ho5', 'HO 5 — drg. Rifqie Al Haris', 'AI-Driven Dentistry: Education, Innovation, and Business (Disponsori oleh Stoothdy - Kortugi)', 1500000],
            ['civitas', 'handson', 'ho6', 'HO 6 — drg. Anrizandy Narwidina, MDSc, Sp.KGA, Ph.D', 'Basic Clinical Assessment for Early Detection of Orofacial Functional and Airway Indicators in Children (Disponsori oleh Carigi Indonesia)', 1500000],
            ['civitas', 'handson', 'ho7', 'HO 7 — Dr. drg. Bramasto Purbo Sejati, Sp.B.M.Mf.,Subsp.Tr.Mf.S.Tm. & Dr. drg. Ananto Ali Alhasyimi, MDSc, Sp.Ort, Subsp.DDTK(K)', 'Dari Klinik ke Manuskrip Bereputasi, Solusi bagi Residen Menjawab Tuntutan Publikasi', 1500000],

            ['umum', 'handson', 'ho1', 'HO 1 — drg. Ryant Ganda S., Sp.B.M.Mf', 'Basic Digital Implantology: Step by Step from Planning to Guide Fabrication', 1500000],
            ['umum', 'handson', 'ho2', 'HO 2 — drg. Rahmat Hidayat, Sp.Pros', 'Mastering Suction Dentures: Hands-On Techniques for Maximum Retention and Stabilization', 1500000],
            ['umum', 'handson', 'ho3', 'HO 3 — drg. Pribadi Santosa, M.S., Sp.KG, Subsp.KR(K)', 'Secrets of Successful Class II Restorations (Disponsori oleh Revoden Asia)', 1500000],
            ['umum', 'handson', 'ho5', 'HO 5 — drg. Rifqie Al Haris', 'AI-Driven Dentistry: Education, Innovation, and Business (Disponsori oleh Stoothdy - Kortugi)', 1500000],
            ['umum', 'handson', 'ho6', 'HO 6 — drg. Anrizandy Narwidina, MDSc, Sp.KGA, Ph.D', 'Basic Clinical Assessment for Early Detection of Orofacial Functional and Airway Indicators in Children (Disponsori oleh Carigi Indonesia)', 1500000],
            ['umum', 'handson', 'ho7', 'HO 7 — Dr. drg. Bramasto Purbo Sejati, Sp.B.M.Mf.,Subsp.Tr.Mf.S.Tm. & Dr. drg. Ananto Ali Alhasyimi, MDSc, Sp.Ort, Subsp.DDTK(K)', 'Dari Klinik ke Manuskrip Bereputasi, Solusi bagi Residen Menjawab Tuntutan Publikasi', 1500000],

            // Fun Run (5K and 3K, same price)
            ['alumni', 'funrun', '5k', 'Fun Run 5K', "Sudah termasuk:\n• Running Jersey\n• Finisher Medal\n• Snack and Refreshment\n• Doorprize", 350000],
            ['alumni', 'funrun', '3k', 'Fun Run 3K', "Sudah termasuk:\n• Running Jersey\n• Finisher Medal\n• Snack and Refreshment\n• Doorprize", 350000],

            ['civitas', 'funrun', '5k', 'Fun Run 5K', "Sudah termasuk:\n• Running Jersey\n• Finisher Medal\n• Snack and Refreshment\n• Doorprize", 250000],
            ['civitas', 'funrun', '3k', 'Fun Run 3K', "Sudah termasuk:\n• Running Jersey\n• Finisher Medal\n• Snack and Refreshment\n• Doorprize", 250000],

            ['umum', 'funrun', '5k', 'Fun Run 5K', "Sudah termasuk:\n• Running Jersey\n• Finisher Medal\n• Snack and Refreshment\n• Doorprize", 400000],
            ['umum', 'funrun', '3k', 'Fun Run 3K', "Sudah termasuk:\n• Running Jersey\n• Finisher Medal\n• Snack and Refreshment\n• Doorprize", 400000],

            // Pengabdian Masyarakat
            ['alumni', 'pengmas', null, 'Pengabdian Masyarakat', null, 250000],
            ['civitas', 'pengmas', null, 'Pengabdian Masyarakat', null, 150000],
            ['umum', 'pengmas', null, 'Pengabdian Masyarakat', null, 300000],
        ];

        $sortOrder = 1;
        foreach ($individualPrices as [$category, $eventCode, $variant, $eventLabel, $description, $basePrice]) {
            EventPrice::updateOrCreate(
                ['category' => $category, 'event_code' => $eventCode, 'event_variant' => $variant, 'is_bundle' => false, 'bundle_code' => null],
                [
                    'event_label' => $eventLabel,
                    'event_description' => $description,
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
