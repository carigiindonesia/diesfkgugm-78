<?php

namespace Database\Seeders;

use App\Models\Speaker;
use Illuminate\Database\Seeder;

class SpeakerSeeder extends Seeder
{
    public function run(): void
    {
        $speakers = [
            // Keynote Speakers
            ['slug' => 'norliza-ibrahim', 'name' => 'Prof. Dr. Norliza binti Ibrahim', 'title' => 'Keynote Speaker', 'topic' => null, 'section' => 'keynote', 'initials' => 'NI', 'sort_order' => 1],
            ['slug' => 'matana-kettratad', 'name' => 'Dr. Matana Kettratad-Pruksapong', 'title' => 'DDS, Ph.D., FRCDT — Keynote Speaker', 'topic' => null, 'section' => 'keynote', 'initials' => 'MK', 'sort_order' => 2],
            ['slug' => 'rahmat-hidayat', 'name' => 'drg. Rahmat Hidayat, Sp.Pros', 'title' => 'Main Speaker', 'topic' => 'Chairside Digital Workflow for Crown and Fixed Dental Prothesis Fabrication', 'section' => 'keynote', 'initials' => 'RH', 'sort_order' => 3],
            ['slug' => 'ryant-ganda', 'name' => 'drg. Ryant Ganda S., Sp.B.M.Mf', 'title' => 'Main Speaker', 'topic' => 'Basic Digital Implantology: Step by Step from Planning to Guide Fabrication', 'section' => 'keynote', 'initials' => 'RG', 'sort_order' => 4],

            // Scientific Session Speakers
            ['slug' => 'cendrawasih-farmasyanti', 'name' => 'Dr. drg. Cendrawasih Andusyana Farmasyanti, M.Kes., Sp.Ort(K)', 'title' => 'Ortodonsi', 'topic' => 'Modern Clinical Solutions in Dentocraniofacial Disharmony: Selected Case of Cleft Lip Palate and Orthognatic Surgery', 'section' => 'scientific', 'initials' => 'CF', 'sort_order' => 1],
            ['slug' => 'rini-widyaningrum', 'name' => 'Dr. drg. Rini Widyaningrum, M.Biotech, Sp.RKG', 'title' => 'Radiologi', 'topic' => 'From Pixels to Precision: Multidisciplinary Artificial Intelligence Collaboration for Modern Clinical Solutions', 'section' => 'scientific', 'initials' => 'RW', 'sort_order' => 2],
            ['slug' => 'muhammad-reza-pahlevi', 'name' => 'drg. Muhammad Reza Pahlevi, Ph.D', 'title' => 'BMM', 'topic' => null, 'section' => 'scientific', 'initials' => 'MR', 'sort_order' => 3],
            ['slug' => 'pribadi-santosa', 'name' => 'drg. Pribadi Santosa, M.S., Sp.KG, Subsp.KR(K)', 'title' => 'Konservasi Gigi', 'topic' => null, 'section' => 'scientific', 'initials' => 'PS', 'sort_order' => 4],
            ['slug' => 'vincensia-maria-karina', 'name' => 'drg. Vincensia Maria Karina, MDSc., Sp.Perio', 'title' => 'Periodonsia', 'topic' => null, 'section' => 'scientific', 'initials' => 'VK', 'sort_order' => 5],
            ['slug' => 'titik-ismiyati', 'name' => 'Prof. drg. Titik Ismiyati, M.S., Sp.Pros.(K)', 'title' => 'Prostodonsia', 'topic' => null, 'section' => 'scientific', 'initials' => 'TI', 'sort_order' => 6],
            ['slug' => 'asikin-nur', 'name' => 'drg. Asikin Nur, M.Kes, Ph.D', 'title' => 'Biomedis', 'topic' => 'Inovasi Produk Kosmetik Antibakteri dari Bahan Herbal Biji Ketumbar', 'section' => 'scientific', 'initials' => 'AN', 'sort_order' => 7],
            ['slug' => 'friska-ani-rahman', 'name' => 'Dr. drg. Friska Ani Rahman, MDSc', 'title' => 'IBKG', 'topic' => null, 'section' => 'scientific', 'initials' => 'FR', 'sort_order' => 8],
            ['slug' => 'tetiana-haniastuti', 'name' => 'Prof. drg. Tetiana Haniastuti, M.Kes., Ph.D', 'title' => 'Oral Biology', 'topic' => 'Connecting Oral Biology to Public Needs: Pendekatan Sains untuk Indonesia Sehat', 'section' => 'scientific', 'initials' => 'TH', 'sort_order' => 9],
            ['slug' => 'indra-bramanti', 'name' => 'Dr. drg. Indra Bramanti, M.Sc., Sp.KGA, Subsp.PKOA(K)', 'title' => 'IKGA', 'topic' => "Saving Children's Smiles: Are We Treating Disease or Preventing It?", 'section' => 'scientific', 'initials' => 'IB', 'sort_order' => 10],
            ['slug' => 'rosa-amalia', 'name' => 'Prof. Dr. drg. Rosa Amalia, M.Kes', 'title' => 'IKGM', 'topic' => null, 'section' => 'scientific', 'initials' => 'RA', 'sort_order' => 11],

            // Hands-on Instructors
            ['slug' => 'ho-ryant-ganda', 'name' => 'drg. Ryant Ganda S., Sp.B.M.Mf', 'title' => null, 'topic' => 'Basic Digital Implantology: Step by Step from Planning to Guide Fabrication', 'section' => 'handson', 'day' => 'Day 1', 'initials' => 'RG', 'sort_order' => 1],
            ['slug' => 'ho-rahmat-hidayat', 'name' => 'drg. Rahmat Hidayat, Sp.Pros', 'title' => null, 'topic' => 'Mastering Suction Dentures: Hands-On Techniques for Maximum Retention and Stabilization', 'section' => 'handson', 'day' => 'Day 1', 'initials' => 'RH', 'sort_order' => 2],
            ['slug' => 'ho-pribadi-santosa', 'name' => 'drg. Pribadi Santosa, M.S., Sp.KG, Subsp.KR(K)', 'title' => null, 'topic' => null, 'section' => 'handson', 'day' => 'Day 1', 'initials' => 'PS', 'sort_order' => 3],
            ['slug' => 'ho-aji-tri-baskara', 'name' => 'drg. Aji Tri Baskara, Sp.KG', 'title' => null, 'topic' => null, 'section' => 'handson', 'day' => 'Day 2', 'initials' => 'AB', 'sort_order' => 4],
            ['slug' => 'ho-rifqie-al-haris', 'name' => 'drg. Rifqie Al Haris', 'title' => null, 'topic' => null, 'section' => 'handson', 'day' => 'Day 2', 'initials' => 'RA', 'sort_order' => 5],
            ['slug' => 'ho-anrizandy-narwidina', 'name' => 'drg. Anrizandy Narwidina, MDSc, Sp.KGA, Ph.D', 'title' => null, 'topic' => null, 'section' => 'handson', 'day' => 'Day 2', 'initials' => 'AN', 'sort_order' => 6],
            ['slug' => 'ho-bramasto-ananto', 'name' => 'Dr. drg. Bramasto Purbo Sejati, Sp.B.M.Mf.,Subsp.Tr.Mf.S.Tm. & Dr. drg. Ananto Ali Alhasyimi, MDSc, Sp.Ort, Subsp.DDTK(K)', 'title' => null, 'topic' => 'Dari Klinik ke Manuskrip Bereputasi, Solusi bagi Residen Menjawab Tuntutan Publikasi', 'section' => 'handson', 'day' => 'Day 2', 'initials' => 'BA', 'sort_order' => 7],
        ];

        foreach ($speakers as $data) {
            Speaker::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
