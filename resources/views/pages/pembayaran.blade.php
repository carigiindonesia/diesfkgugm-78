@extends('layouts.app')

@section('content')
  @include('components.navbar')

  <!-- ==================== PAYMENT STATUS PAGE ==================== -->
  <section class="pt-32 pb-20 min-h-screen bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Status Header -->
      <div class="text-center mb-10 fade-in">
        @if($order->status === 'pending')
          <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i data-lucide="clock" class="w-10 h-10 text-yellow-600"></i>
          </div>
          <h1 class="text-3xl font-black text-slate-800">Menunggu Pembayaran</h1>
          <p class="text-slate-500 mt-2">Segera selesaikan pembayaran sebelum batas waktu berakhir.</p>
        @elseif($order->status === 'paid')
          <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i data-lucide="check-circle" class="w-10 h-10 text-green-600"></i>
          </div>
          <h1 class="text-3xl font-black text-slate-800">Pembayaran Berhasil</h1>
          <p class="text-slate-500 mt-2">Terima kasih! Tiket Anda sudah tersedia.</p>
        @elseif($order->status === 'expired')
          <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i data-lucide="timer-off" class="w-10 h-10 text-red-600"></i>
          </div>
          <h1 class="text-3xl font-black text-slate-800">Pembayaran Kedaluwarsa</h1>
          <p class="text-slate-500 mt-2">Batas waktu pembayaran telah berakhir. Silakan mendaftar ulang.</p>
        @elseif($order->status === 'failed')
          <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i data-lucide="x-circle" class="w-10 h-10 text-red-600"></i>
          </div>
          <h1 class="text-3xl font-black text-slate-800">Pembayaran Gagal</h1>
          <p class="text-slate-500 mt-2">Terjadi kesalahan pada pembayaran. Silakan coba kembali.</p>
        @endif
      </div>

      <!-- Order Summary Card -->
      <div class="bg-white rounded-3xl border border-slate-100 shadow-lg p-8 md:p-10 mb-8 fade-in">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-lg font-black text-slate-800">Detail Pesanan</h2>
          <span class="text-sm font-bold text-slate-400">{{ $order->order_number }}</span>
        </div>

        <div class="space-y-3 mb-6">
          <div class="flex justify-between text-sm">
            <span class="text-slate-500">Nama</span>
            <span class="font-bold text-slate-800">{{ $order->nama_lengkap }}</span>
          </div>
        </div>

        <!-- Items List -->
        <div class="border-t border-slate-100 pt-6 mb-6">
          <h3 class="text-sm font-bold text-slate-700 mb-4">Item</h3>
          <div class="space-y-3">
            @foreach($order->items as $item)
              <div class="flex justify-between items-center text-sm">
                <span class="text-slate-600">{{ $item->event_label }}</span>
                <span class="font-bold text-slate-800">Rp {{ number_format($item->display_price, 0, ',', '.') }}</span>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Price Summary -->
        <div class="border-t border-slate-100 pt-6 space-y-2 text-sm">
          <div class="flex justify-between font-black text-lg text-amber-700">
            <span>Total</span>
            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
          </div>
          <p class="text-xs text-slate-400 mt-2">Harga sudah termasuk PPN 11%, biaya layanan & transaksi digital</p>
        </div>
      </div>

      <!-- Status-specific Actions -->
      @if($order->status === 'pending')
        <div class="bg-yellow-50 border border-yellow-200 rounded-3xl p-8 mb-8 fade-in">
          <div class="flex items-start gap-4">
            <i data-lucide="alert-triangle" class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5"></i>
            <div>
              <h3 class="font-bold text-yellow-800 mb-2">Selesaikan Pembayaran</h3>
              <p class="text-sm text-yellow-700 mb-4">
                Pembayaran akan kedaluwarsa pada
                <strong id="countdown-target">{{ $order->expired_at->format('d M Y, H:i') }} WIB</strong>
              </p>
              <div id="countdown" class="text-2xl font-black text-yellow-800 mb-6 font-mono"></div>
              <a href="{{ $order->xendit_invoice_url }}" target="_blank" rel="noreferrer"
                 class="inline-flex items-center gap-2 bg-yellow-500 text-white px-8 py-3.5 rounded-xl font-bold text-sm hover:bg-yellow-600 transition-all shadow-md">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                Bayar Sekarang
              </a>
            </div>
          </div>
        </div>

        <script>
          (function() {
            var expiredAt = new Date('{{ $order->expired_at->toIso8601String() }}').getTime();
            var countdownEl = document.getElementById('countdown');

            function updateCountdown() {
              var now = new Date().getTime();
              var diff = expiredAt - now;

              if (diff <= 0) {
                countdownEl.textContent = 'Waktu habis';
                return;
              }

              var hours = Math.floor(diff / (1000 * 60 * 60));
              var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((diff % (1000 * 60)) / 1000);

              countdownEl.textContent =
                String(hours).padStart(2, '0') + ':' +
                String(minutes).padStart(2, '0') + ':' +
                String(seconds).padStart(2, '0');
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
          })();
        </script>
      @endif

      @if($order->status === 'paid')
        <div class="bg-green-50 border border-green-200 rounded-3xl p-8 mb-8 fade-in">
          <div class="flex items-start gap-4">
            <i data-lucide="ticket" class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5"></i>
            <div class="w-full">
              <h3 class="font-bold text-green-800 mb-4">Tiket Anda</h3>
              <div class="space-y-3">
                @foreach($order->tickets as $ticket)
                  <a href="/tiket/{{ $ticket->ticket_code }}"
                     class="flex items-center justify-between bg-white p-4 rounded-xl border border-green-100 hover:border-green-300 transition-all group">
                    <div>
                      <span class="font-bold text-slate-800 text-sm">{{ $ticket->event_label }}</span>
                      <span class="block text-xs text-slate-400 mt-0.5">{{ $ticket->ticket_code }}</span>
                    </div>
                    <i data-lucide="arrow-right" class="w-4 h-4 text-green-500 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                  </a>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      @endif

      @if($order->status === 'expired' || $order->status === 'failed')
        <div class="text-center fade-in">
          <a href="/registrasi"
             class="inline-flex items-center gap-2 bg-amber-500 text-white px-8 py-3.5 rounded-xl font-bold text-sm hover:bg-amber-600 transition-all shadow-md">
            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
            Daftar Ulang
          </a>
        </div>
      @endif
    </div>
  </section>

  @include('components.footer')
@endsection
