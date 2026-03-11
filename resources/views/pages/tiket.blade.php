@extends('layouts.app')

@section('content')
  @include('components.navbar')

  <!-- ==================== TICKET VIEW PAGE ==================== -->
  <section class="pt-32 pb-20 min-h-screen bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Ticket Card -->
      <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden fade-in">

        <!-- Gold Header -->
        <div class="bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-500 px-8 py-8 text-center">
          <p class="text-amber-900/60 text-xs font-bold tracking-[0.2em] uppercase mb-1">Dies Natalis FKG UGM ke-78</p>
          <h1 class="text-2xl md:text-3xl font-black text-white">Annual Symposium 2026</h1>
          <p class="text-amber-100 text-sm mt-2">17 - 19 April 2026</p>
        </div>

        <!-- Ticket Code -->
        <div class="text-center py-6 border-b border-dashed border-slate-200">
          <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-1">Kode Tiket</p>
          <p class="text-2xl md:text-3xl font-black text-amber-600 tracking-wider font-mono">{{ $ticket->ticket_code }}</p>
        </div>

        <!-- Ticket Body -->
        <div class="p-8 space-y-6">
          <!-- Participant Details -->
          <div class="grid grid-cols-2 gap-6">
            <div>
              <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-1">Nama Peserta</p>
              <p class="text-sm font-bold text-slate-800">{{ $ticket->order->nama_lengkap }}</p>
            </div>
            <div>
              <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-1">Lembaga</p>
              <p class="text-sm font-bold text-slate-800">{{ $ticket->order->lembaga ?? '-' }}</p>
            </div>
            <div>
              <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-1">Kategori</p>
              <p class="text-sm font-bold text-slate-800">{{ ucfirst($ticket->order->category) }}</p>
            </div>
            <div>
              <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-1">Kegiatan</p>
              <p class="text-sm font-bold text-slate-800">{{ $ticket->event_label }}</p>
            </div>
          </div>

          <!-- Event Info -->
          <div class="bg-amber-50 rounded-2xl p-5 border border-amber-100">
            <div class="flex items-center gap-3 mb-2">
              <i data-lucide="calendar" class="w-4 h-4 text-amber-600"></i>
              <span class="text-sm font-bold text-amber-800">17 - 19 April 2026</span>
            </div>
            <div class="flex items-center gap-3">
              <i data-lucide="map-pin" class="w-4 h-4 text-amber-600"></i>
              <span class="text-sm font-bold text-amber-800">Fakultas Kedokteran Gigi UGM, Yogyakarta</span>
            </div>
          </div>

          <!-- Barcode -->
          <div class="text-center py-4">
            <div class="inline-block">
              {!! $barcode !!}
            </div>
          </div>

          <!-- QR Code -->
          <div class="text-center py-4">
            <div class="inline-block bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
              {!! $qrCode !!}
            </div>
            <p class="text-xs text-slate-400 mt-3">Scan QR Code saat registrasi ulang di lokasi</p>
          </div>
        </div>

        <!-- Ticket Footer -->
        <div class="px-8 pb-8">
          <div class="flex flex-col sm:flex-row gap-3">
            <a href="/tiket/{{ $ticket->ticket_code }}/download"
               class="flex-1 flex items-center justify-center gap-2 bg-amber-500 text-white py-3.5 rounded-xl font-bold text-sm hover:bg-amber-600 transition-all shadow-md">
              <i data-lucide="download" class="w-4 h-4"></i>
              Download Tiket
            </a>
            <button onclick="window.print()"
                    class="flex-1 flex items-center justify-center gap-2 bg-slate-100 text-slate-700 py-3.5 rounded-xl font-bold text-sm hover:bg-slate-200 transition-all">
              <i data-lucide="printer" class="w-4 h-4"></i>
              Cetak Tiket
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  @include('components.footer')
@endsection
