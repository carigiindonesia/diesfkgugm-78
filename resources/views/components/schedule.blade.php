  <!-- ==================== JADWAL / RUNDOWN ==================== -->
  <section id="jadwal" class="py-20 lg:py-28 bg-slate-100/50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16 fade-in">
        <p class="text-primary-600 font-bold text-sm tracking-[0.2em] uppercase mb-3">Agenda</p>
        <h2 class="text-3xl md:text-5xl font-black text-slate-900">Rundown Kegiatan</h2>
      </div>

      <!-- Tab Buttons -->
      <div class="flex flex-wrap justify-center gap-2 mb-10 bg-white p-2 rounded-2xl shadow-sm fade-in">
        <button data-tab="day1" onclick="switchDay('day1')" class="flex-1 min-w-[100px] py-3.5 rounded-xl font-black text-sm tracking-wider transition-all bg-primary-600 text-white shadow-lg">Hari 1</button>
        <button data-tab="day2" onclick="switchDay('day2')" class="flex-1 min-w-[100px] py-3.5 rounded-xl font-black text-sm tracking-wider transition-all text-slate-400 hover:text-slate-700">Hari 2</button>
        <button data-tab="day3" onclick="switchDay('day3')" class="flex-1 min-w-[100px] py-3.5 rounded-xl font-black text-sm tracking-wider transition-all text-slate-400 hover:text-slate-700">Hari 3</button>
        <button data-tab="day4" onclick="switchDay('day4')" class="flex-1 min-w-[100px] py-3.5 rounded-xl font-black text-sm tracking-wider transition-all text-slate-400 hover:text-slate-700">Hari 4</button>
      </div>

      <!-- DAY 1 -->
      <div data-day="day1">
        <div class="flex items-center gap-4 mb-8">
          <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary-600"><i data-lucide="calendar" class="w-5 h-5"></i></div>
          <h4 class="text-xl font-black text-primary-900">Jumat, 17 April 2026</h4>
        </div>
        <div class="space-y-3">
          <div class="bg-white p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-slate-100 shadow-sm"><span class="font-black text-primary-600 bg-primary-50 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap border border-primary-100">07:30 – 08:00</span><span class="font-semibold text-slate-700">Registrasi Peserta</span></div>
          <div class="bg-white p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-slate-100 shadow-sm"><span class="font-black text-primary-600 bg-primary-50 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap border border-primary-100">08:00 – 09:00</span><span class="font-semibold text-slate-700">Opening Ceremony, Sambutan Dekan FKG UGM, Wakil Rektor &amp; PB PDGI</span></div>
          <div class="bg-blue-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-blue-100 shadow-sm"><span class="font-black text-primary-700 bg-primary-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">09:00 – 09:45</span><div><span class="font-bold text-slate-800">Topic 1 — Prof. Dr. Norliza Ibrahim</span><span class="block text-xs text-slate-500 mt-1">+ 3-Minutes Pitch Competition Sesi 1 (Ruang HO)</span></div></div>
          <div class="bg-white p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-slate-100 shadow-sm"><span class="font-black text-slate-500 bg-slate-50 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">09:45 – 10:15</span><span class="font-semibold text-slate-700">Diskusi Topic 1 &amp; Coffee Break</span></div>
          <div class="bg-blue-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-blue-100 shadow-sm"><span class="font-black text-primary-700 bg-primary-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">10:15 – 11:15</span><div><span class="font-bold text-slate-800">Topic 2 — Dr. Matana Kettratad-Pruksapong, DDS, Ph.D., FRCDT</span><span class="block text-xs text-slate-500 mt-1">+ 3-Minutes Pitch Competition Sesi 2 (Ruang HO)</span></div></div>
          <div class="bg-white p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-slate-100 shadow-sm"><span class="font-black text-slate-500 bg-slate-50 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">11:15 – 11:30</span><span class="font-semibold text-slate-700">Diskusi Topic 2</span></div>
          <div class="bg-amber-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-amber-100 shadow-sm"><span class="font-black text-amber-700 bg-amber-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">11:30 – 13:00</span><span class="font-bold text-amber-800">ISHOMA</span></div>
          <div class="bg-blue-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-blue-100 shadow-sm"><span class="font-black text-primary-700 bg-primary-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">13:00 – 13:45</span><div><span class="font-bold text-slate-800">Topic 3 — drg. Rahmat Hidayat, Sp.Pros</span><span class="block text-xs text-slate-500 mt-1 italic">Chairside Digital Workflow for Crown and Fixed Dental Prothesis Fabrication</span></div></div>
          <div class="bg-white p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-slate-100 shadow-sm"><span class="font-black text-slate-500 bg-slate-50 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">13:45 – 14:00</span><span class="font-semibold text-slate-700">Diskusi Topic 3</span></div>
          <div class="bg-blue-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-blue-100 shadow-sm"><span class="font-black text-primary-700 bg-primary-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">14:00 – 14:45</span><div><span class="font-bold text-slate-800">Topic 4 — drg. Ryant Ganda S., Sp.B.M.Mf</span><span class="block text-xs text-slate-500 mt-1 italic">Basic Digital Implantology: Step by Step from Planning to Guide Fabrication</span></div></div>
          <div class="bg-white p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-slate-100 shadow-sm"><span class="font-black text-slate-500 bg-slate-50 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">14:45 – 15:00</span><span class="font-semibold text-slate-700">Diskusi Topic 4 &amp; Penutupan Hari Pertama</span></div>
          <div class="bg-purple-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-purple-100 shadow-sm"><span class="font-black text-purple-700 bg-purple-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">15:00 – 17:00</span><div><span class="font-bold text-purple-900">Hands-on 1, 2 &amp; 3</span><span class="block text-xs text-purple-600 mt-1">Paralel di Ruang HO (Nusantara, Grafika, Wanagama)</span></div></div>
        </div>
      </div>

      <!-- DAY 2 -->
      <div data-day="day2" class="hidden">
        <div class="flex items-center gap-4 mb-8">
          <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary-600"><i data-lucide="calendar" class="w-5 h-5"></i></div>
          <h4 class="text-xl font-black text-primary-900">Sabtu, 18 April 2026</h4>
        </div>
        <div class="space-y-3">
          <div class="bg-white p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-slate-100 shadow-sm"><span class="font-black text-primary-600 bg-primary-50 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap border border-primary-100">07:30 – 08:15</span><span class="font-semibold text-slate-700">Registrasi &amp; Opening oleh MC</span></div>
          <div class="bg-teal-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-teal-100 shadow-sm"><span class="font-black text-teal-700 bg-teal-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">08:15 – 09:45</span><div><span class="font-bold text-slate-800">Scientific Session 1–6</span><span class="block text-xs text-teal-600 mt-1">Paralel di Bulaksumur Ballroom &amp; Sekip Ballroom</span></div></div>
          <div class="bg-white p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-slate-100 shadow-sm"><span class="font-black text-slate-500 bg-slate-50 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">09:45 – 10:15</span><span class="font-semibold text-slate-700">Diskusi Panel &amp; Coffee Break</span></div>
          <div class="bg-teal-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-teal-100 shadow-sm"><span class="font-black text-teal-700 bg-teal-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">10:15 – 12:00</span><div><span class="font-bold text-slate-800">Scientific Session 7–11</span><span class="block text-xs text-teal-600 mt-1">Paralel di Bulaksumur Ballroom &amp; Sekip Ballroom</span></div></div>
          <div class="bg-amber-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-amber-100 shadow-sm"><span class="font-black text-amber-700 bg-amber-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">12:00 – 13:00</span><span class="font-bold text-amber-800">ISHOMA</span></div>
          <div class="bg-orange-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-orange-100 shadow-sm"><span class="font-black text-orange-700 bg-orange-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">13:00 – 13:15</span><span class="font-bold text-orange-800">Pengumuman Pemenang 3-Minutes Pitch Competition &amp; Penutupan Ilmiah</span></div>
          <div class="bg-purple-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-purple-100 shadow-sm"><span class="font-black text-purple-700 bg-purple-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">13:15 – 15:00</span><div><span class="font-bold text-purple-900">Hands-on 4, 5, 6 &amp; 7</span><span class="block text-xs text-purple-600 mt-1">Paralel di Ruang HO (Nusantara, Grafika, Wanagama, Yustisia)</span></div></div>
        </div>
      </div>

      <!-- DAY 3 -->
      <div data-day="day3" class="hidden">
        <div class="flex items-center gap-4 mb-8">
          <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-green-600"><i data-lucide="footprints" class="w-5 h-5"></i></div>
          <h4 class="text-xl font-black text-green-900">Minggu, 19 April 2026</h4>
        </div>
        <div class="space-y-3">
          <div class="bg-green-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-green-100 shadow-sm"><span class="font-black text-green-700 bg-green-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">06:00 – 09:00</span><span class="font-bold text-green-900">Fun Run Dies Natalis ke-78</span></div>
          <div class="bg-green-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-green-100 shadow-sm"><span class="font-black text-green-700 bg-green-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">09:00 – 11:30</span><span class="font-bold text-green-900">Hiburan &amp; Pengundian Doorprize</span></div>
        </div>
      </div>
    <!-- DAY 4 -->
      <div data-day="day4" class="hidden">
        <div class="flex items-center gap-4 mb-8">
          <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-rose-600"><i data-lucide="heart-handshake" class="w-5 h-5"></i></div>
          <h4 class="text-xl font-black text-rose-900">Senin, 20 April 2026</h4>
        </div>
        <div class="mb-6 bg-rose-50 border border-rose-200 rounded-2xl p-6">
          <h5 class="font-black text-rose-800 text-lg mb-2">Dental Charity Tourism</h5>
          <p class="text-slate-700 text-sm leading-relaxed">Pelayanan, Edukasi, dan Wisata Sehat — Wujud nyata kepedulian terhadap kesehatan gigi dan mulut masyarakat pesisir.</p>
          <div class="flex flex-wrap items-center gap-4 mt-4 text-rose-600 text-sm">
            <span class="flex items-center gap-2"><i data-lucide="map-pin" class="w-4 h-4"></i> Kawasan Pantai Baron, Gunungkidul</span>
            <span class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4"></i> 09:30 WIB – Selesai</span>
          </div>
        </div>
        <div class="space-y-3">
          <div class="bg-rose-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-rose-100 shadow-sm"><span class="font-black text-rose-700 bg-rose-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">09:30 – 10:00</span><span class="font-bold text-slate-800">Edukasi &amp; Penyuluhan: Materi kesehatan gigi khusus masyarakat pantai</span></div>
          <div class="bg-rose-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-rose-100 shadow-sm"><span class="font-black text-rose-700 bg-rose-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">10:00 – 12:00</span><div><span class="font-bold text-slate-800">Pelayanan Gigi Gratis</span><span class="block text-xs text-slate-500 mt-1">Scaling, Ekstraksi (cabut gigi), dan Restorasi (tambal gigi)</span></div></div>
          <div class="bg-rose-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-rose-100 shadow-sm"><span class="font-black text-rose-700 bg-rose-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">10:00 – 12:00</span><div><span class="font-bold text-slate-800">Konsultasi &amp; Screening</span><span class="block text-xs text-slate-500 mt-1">Pemeriksaan kesehatan mulut secara menyeluruh</span></div></div>
          <div class="bg-rose-50 p-5 rounded-2xl flex flex-col sm:flex-row gap-4 sm:items-center border border-rose-100 shadow-sm"><span class="font-black text-rose-700 bg-rose-100 px-3 py-1 rounded-lg text-xs tracking-wider whitespace-nowrap">12:00 – Selesai</span><span class="font-bold text-slate-800">Pembagian Bingkisan Sehat untuk 150 warga pemegang kupon</span></div>
        </div>
        <div class="mt-6 bg-white border border-slate-200 rounded-2xl p-5 text-sm text-slate-600">
          <p class="font-bold text-slate-800 mb-2">Kolaborasi:</p>
          <p>FKG UGM, Puskesmas Tanjung Sari, dan Pemerintah Desa Pantai Baron</p>
        </div>
      </div>
    </div>
  </section>