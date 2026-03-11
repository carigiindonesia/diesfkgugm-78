@extends('layouts.app')

@section('content')
  <!-- Simple Navbar for Article Page -->
  <nav class="fixed w-full z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-20 items-center">
        <a href="/" class="flex items-center gap-3 group">
          <div class="w-12 h-12 bg-gradient-to-br from-primary-600 to-primary-800 rounded-full flex items-center justify-center text-white font-black text-lg shadow-lg group-hover:scale-105 transition-transform">78</div>
          <div class="hidden sm:block">
            <span class="block font-black text-primary-900 leading-none text-sm uppercase tracking-wide">Dies Natalis</span>
            <span class="block text-[11px] font-bold text-primary-500 tracking-widest uppercase">FKG UGM 2026</span>
          </div>
        </a>
        <a href="/" class="text-sm font-bold text-primary-600 hover:text-primary-700 transition-colors flex items-center gap-2">
          <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
      </div>
    </div>
  </nav>

  <!-- Article Content -->
  <article class="pt-32 pb-20 lg:pt-40 lg:pb-28">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      @if($article->featured_image)
      <div class="rounded-3xl overflow-hidden mb-10 shadow-xl">
        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-auto object-cover">
      </div>
      @endif

      @if($article->published_at)
      <div class="flex items-center gap-2 text-primary-500 text-sm font-bold mb-4">
        <i data-lucide="calendar" class="w-4 h-4"></i>
        <span>{{ $article->published_at->format('d F Y') }}</span>
      </div>
      @endif

      <h1 class="text-3xl md:text-5xl font-black text-slate-900 mb-8 leading-tight">{{ $article->title }}</h1>

      <div class="prose prose-lg prose-slate max-w-none">
        {!! $article->body !!}
      </div>

      <div class="mt-16 pt-8 border-t border-slate-200">
        <a href="/" class="inline-flex items-center gap-2 text-primary-600 font-bold hover:text-primary-700 transition-colors">
          <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Beranda
        </a>
      </div>
    </div>
  </article>
@endsection