  @if($articles->count())
  <!-- ==================== ARTICLES ==================== -->
  <section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16 fade-in">
        <p class="text-primary-600 font-bold text-sm tracking-[0.2em] uppercase mb-3">Berita</p>
        <h2 class="text-3xl md:text-5xl font-black text-slate-900">Artikel Terbaru</h2>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 fade-in">
        @foreach($articles as $article)
        <a href="/artikel/{{ $article->slug }}" class="bg-slate-50 rounded-3xl overflow-hidden border border-slate-100 hover:shadow-xl transition-all hover:-translate-y-1 group">
          @if($article->featured_image)
          <div class="h-48 overflow-hidden">
            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          </div>
          @endif
          <div class="p-6">
            @if($article->published_at)
            <span class="text-xs font-bold text-primary-500 tracking-widest uppercase">{{ $article->published_at->format('d M Y') }}</span>
            @endif
            <h4 class="font-black text-lg text-slate-800 mt-2 mb-2 leading-tight group-hover:text-primary-600 transition-colors">{{ $article->title }}</h4>
            @if($article->excerpt)
            <p class="text-slate-500 text-sm leading-relaxed">{{ $article->excerpt }}</p>
            @endif
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </section>
  @endif