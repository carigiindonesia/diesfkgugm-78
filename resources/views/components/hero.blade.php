  <!-- ==================== HERO ==================== -->
  <section id="beranda" class="relative pt-32 pb-20 lg:pt-44 lg:pb-36 bg-gradient-to-br from-primary-950 via-primary-800 to-primary-700 text-white overflow-hidden">
    <!-- Decorative blobs -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary-400 rounded-full blur-[200px] opacity-10"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-gold-500 rounded-full blur-[150px] opacity-5"></div>
    <div class="absolute inset-0 opacity-[0.03]" style="background-image:url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
        <div class="text-center lg:text-left">
          <!-- Badge -->
          <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full text-xs font-bold mb-8 border border-white/10 tracking-widest uppercase">
            <i data-lucide="calendar" class="w-3.5 h-3.5"></i> 17 – 19 April 2026 &bull; Yogyakarta
          </div>

          <!-- Title -->
          <p class="text-gold-400 font-black text-sm tracking-[0.2em] uppercase mb-3">Dies Natalis FKG UGM ke-78</p>
          <h1 class="text-5xl md:text-6xl lg:text-7xl font-black leading-[0.95] mb-6 tracking-tight">
            ANNUAL<br/>SYMPOSIUM
          </h1>
          <p class="text-lg md:text-xl text-white/80 mb-8 max-w-xl mx-auto lg:mx-0 leading-relaxed italic font-light">
            &ldquo;Empowering Dental Sociopreneurs: Education and Technology for Oral Health Transformation&rdquo;
          </p>

          <!-- Subthemes -->
          <div class="flex flex-wrap justify-center lg:justify-start gap-2 mb-10">
            <span class="px-3 py-1.5 bg-white/10 border border-white/10 rounded-full text-[11px] font-bold tracking-wide">Modern Innovation for Clinical Solutions</span>
            <span class="px-3 py-1.5 bg-white/10 border border-white/10 rounded-full text-[11px] font-bold tracking-wide">Connecting Science to Public Needs</span>
            <span class="px-3 py-1.5 bg-white/10 border border-white/10 rounded-full text-[11px] font-bold tracking-wide">Community Centered Oral Health Transformation</span>
          </div>

          <!-- Venue -->
          <div class="flex items-center justify-center lg:justify-start gap-2 text-white/60 text-sm mb-10">
            <i data-lucide="map-pin" class="w-4 h-4"></i>
            <span>Gadjah Mada University Club Hotel, Yogyakarta</span>
          </div>

          <!-- CTAs -->
          <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
            <a href="/registrasi?kategori=umum&event=simposium" class="bg-white text-primary-900 px-8 py-4 rounded-full font-black text-base hover:shadow-2xl transition-all hover:-translate-y-0.5 text-center shadow-xl">Registrasi Simposium</a>
            <a href="/registrasi?event=handson" class="bg-white/10 text-white px-8 py-4 rounded-full font-bold text-base hover:bg-white/20 transition-all text-center border border-white/20 backdrop-blur-sm">Registrasi Hands-on</a>
            <a href="/registrasi?event=funrun" class="bg-green-500/20 text-white px-8 py-4 rounded-full font-bold text-base hover:bg-green-500/30 transition-all text-center border border-green-400/20 backdrop-blur-sm">Fun Run</a>
            <a href="/registrasi?event=pengmas" class="bg-rose-500/20 text-white px-8 py-4 rounded-full font-bold text-base hover:bg-rose-500/30 transition-all text-center border border-rose-400/20 backdrop-blur-sm">Pengabdian Masyarakat</a>
          </div>
        </div>

        <!-- Right: 78 badge -->
        <div class="hidden lg:flex justify-center">
          @if($settings['hero_logo'])
            <img src="{{ asset('storage/' . $settings['hero_logo']) }}" alt="Dies Natalis FKG UGM ke-78" class="w-72 h-72 object-contain">
          @else
          <div class="relative float-anim">
            <div class="w-72 h-72 bg-white/5 backdrop-blur-lg rounded-[3.5rem] border border-white/10 flex flex-col items-center justify-center p-8 shadow-2xl">
              <span class="text-[130px] font-black italic leading-none tracking-tighter text-white/90">78</span>
              <span class="text-lg font-black tracking-[0.25em] -mt-2 text-white/30 uppercase">Anniversary</span>
              <div class="mt-4 flex items-center gap-2">
                <div class="h-0.5 w-8 bg-gold-400/50 rounded-full"></div>
                <span class="text-gold-400/60 text-[10px] font-bold tracking-widest">1948 – 2026</span>
                <div class="h-0.5 w-8 bg-gold-400/50 rounded-full"></div>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </section>