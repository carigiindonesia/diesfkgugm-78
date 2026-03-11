  @if($documents->count())
  <!-- ==================== DOCUMENTS ==================== -->
  <section class="py-20 lg:py-28 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16 fade-in">
        <p class="text-primary-600 font-bold text-sm tracking-[0.2em] uppercase mb-3">Dokumen</p>
        <h2 class="text-3xl md:text-5xl font-black text-slate-900">Unduhan & Tautan</h2>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 fade-in">
        @foreach($documents as $document)
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition-all hover:-translate-y-1">
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center flex-shrink-0">
              @if($document->isDownload())
                <i data-lucide="download" class="w-5 h-5 text-primary-600"></i>
              @else
                <i data-lucide="external-link" class="w-5 h-5 text-primary-600"></i>
              @endif
            </div>
            <div class="flex-1 min-w-0">
              <h4 class="font-bold text-slate-800 mb-1">{{ $document->title }}</h4>
              @if($document->description)
              <p class="text-slate-500 text-sm mb-3 leading-relaxed">{{ $document->description }}</p>
              @endif
              @if($document->isDownload())
                <a href="{{ asset('storage/' . $document->file) }}" download class="inline-flex items-center gap-2 text-primary-600 text-sm font-bold hover:text-primary-700 transition-colors">
                  <i data-lucide="download" class="w-4 h-4"></i> Unduh File
                </a>
              @else
                <a href="{{ $document->url }}" target="_blank" rel="noreferrer" class="inline-flex items-center gap-2 text-primary-600 text-sm font-bold hover:text-primary-700 transition-colors">
                  <i data-lucide="external-link" class="w-4 h-4"></i> Buka Tautan
                </a>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif