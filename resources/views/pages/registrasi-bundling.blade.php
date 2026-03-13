@extends('layouts.app')

@section('title', 'Paket Bundling Dies Natalis FKG UGM ke-78 | Hemat Registrasi')
@section('meta_description', 'Daftar paket bundling hemat Dies Natalis FKG UGM ke-78. Gabungkan beberapa kegiatan sekaligus dengan harga spesial. 17-19 April 2026, Yogyakarta.')

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
              <p class="text-xs text-slate-400 mb-6">Sudah termasuk PPN 11%, biaya layanan & transaksi digital</p>
            </div>

            <button onclick="{{ $registrationOpen ? "selectBundle({$bundle->id})" : 'showClosedPopup()' }}"
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
            <input type="hidden" name="quantity" id="input-quantity" value="{{ old('quantity', 1) }}">

            <!-- Quantity Selector -->
            <div class="mb-8">
              <label class="block text-sm font-bold text-slate-700 mb-3">Jumlah Tiket</label>
              <div class="flex items-center gap-4">
                <button type="button" onclick="changeQuantity(-1)"
                        class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-lg flex items-center justify-center transition-all">
                  -
                </button>
                <span id="quantity-display" class="text-2xl font-black text-amber-600 w-8 text-center">1</span>
                <button type="button" onclick="changeQuantity(1)"
                        class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-lg flex items-center justify-center transition-all">
                  +
                </button>
                <span class="text-xs text-slate-400">Maks. 10 tiket per pembayaran</span>
              </div>
            </div>

            <!-- Participant 1 (Buyer) -->
            <div id="participant-0" class="participant-section">
              <div class="flex items-center gap-3 mb-5">
                <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-sm font-bold">1</div>
                <h3 class="text-lg font-bold text-slate-800">Peserta 1 <span class="text-xs text-slate-400 font-normal">(Pemesan)</span></h3>
              </div>

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
                  <label class="block text-sm font-bold text-slate-700 mb-2">NIK (Nomor Induk Kependudukan)</label>
                  <input type="text" name="nik" value="{{ old('nik') }}" required inputmode="numeric" pattern="[0-9]{16}" maxlength="16" placeholder="16 digit angka"
                         class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                  @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
                <div id="jersey-fields-0" class="hidden space-y-5">
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
            </div>

            <!-- Additional Participants Container -->
            <div id="additional-participants"></div>

            <!-- Price Summary -->
            <div id="price-summary" class="hidden mt-8 bg-amber-50 rounded-2xl p-6 border border-amber-100">
              <h3 class="font-bold text-slate-800 mb-4">Ringkasan Harga</h3>
              <div class="space-y-2 text-sm">
                <div class="flex justify-between font-black text-lg text-amber-700">
                  <span>Total <span id="summary-qty-label" class="text-sm font-normal text-slate-500"></span></span>
                  <span id="summary-total">Rp 0</span>
                </div>
                <p class="text-xs text-slate-400 mt-2">Harga sudah termasuk PPN 11%, biaya layanan & transaksi digital</p>
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

  <!-- Registration Closed Popup -->
  <div id="reg-closed-popup" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 p-8 text-center relative">
      <button onclick="hideClosedPopup()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
      <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-100 rounded-2xl mb-5">
        <i data-lucide="lock" class="w-8 h-8 text-amber-600"></i>
      </div>
      <h3 class="text-xl font-black text-slate-800 mb-3">Pendaftaran Belum Dibuka</h3>
      <p class="text-sm text-slate-500 mb-6 leading-relaxed">
        Mohon maaf, pendaftaran kegiatan Dies Natalis FKG UGM ke-78 belum dibuka saat ini. Silakan hubungi narahubung untuk informasi lebih lanjut.
      </p>
      <div class="bg-slate-50 rounded-2xl p-5 text-left space-y-3 mb-6">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Registrations Support and Helpdesk</p>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i data-lucide="building-2" class="w-5 h-5 text-amber-600"></i>
          </div>
          <div>
            <p class="text-sm font-bold text-slate-700">Carigi Indonesia</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i data-lucide="phone" class="w-5 h-5 text-green-600"></i>
          </div>
          <div>
            <p class="text-sm font-bold text-slate-700">085147686127</p>
          </div>
        </div>
      </div>
      <a href="https://wa.me/6285147686127" target="_blank" rel="noopener noreferrer"
         class="inline-flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-bold text-sm bg-green-500 text-white hover:bg-green-600 transition-all shadow-md">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        Hubungi via WhatsApp
      </a>
    </div>
  </div>

  @include('components.footer')

  <script>
    const bundlesData = @json($bundles->keyBy('id'));
    let currentQuantity = {{ old('quantity', 1) }};
    let currentBundleId = null;
    let currentBundleHasFunrun = false;

    function formatRupiah(amount) {
      return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    function changeQuantity(delta) {
      var newQty = currentQuantity + delta;
      if (newQty < 1 || newQty > 10) return;
      currentQuantity = newQty;
      document.getElementById('input-quantity').value = currentQuantity;
      document.getElementById('quantity-display').textContent = currentQuantity;
      renderAdditionalParticipants();
      updatePriceSummary();
    }

    function renderAdditionalParticipants() {
      var container = document.getElementById('additional-participants');
      container.innerHTML = '';

      for (var i = 1; i < currentQuantity; i++) {
        var html = '<div class="mt-8 pt-8 border-t border-slate-200 participant-section" id="participant-' + i + '">';
        html += '<div class="flex items-center gap-3 mb-5">';
        html += '<div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-sm font-bold">' + (i + 1) + '</div>';
        html += '<h3 class="text-lg font-bold text-slate-800">Peserta ' + (i + 1) + '</h3>';
        html += '</div>';
        html += '<div class="space-y-5">';

        // Nama Lengkap
        html += '<div>';
        html += '<label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>';
        html += '<input type="text" name="participants[' + (i - 1) + '][nama_lengkap]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
        html += '</div>';

        // Tanggal Lahir
        html += '<div>';
        html += '<label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir</label>';
        html += '<input type="date" name="participants[' + (i - 1) + '][tanggal_lahir]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
        html += '</div>';

        // NIK
        html += '<div>';
        html += '<label class="block text-sm font-bold text-slate-700 mb-2">NIK (Nomor Induk Kependudukan)</label>';
        html += '<input type="text" name="participants[' + (i - 1) + '][nik]" required inputmode="numeric" pattern="[0-9]{16}" maxlength="16" placeholder="16 digit angka" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
        html += '</div>';

        // Nama SatuSehat
        html += '<div>';
        html += '<label class="block text-sm font-bold text-slate-700 mb-2">Nama di SatuSehat SDMK</label>';
        html += '<input type="text" name="participants[' + (i - 1) + '][nama_satusehat]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
        html += '</div>';

        // Email SatuSehat
        html += '<div>';
        html += '<label class="block text-sm font-bold text-slate-700 mb-2">Email SatuSehat SDMK</label>';
        html += '<input type="email" name="participants[' + (i - 1) + '][email_satusehat]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
        html += '</div>';

        // WhatsApp SatuSehat
        html += '<div>';
        html += '<label class="block text-sm font-bold text-slate-700 mb-2">WhatsApp SatuSehat SDMK</label>';
        html += '<input type="text" name="participants[' + (i - 1) + '][whatsapp_satusehat]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
        html += '</div>';

        // Lembaga
        html += '<div>';
        html += '<label class="block text-sm font-bold text-slate-700 mb-2">Lembaga / Institusi</label>';
        html += '<input type="text" name="participants[' + (i - 1) + '][lembaga]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
        html += '</div>';

        // Jersey fields (only if bundle includes funrun)
        if (currentBundleHasFunrun) {
          html += '<div class="space-y-5">';
          html += '<div class="bg-blue-50 rounded-xl p-4 border border-blue-100">';
          html += '<p class="text-sm font-bold text-blue-800 mb-1">Ukuran Jersey Fun Run</p>';
          html += '<p class="text-xs text-blue-600">Silakan pilih ukuran jersey untuk peserta ini.</p>';
          html += '</div>';

          html += '<div>';
          html += '<label class="block text-sm font-bold text-slate-700 mb-2">Tipe Jersey</label>';
          html += '<div class="flex gap-4">';
          html += '<label class="flex items-center gap-2 cursor-pointer">';
          html += '<input type="radio" name="participants[' + (i - 1) + '][jersey_type]" value="dewasa" required class="w-4 h-4 text-amber-500 focus:ring-amber-400">';
          html += '<span class="text-sm text-slate-700">Dewasa</span>';
          html += '</label>';
          html += '<label class="flex items-center gap-2 cursor-pointer">';
          html += '<input type="radio" name="participants[' + (i - 1) + '][jersey_type]" value="anak" class="w-4 h-4 text-amber-500 focus:ring-amber-400">';
          html += '<span class="text-sm text-slate-700">Anak</span>';
          html += '</label>';
          html += '</div>';
          html += '</div>';

          html += '<div>';
          html += '<label class="block text-sm font-bold text-slate-700 mb-2">Ukuran Jersey</label>';
          html += '<select name="participants[' + (i - 1) + '][jersey_size]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
          html += '<option value="">-- Pilih Ukuran --</option>';
          html += '<option value="S">S</option><option value="M">M</option><option value="L">L</option>';
          html += '<option value="XL">XL</option><option value="XXL">XXL</option><option value="XXXL">XXXL</option>';
          html += '</select>';
          html += '</div>';
          html += '</div>';
        }

        html += '</div></div>';

        container.insertAdjacentHTML('beforeend', html);
      }
    }

    function updatePriceSummary() {
      if (!currentBundleId) return;
      var bundle = bundlesData[currentBundleId];
      if (!bundle) return;

      var total = bundle.display_price * currentQuantity;

      var qtyLabel = currentQuantity > 1 ? '(' + currentQuantity + ' paket)' : '';
      document.getElementById('summary-qty-label').textContent = qtyLabel;
      document.getElementById('summary-total').textContent = formatRupiah(total);
      document.getElementById('price-summary').classList.remove('hidden');
    }

    function selectBundle(bundleId) {
      currentBundleId = bundleId;
      document.getElementById('input-event-price-id').value = bundleId;
      document.getElementById('registration-form').classList.remove('hidden');

      // Update button styles
      document.querySelectorAll('[id^="bundle-btn-"]').forEach(function(btn) {
        btn.className = 'w-full py-3.5 rounded-xl font-bold text-sm transition-all bg-amber-50 text-amber-700 hover:bg-amber-100';
        btn.textContent = 'Pilih Paket';
      });
      var selectedBtn = document.getElementById('bundle-btn-' + bundleId);
      if (selectedBtn) {
        selectedBtn.className = 'w-full py-3.5 rounded-xl font-bold text-sm transition-all bg-amber-600 text-white shadow-lg';
        selectedBtn.textContent = 'Dipilih';
      }

      // Show/hide jersey fields based on whether bundle includes funrun
      var bundle = bundlesData[bundleId];
      currentBundleHasFunrun = bundle && bundle.bundle_events && bundle.bundle_events.includes('funrun');
      var jerseyFields = document.getElementById('jersey-fields-0');
      if (currentBundleHasFunrun) {
        jerseyFields.classList.remove('hidden');
      } else {
        jerseyFields.classList.add('hidden');
      }

      // Re-render additional participants
      renderAdditionalParticipants();
      updatePriceSummary();

      document.getElementById('registration-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function showClosedPopup() {
      var popup = document.getElementById('reg-closed-popup');
      popup.classList.remove('hidden');
      popup.classList.add('flex');
      document.body.style.overflow = 'hidden';
    }

    function hideClosedPopup() {
      var popup = document.getElementById('reg-closed-popup');
      popup.classList.add('hidden');
      popup.classList.remove('flex');
      document.body.style.overflow = '';
    }

    // Close popup on backdrop click
    document.getElementById('reg-closed-popup').addEventListener('click', function(e) {
      if (e.target === this) hideClosedPopup();
    });
  </script>
@endsection
