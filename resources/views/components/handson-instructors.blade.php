  @php
    $handsonSpeakers = \App\Models\Speaker::active()->section('handson')->get();
  @endphp

  <!-- ==================== HANDS-ON INSTRUCTORS ==================== -->
  <section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16 fade-in">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-purple-50 text-purple-600 rounded-full text-xs font-bold mb-4 tracking-widest uppercase border border-purple-100">
          <i data-lucide="hand" class="w-3.5 h-3.5"></i> Skill Excellence
        </div>
        <h2 class="text-3xl md:text-5xl font-black text-slate-900">Instruktur Hands-on</h2>
        <p class="text-slate-500 mt-4 max-w-xl mx-auto">Pelatihan klinis praktis untuk mengasah keahlian teknis bersama instruktur spesialis. Setiap workshop dijual terpisah.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 fade-in">
        @foreach($handsonSpeakers as $speaker)
          @php
            $isSpecial = $loop->last && str_contains($speaker->name, '&');
          @endphp
          <div class="{{ $isSpecial ? 'lg:col-span-2 border-primary-100 bg-primary-50/30' : 'border-purple-50 hover:border-purple-200 bg-slate-50/30' }} p-8 rounded-3xl border-2 hover:shadow-xl transition-all group">
            <!-- Photo Area (1:1 ratio) -->
            @if($speaker->photo_url)
              <div class="w-20 h-20 rounded-2xl overflow-hidden mb-6 shadow-sm">
                <img src="{{ $speaker->photo_url }}" alt="{{ $speaker->name }}"
                     class="w-full h-full object-cover object-center">
              </div>
            @else
              <div class="w-12 h-12 {{ $isSpecial ? 'bg-primary-600 text-white' : 'bg-white text-purple-600 group-hover:bg-purple-600 group-hover:text-white' }} rounded-2xl flex items-center justify-center mb-6 shadow-sm transition-colors">
                <i data-lucide="{{ $isSpecial ? 'file-text' : 'hand' }}" class="w-5 h-5"></i>
              </div>
            @endif

            <span class="text-[10px] font-black {{ $isSpecial ? 'text-primary-600' : 'text-purple-500' }} tracking-widest uppercase">HO {{ $loop->iteration }} &bull; {{ $speaker->day }}</span>
            <h5 class="font-black text-lg {{ $isSpecial ? 'text-primary-900' : 'text-slate-800' }} mt-2 mb-3 leading-tight">{{ $speaker->name }}</h5>
            @if($speaker->topic)
              <p class="{{ $isSpecial ? 'text-primary-700/70 text-sm' : 'text-slate-500 text-xs' }} leading-relaxed">{{ $speaker->topic }}</p>
            @endif
          </div>
        @endforeach
      </div>

      <div class="mt-16 flex justify-center fade-in">
        <a href="/registrasi?event=handson" class="group bg-purple-600 text-white px-10 py-4 rounded-full font-black text-base hover:shadow-2xl transition-all hover:bg-purple-700 flex items-center gap-3">
          Daftar Hands-on <i data-lucide="chevron-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
        </a>
      </div>
    </div>
  </section>
