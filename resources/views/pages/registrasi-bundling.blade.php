@extends('layouts.app')

@section('content')
  @include('components.navbar')

  <!-- ==================== BUNDLING REGISTRATION PAGE ==================== -->
  <section class="pt-32 pb-20 min-h-screen bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Header -->
      <div class="text-center mb-12 fade-in">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 rounded-full text-xs font-bold mb-6 border border-amber-200 text-amber-700 tracking-widest uppercase">
          <i data-lucide="package" class="w-3.5 h-3.5"></i> Paket Bundling
        </div>
        <h1 class="text-3xl md:text-5xl font-black bg-gradient-to-r from-amber-600 via-yellow-500 to-amber-600 bg-clip-text text-transparent">
          Paket Bundling Hemat
        </h1>
        <p class="text-slate-500 mt-4 max-w-2xl mx-auto">Daftar beberapa kegiatan sekaligus dan dapatkan harga spesial.</p>
      </div>

      <!-- Back Link -->
      <div class="mb-8 fade-in">
        <a href="/registrasi?kategori={{ $category }}"
           class="inline-flex items-center gap-2 text-slate-500 font-bold text-sm hover:text-slate-700 transition-colors">
          <i data-lucide="arrow-left" class="w-4 h-4"></i>
          Kembali ke Registrasi Individual
        </a>
      </div>

      <!-- Category Tabs -->
      <div class="flex justify-center mb-10 fade-in">
        <div class="inline-flex bg-white rounded-2xl p-1.5 shadow-sm border border-slate-100">
          @foreach($categories as $cat)
            <a href="/registrasi/bundling?kategori={{ $cat->value }}"
               class="px-6 py-3 rounded-xl text-sm font-bold transition-all {{ $category === $cat->value ? 'bg-amber-500 text-white shadow-md' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
              {{ $cat->label() }}
            </a>
          @endforeach
        </div>
      </div>

      <!-- Bundle Cards -->
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 fade-in">
        @foreach($bundles as $bundle)
          @php
            $individualTotal = 0;
            foreach ($bundle->bundle_events ?? [] as $eventCode) {
              $indiv = $individualPrices->firstWhere('event_code', $eventCode);
              $individualTotal += $indiv ? $indiv->display_price : 0;
            }
            $savings = $individualTotal - $bundle->display_price;
          @endphp
          <div class="bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-amber-200 transition-all p-8 flex flex-col relative overflow-hidden"
               id="bundle-card-{{ $bundle->id }}">
            @if($savings > 0)
              <div class="absolute top-4 right-4 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                Hemat Rp {{ number_format($savings, 0, ',', '.') }}
              </div>
            @endif

            <div class="flex-1">
              <h3 class="text-xl font-black text-slate-800 mb-3">{{ $bundle->bundle_label }}</h3>

              <!-- Included Events -->
              <ul class="space-y-2 mb-6">
                @foreach($bundle->bundle_events ?? [] as $eventCode)
                  <li class="flex items-center gap-2 text-sm text-slate-600">
                    <i data-lucide="check-circle" class="w-4 h-4 text-amber-500 flex-shrink-0"></i>
                    <span>{{ \App\Enums\EventType::from($eventCode)->label() }}</span>
                  </li>
                @endforeach
              </ul>

              @if($savings > 0)
                <p class="text-xs text-slate-400 line-through mb-1">
                  Rp {{ number_format($individualTotal, 0, ',', '.') }}
                </p>
              @endif
              <p class="text-3xl font-black text-amber-600 mb-1">
                Rp {{ number_format($bundle->display_price, 0, ',', '.') }}
              </p>
              <p class="text-xs text-slate-400 mb-6">Sudah termasuk biaya layanan & transaksi</p>
            </div>

            <button onclick="selectBundle({{ $bundle->id }})"
                    class="w-full py-3.5 rounded-xl font-bold text-sm transition-all bg-amber-50 text-amber-700 hover:bg-amber-100"
                    id="bundle-btn-{{ $bundle->id }}">
              Pilih Paket
            </button>
          </div>
        @endforeach
      </div>

      <!-- Registration Form -->
      <div id="registration-form" class="hidden max-w-2xl mx-auto fade-in">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-lg p-8 md:p-10">
          <h2 class="text-2xl font-black text-slate-800 mb-8">Formulir Pendaftaran Bundling</h2>

          @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-6 text-sm">
              <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="/registrasi" method="POST">
            @csrf
            <input type="hidden" name="event_price_id" id="input-event-price-id" value="{{ old('event_price_id') }}">
            <input type="hidden" name="category" value="{{ $category }}">

            <div class="space-y-5">
              <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama di SatuSehat SDMK</label>
                <input type="text" name="nama_satusehat" value="{{ old('nama_satusehat') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                @error('nama_satusehat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Email SatuSehat SDMK</label>
                <input type="email" name="email_satusehat" value="{{ old('email_satusehat') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                @error('email_satusehat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">WhatsApp SatuSehat SDMK</label>
                <input type="text" name="whatsapp_satusehat" value="{{ old('whatsapp_satusehat') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                @error('whatsapp_satusehat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Lembaga / Institusi</label>
                <input type="text" name="lembaga" value="{{ old('lembaga') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                @error('lembaga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>

              <!-- Jersey fields (shown only when bundle includes Fun Run) -->
              <div id="jersey-fields" class="hidden space-y-5">
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                  <p class="text-sm font-bold text-blue-800 mb-1"><i data-lucide="shirt" class="w-4 h-4 inline"></i> Ukuran Jersey Fun Run</p>
                  <p class="text-xs text-blue-600">Paket ini termasuk Fun Run, silakan pilih ukuran jersey.</p>
                </div>
                <div>
                  <label class="block text-sm font-bold text-slate-700 mb-2">Tipe Jersey</label>
                  <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                      <input type="radio" name="jersey_type" value="dewasa" {{ old('jersey_type') === 'dewasa' ? 'checked' : '' }}
                             class="w-4 h-4 text-amber-500 focus:ring-amber-400">
                      <span class="text-sm text-slate-700">Dewasa</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                      <input type="radio" name="jersey_type" value="anak" {{ old('jersey_type') === 'anak' ? 'checked' : '' }}
                             class="w-4 h-4 text-amber-500 focus:ring-amber-400">
                      <span class="text-sm text-slate-700">Anak</span>
                    </label>
                  </div>
                  @error('jersey_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                  <label class="block text-sm font-bold text-slate-700 mb-2">Ukuran Jersey</label>
                  <select name="jersey_size"
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                    <option value="">-- Pilih Ukuran --</option>
                    @foreach(['S', 'M', 'L', 'XL', 'XXL', 'XXXL'] as $size)
                      <option value="{{ $size }}" {{ old('jersey_size') === $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                  </select>
                  @error('jersey_size') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
              </div>
            </div>

            <!-- Price Summary -->
            <div id="price-summary" class="hidden mt-8 bg-amber-50 rounded-2xl p-6 border border-amber-100">
              <h3 class="font-bold text-slate-800 mb-4">Ringkasan Harga</h3>
              <div class="space-y-2 text-sm">
                <div class="flex justify-between text-slate-600">
                  <span>Harga Paket</span>
                  <span id="summary-base">Rp 0</span>
                </div>
                <div class="flex justify-between text-slate-600">
                  <span>Biaya Layanan (5%)</span>
                  <span id="summary-service">Rp 0</span>
                </div>
                <div class="flex justify-between text-slate-600">
                  <span>Biaya Transaksi (5%)</span>
                  <span id="summary-transaction">Rp 0</span>
                </div>
                <hr class="my-3 border-amber-200">
                <div class="flex justify-between font-black text-lg text-amber-700">
                  <span>Total</span>
                  <span id="summary-total">Rp 0</span>
                </div>
              </div>
            </div>

            <button type="submit"
                    class="w-full mt-8 bg-gradient-to-r from-amber-500 to-amber-600 text-white py-4 rounded-xl font-black text-base hover:from-amber-600 hover:to-amber-700 transition-all shadow-lg hover:shadow-xl">
              Lanjut ke Pembayaran
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

  @include('components.footer')

  <script>
    const bundlesData = @json($bundles->keyBy('id'));

    function formatRupiah(amount) {
      return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    function selectBundle(bundleId) {
      document.getElementById('input-event-price-id').value = bundleId;
      document.getElementById('registration-form').classList.remove('hidden');

      // Update button styles
      document.querySelectorAll('[id^="bundle-btn-"]').forEach(function(btn) {
        btn.className = 'w-full py-3.5 rounded-xl font-bold text-sm transition-all bg-amber-50 text-amber-700 hover:bg-amber-100';
        btn.textContent = 'Pilih Paket';
      });
      const selectedBtn = document.getElementById('bundle-btn-' + bundleId);
      if (selectedBtn) {
        selectedBtn.className = 'w-full py-3.5 rounded-xl font-bold text-sm transition-all bg-amber-600 text-white shadow-lg';
        selectedBtn.textContent = 'Dipilih';
      }

      // Update price summary (base_price + 10% = display_price)
      const bundle = bundlesData[bundleId];
      if (bundle) {
        const base = bundle.base_price;
        const service = Math.round(base * 0.05);
        const transaction = Math.round(base * 0.05);
        const total = bundle.display_price;

        document.getElementById('summary-base').textContent = formatRupiah(base);
        document.getElementById('summary-service').textContent = formatRupiah(service);
        document.getElementById('summary-transaction').textContent = formatRupiah(transaction);
        document.getElementById('summary-total').textContent = formatRupiah(total);
        document.getElementById('price-summary').classList.remove('hidden');
      }

      // Show/hide jersey fields based on whether bundle includes funrun
      const jerseyFields = document.getElementById('jersey-fields');
      if (bundle && bundle.bundle_events && bundle.bundle_events.includes('funrun')) {
        jerseyFields.classList.remove('hidden');
      } else {
        jerseyFields.classList.add('hidden');
      }

      document.getElementById('registration-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  </script>
@endsection
