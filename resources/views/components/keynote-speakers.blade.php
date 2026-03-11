  @php
    $keynoteSpeakers = \App\Models\Speaker::active()->section('keynote')->get();
  @endphp

  <!-- ==================== KEYNOTE SPEAKERS ==================== -->
  <section id="pembicara" class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16 fade-in">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary-50 text-primary-600 rounded-full text-xs font-bold mb-4 tracking-widest uppercase border border-primary-100">
          <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> Keynote &amp; Main Speakers
        </div>
        <h2 class="text-3xl md:text-5xl font-black text-slate-900">Expert Panel</h2>
        <p class="text-slate-500 mt-4 max-w-2xl mx-auto">Narasumber ahli internasional dan nasional yang membawakan topik utama simposium.</p>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 fade-in">
        @foreach($keynoteSpeakers as $speaker)
        <div class="bg-slate-50 rounded-3xl overflow-hidden hover:shadow-2xl transition-all group border border-slate-100">
          <div class="h-64 bg-gradient-to-br from-primary-100 to-primary-50 relative flex items-center justify-center">
            @if($speaker->photo_url)
              <img src="{{ $speaker->photo_url }}" alt="{{ $speaker->name }}"
                   class="w-full h-full object-cover object-center">
            @else
              <div class="w-28 h-28 rounded-full bg-primary-200 flex items-center justify-center text-primary-700 font-black text-3xl">
                {{ $speaker->initials_display }}
              </div>
            @endif
            <div class="absolute bottom-3 left-3 right-3 bg-white/95 backdrop-blur-md p-3 rounded-xl shadow-lg">
              <div class="text-[10px] font-black text-primary-600 tracking-widest uppercase mb-1">Topic {{ $loop->iteration }}</div>
              <h5 class="font-black text-slate-800 text-sm leading-tight">{{ $speaker->name }}</h5>
            </div>
          </div>
          <div class="p-6">
            <p class="text-[10px] font-black text-primary-500 tracking-widest uppercase mb-2">{{ $speaker->title }}</p>
            @if($speaker->topic)
              <p class="text-slate-500 text-xs leading-relaxed">{{ $speaker->topic }}</p>
            @endif
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
