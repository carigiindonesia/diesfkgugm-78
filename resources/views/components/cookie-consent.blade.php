<!-- Cookie Consent Banner -->
<div id="cookie-consent" class="fixed bottom-0 inset-x-0 z-[100] transition-transform duration-500 translate-y-full" role="dialog" aria-label="Cookie Consent">
  <div class="bg-white border-t border-slate-200 shadow-2xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-5">
      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
        <!-- Icon -->
        <div class="hidden sm:flex shrink-0 w-12 h-12 bg-primary-100 rounded-xl items-center justify-center">
          <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
        </div>

        <!-- Text -->
        <div class="flex-1">
          <h3 class="text-sm font-bold text-slate-900">Kebijakan Cookie & Privasi</h3>
          <p class="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
            Situs ini menggunakan cookie untuk meningkatkan pengalaman Anda, menganalisis traffic, dan memastikan keamanan transaksi.
            Dengan melanjutkan menggunakan situs ini, Anda menyetujui penggunaan cookie sesuai
            <button onclick="document.getElementById('cookie-policy-modal').classList.remove('hidden')" class="underline text-primary-600 hover:text-primary-800 font-medium">Kebijakan Privasi</button> kami.
          </p>
        </div>

        <!-- Buttons -->
        <div class="flex gap-2 shrink-0 w-full sm:w-auto">
          <button onclick="acceptCookies('essential')" class="flex-1 sm:flex-none px-4 py-2.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
            Hanya Esensial
          </button>
          <button onclick="acceptCookies('all')" class="flex-1 sm:flex-none px-6 py-2.5 text-xs font-bold text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors shadow-lg shadow-primary-600/25">
            Terima Semua
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Cookie Policy Modal -->
<div id="cookie-policy-modal" class="hidden fixed inset-0 z-[110] flex items-center justify-center p-4" role="dialog" aria-label="Kebijakan Cookie">
  <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('cookie-policy-modal').classList.add('hidden')"></div>
  <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[80vh] overflow-y-auto p-6 sm:p-8">
    <button onclick="document.getElementById('cookie-policy-modal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    <h2 class="text-lg font-black text-slate-900 mb-4">Kebijakan Cookie & Privasi</h2>

    <div class="space-y-4 text-sm text-slate-600 leading-relaxed">
      <div>
        <h3 class="font-bold text-slate-800 mb-1">1. Cookie Esensial</h3>
        <p>Cookie ini diperlukan untuk fungsi dasar situs seperti keamanan, manajemen sesi, dan proses pembayaran. Cookie ini tidak dapat dinonaktifkan.</p>
      </div>
      <div>
        <h3 class="font-bold text-slate-800 mb-1">2. Cookie Analitik</h3>
        <p>Kami menggunakan cookie analitik untuk memahami bagaimana pengunjung menggunakan situs kami, sehingga kami dapat meningkatkan layanan dan pengalaman pengguna.</p>
      </div>
      <div>
        <h3 class="font-bold text-slate-800 mb-1">3. Pengumpulan Data</h3>
        <p>Kami mencatat data kunjungan seperti alamat IP, halaman yang diakses, dan waktu akses untuk keperluan keamanan dan peningkatan layanan. Data transaksi diproses secara aman melalui gateway pembayaran resmi (Xendit).</p>
      </div>
      <div>
        <h3 class="font-bold text-slate-800 mb-1">4. Keamanan Data</h3>
        <p>Seluruh data pribadi dan transaksi dilindungi dengan enkripsi dan disimpan sesuai standar keamanan yang berlaku. Kami tidak membagikan data pribadi kepada pihak ketiga tanpa persetujuan Anda.</p>
      </div>
      <div>
        <h3 class="font-bold text-slate-800 mb-1">5. Hak Pengguna</h3>
        <p>Anda berhak mengakses, memperbarui, atau meminta penghapusan data pribadi Anda. Hubungi kami melalui helpdesk untuk permintaan terkait data pribadi.</p>
      </div>
    </div>

    <div class="mt-6 flex gap-2">
      <button onclick="document.getElementById('cookie-policy-modal').classList.add('hidden')" class="flex-1 px-4 py-2.5 text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors">
        Tutup
      </button>
    </div>
  </div>
</div>

<script>
  (function() {
    var consent = localStorage.getItem('cookie_consent');
    if (!consent) {
      setTimeout(function() {
        var el = document.getElementById('cookie-consent');
        if (el) el.classList.remove('translate-y-full');
      }, 1500);
    }
  })();

  function acceptCookies(level) {
    localStorage.setItem('cookie_consent', level);
    localStorage.setItem('cookie_consent_date', new Date().toISOString());
    var el = document.getElementById('cookie-consent');
    if (el) el.classList.add('translate-y-full');
  }
</script>
