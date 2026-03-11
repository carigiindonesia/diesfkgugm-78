  @php
    $scientificSpeakers = \App\Models\Speaker::active()->section('scientific')->get();
  @endphp

  <!-- ==================== SCIENTIFIC SESSION ==================== -->
  <section class="py-20 lg:py-28 bg-slate-900 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary-600 rounded-full blur-[200px] opacity-10 pulse-bg"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-600 rounded-full blur-[150px] opacity-5"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-8 fade-in">
        <div>
          <p class="text-primary-400 font-bold text-sm tracking-[0.2em] uppercase mb-3">Academic Program</p>
          <h2 class="text-3xl md:text-5xl font-black mb-4">Scientific Session</h2>
          <p class="text-slate-400 max-w-2xl text-lg font-light">Sesi paralel ilmiah yang menghadirkan pakar dari berbagai spesialisasi kedokteran gigi.</p>
        </div>
        <a href="/registrasi?event=simposium" class="hidden md:flex items-center gap-2 text-primary-400 font-bold text-sm hover:text-primary-300 transition-colors whitespace-nowrap">
          Daftar Simposium <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 fade-in">
        @foreach($scientificSpeakers as $speaker)
        <div class="bg-white/5 border border-white/10 p-6 rounded-2xl hover:bg-white/10 transition-all hover:-translate-y-1">
          <div class="flex items-center gap-3 mb-4">
            @if($speaker->photo_url)
              <img src="{{ $speaker->photo_url }}" alt="{{ $speaker->name }}"
                   class="w-10 h-10 rounded-lg object-cover object-center flex-shrink-0">
            @else
              <span class="w-8 h-8 bg-primary-600/30 rounded-lg flex items-center justify-center text-primary-400 text-xs font-black">{{ $loop->iteration }}</span>
            @endif
            <span class="text-primary-400 text-[10px] font-black tracking-widest uppercase">{{ $speaker->title }}</span>
          </div>
          <h5 class="font-bold text-sm leading-snug mb-3">{{ $speaker->name }}</h5>
          @if($speaker->topic)
            <p class="text-slate-500 text-xs leading-relaxed italic">{{ $speaker->topic }}</p>
          @endif
        </div>
        @endforeach
      </div>
    </div>
  </section>
