  <!-- ==================== NAVBAR ==================== -->
  <nav id="navbar" class="fixed w-full z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-slate-100 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-20 items-center">
        <!-- Logo -->
        <a href="#beranda" class="flex items-center gap-3 group">
          <div class="w-12 h-12 bg-gradient-to-br from-primary-600 to-primary-800 rounded-full flex items-center justify-center text-white font-black text-lg shadow-lg group-hover:scale-105 transition-transform">78</div>
          <div class="hidden sm:block">
            <span class="block font-black text-primary-900 leading-none text-sm uppercase tracking-wide">Dies Natalis</span>
            <span class="block text-[11px] font-bold text-primary-500 tracking-widest uppercase">FKG UGM 2026</span>
          </div>
        </a>

        <!-- Desktop Nav -->
        <div class="hidden lg:flex items-center gap-8">
          <a href="#kegiatan" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Kegiatan</a>
          <a href="#pembicara" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Pembicara</a>
          <a href="#jadwal" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Jadwal</a>
          <a href="#lokasi" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Lokasi</a>
          <div class="h-6 w-px bg-slate-200"></div>
          <a href="/registrasi" class="bg-primary-600 text-white px-5 py-2.5 rounded-full text-sm font-bold hover:bg-primary-700 transition-all shadow-md hover:shadow-lg flex items-center gap-2">Daftar <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></a>
        </div>

        <!-- Mobile Hamburger -->
        <button id="menu-btn" class="lg:hidden p-2 text-slate-600 hover:text-primary-600 transition-colors" onclick="toggleMenu()">
          <i data-lucide="menu" id="menu-icon" class="w-6 h-6"></i>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden hidden bg-white border-t border-slate-100 p-6 space-y-3 shadow-xl">
      <a href="#kegiatan" class="block py-3 font-bold text-slate-700 hover:text-primary-600" onclick="closeMenu()">Kegiatan</a>
      <a href="#pembicara" class="block py-3 font-bold text-slate-700 hover:text-primary-600" onclick="closeMenu()">Pembicara</a>
      <a href="#jadwal" class="block py-3 font-bold text-slate-700 hover:text-primary-600" onclick="closeMenu()">Jadwal</a>
      <a href="#lokasi" class="block py-3 font-bold text-slate-700 hover:text-primary-600" onclick="closeMenu()">Lokasi</a>
      <hr class="my-2 border-slate-100" />
      <a href="/registrasi" class="block bg-primary-600 text-white p-4 rounded-2xl font-bold text-center">Daftar Sekarang</a>
    </div>
  </nav>