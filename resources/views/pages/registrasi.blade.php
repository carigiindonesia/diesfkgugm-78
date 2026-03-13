@extends('layouts.app')

@section('title', 'Registrasi Dies Natalis FKG UGM ke-78 | Simposium, Workshop & Fun Run')
@section('meta_description', 'Daftar sekarang untuk Dies Natalis FKG UGM ke-78. Pilih kegiatan: Simposium Kedokteran Gigi, Hands-on Workshop, Fun Run 5K, atau Pengabdian Masyarakat. 17-20 April 2026, Yogyakarta.')

@section('content')
  @include('components.navbar')

  <!-- ==================== REGISTRATION PAGE ==================== -->
  <section class="pt-32 pb-20 min-h-screen bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Header -->
      <div class="text-center mb-12 fade-in">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 rounded-full text-xs font-bold mb-6 border border-amber-200 text-amber-700 tracking-widest uppercase">
          <i data-lucide="ticket" class="w-3.5 h-3.5"></i> Pendaftaran Online
        </div>
        <h1 class="text-3xl md:text-5xl font-black bg-gradient-to-r from-amber-600 via-yellow-500 to-amber-600 bg-clip-text text-transparent">
          Registrasi Dies Natalis FKG UGM ke-78
        </h1>
        <p class="text-slate-500 mt-4 max-w-2xl mx-auto">Pilih kategori dan kegiatan yang ingin Anda ikuti.</p>
      </div>

      <!-- Category Tabs -->
      <div class="flex justify-center mb-6 fade-in">
        <div class="inline-flex bg-white rounded-2xl p-1.5 shadow-sm border border-slate-100">
          @foreach($categories as $cat)
            <a href="/registrasi?kategori={{ $cat->value }}{{ $selectedEventCode ? '&event=' . $selectedEventCode : '' }}"
               class="px-6 py-3 rounded-xl text-sm font-bold transition-all {{ $category === $cat->value ? 'bg-amber-500 text-white shadow-md' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
              {{ $cat->label() }}
            </a>
          @endforeach
        </div>
      </div>

      <!-- Event Type Filter -->
      <div class="flex justify-center mb-10 fade-in">
        <div class="inline-flex flex-wrap justify-center gap-2">
          <a href="/registrasi?kategori={{ $category }}"
             class="px-4 py-2 rounded-xl text-xs font-bold transition-all border {{ !$selectedEventCode ? 'bg-slate-800 text-white border-slate-800 shadow-md' : 'bg-white text-slate-500 border-slate-200 hover:border-slate-300 hover:text-slate-700' }}">
            Semua Kegiatan
          </a>
          @foreach($eventTypes as $eventType)
            <a href="/registrasi?kategori={{ $category }}&event={{ $eventType->value }}"
               class="px-4 py-2 rounded-xl text-xs font-bold transition-all border {{ $selectedEventCode === $eventType->value ? 'bg-slate-800 text-white border-slate-800 shadow-md' : 'bg-white text-slate-500 border-slate-200 hover:border-slate-300 hover:text-slate-700' }}">
              {{ $eventType->label() }}
            </a>
          @endforeach
        </div>
      </div>

      <!-- Event Pricing Cards -->
      @php
        $filteredPrices = $selectedEventCode
            ? $prices->where('event_code', $selectedEventCode)
            : $prices;
      @endphp

      @if($filteredPrices->isEmpty())
        <div class="text-center py-12 mb-8 fade-in">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-100 rounded-2xl mb-4">
            <i data-lucide="search-x" class="w-8 h-8 text-slate-400"></i>
          </div>
          <p class="text-slate-500 text-sm">Tidak ada kegiatan yang tersedia untuk filter ini.</p>
          <a href="/registrasi?kategori={{ $category }}" class="inline-flex items-center gap-1 text-amber-600 font-bold text-sm mt-3 hover:text-amber-700">
            Lihat semua kegiatan <i data-lucide="arrow-right" class="w-4 h-4"></i>
          </a>
        </div>
      @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 fade-in">
          @foreach($filteredPrices as $price)
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-amber-200 transition-all p-8 flex flex-col"
                 id="card-{{ $price->id }}">
              <div class="flex-1">
                <h3 class="text-xl font-black text-slate-800 mb-2">{{ $price->event_label }}</h3>
                @if($price->event_description)
                  <div class="text-xs text-slate-500 mb-3 leading-relaxed whitespace-pre-line">{{ $price->event_description }}</div>
                @endif
                <p class="text-3xl font-black text-amber-600 mb-1">
                  Rp {{ number_format($price->display_price, 0, ',', '.') }}
                </p>
                <p class="text-xs text-slate-400 mb-6">Sudah termasuk PPN 11%, biaya layanan & transaksi digital</p>
              </div>
              <button onclick="{{ $registrationOpen ? "selectEvent({$price->id}, '{$price->event_code}')" : 'showClosedPopup()' }}"
                      class="w-full py-3.5 rounded-xl font-bold text-sm transition-all bg-amber-50 text-amber-700 hover:bg-amber-100">
                Pilih
              </button>
            </div>
          @endforeach
        </div>
      @endif

      <!-- Bundling Link -->
      <div class="text-center mb-12 fade-in">
        <a href="/registrasi/bundling?kategori={{ $category }}"
           class="inline-flex items-center gap-2 text-amber-600 font-bold text-sm hover:text-amber-700 transition-colors">
          Lihat Paket Bundling
          <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
      </div>

      <!-- Registration Form -->
      <div id="registration-form" class="hidden max-w-2xl mx-auto fade-in">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-lg p-8 md:p-10">
          <h2 class="text-2xl font-black text-slate-800 mb-8">Formulir Pendaftaran</h2>

          @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-6 text-sm">
              <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="/registrasi" method="POST" id="reg-form">
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

            <!-- Participant 1 (Buyer / Pemesan) -->
            <div id="participant-0" class="participant-section">
              <div class="flex items-center gap-3 mb-5">
                <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-sm font-bold">1</div>
                <h3 class="text-lg font-bold text-slate-800">Peserta 1 <span class="text-xs text-slate-400 font-normal">(Pemesan)</span></h3>
              </div>

              <div class="space-y-5">
                <!-- Common Fields -->
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

                <!-- NIK Field (simposium, handson, pengmas) -->
                <div id="fields-nik-0" class="hidden">
                  <label class="block text-sm font-bold text-slate-700 mb-2">NIK (Nomor Induk Kependudukan)</label>
                  <input type="text" name="nik" value="{{ old('nik') }}" inputmode="numeric" pattern="[0-9]{16}" maxlength="16" placeholder="16 digit angka"
                         class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                  @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- SatuSehat Fields (simposium, handson, pengmas) -->
                <div id="fields-satusehat-0" class="hidden space-y-5">
                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama di SatuSehat SDMK</label>
                    <input type="text" name="nama_satusehat" value="{{ old('nama_satusehat') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                    @error('nama_satusehat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                  </div>

                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email SatuSehat SDMK</label>
                    <input type="email" name="email_satusehat" value="{{ old('email_satusehat') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                    @error('email_satusehat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                  </div>

                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">WhatsApp SatuSehat SDMK</label>
                    <input type="text" name="whatsapp_satusehat" value="{{ old('whatsapp_satusehat') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                    @error('whatsapp_satusehat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                  </div>
                </div>

                <!-- Fun Run Fields -->
                <div id="fields-funrun-0" class="hidden space-y-5">
                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                  </div>

                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                    @error('whatsapp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                  </div>

                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tipe Jersey</label>
                    <div class="flex gap-6">
                      <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jersey_type" value="dewasa" {{ old('jersey_type') === 'dewasa' ? 'checked' : '' }}
                               class="w-4 h-4 text-amber-600 border-slate-300 focus:ring-amber-400">
                        <span class="text-sm text-slate-700">Dewasa</span>
                      </label>
                      <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jersey_type" value="anak" {{ old('jersey_type') === 'anak' ? 'checked' : '' }}
                               class="w-4 h-4 text-amber-600 border-slate-300 focus:ring-amber-400">
                        <span class="text-sm text-slate-700">Anak</span>
                      </label>
                    </div>
                    @error('jersey_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                  </div>

                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ukuran Jersey</label>
                    <select name="jersey_size"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                      <option value="">Pilih ukuran</option>
                      @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', '3XL', '4XL', '5XL'] as $size)
                        <option value="{{ $size }}" {{ old('jersey_size') === $size ? 'selected' : '' }}>{{ $size }}</option>
                      @endforeach
                    </select>
                    @error('jersey_size') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                  </div>

                  <!-- Kontak Gawat Darurat -->
                  <div class="bg-red-50 border border-red-100 rounded-2xl p-5 space-y-4">
                    <p class="text-sm font-bold text-red-700 flex items-center gap-2">
                      <i data-lucide="heart-pulse" class="w-4 h-4"></i> Kontak Gawat Darurat (Emergency Contact)
                    </p>
                    <div>
                      <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kontak Darurat</label>
                      <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}"
                             class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm"
                             placeholder="Nama lengkap kontak darurat">
                      @error('emergency_contact_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                      <label class="block text-sm font-bold text-slate-700 mb-2">WhatsApp Kontak Darurat</label>
                      <input type="text" name="emergency_contact_whatsapp" value="{{ old('emergency_contact_whatsapp') }}"
                             class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm"
                             placeholder="08xxxxxxxxxx">
                      @error('emergency_contact_whatsapp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                  </div>
                </div>

                <!-- Lembaga -->
                <div>
                  <label class="block text-sm font-bold text-slate-700 mb-2">Lembaga / Institusi</label>
                  <input type="text" name="lembaga" value="{{ old('lembaga') }}" required
                         class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                  @error('lembaga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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

            <!-- Fun Run Waiver Section -->
            <div id="funrun-waiver-section" class="hidden mt-8 space-y-6">
              <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6">
                <h3 class="text-lg font-black text-slate-800 mb-4 flex items-center gap-2">
                  <i data-lucide="shield-alert" class="w-5 h-5 text-amber-600"></i>
                  Pernyataan dan Persetujuan
                </h3>
                <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                  <strong>Harap baca pernyataan dan persetujuan berikut dengan seksama.</strong> Dokumen ini mencakup pelepasan tanggung jawab dan pembebasan hak hukum. Dengan menyetujui secara elektronik, Anda mengakui telah membaca dan memahami seluruh ketentuan yang disajikan sebagai bagian dari proses pendaftaran.
                </p>

                <!-- Important Notice Checkbox -->
                <div class="mb-4">
                  <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="checkbox" name="agree_important_notice" value="1" {{ old('agree_important_notice') ? 'checked' : '' }}
                           class="w-5 h-5 mt-0.5 text-amber-600 border-slate-300 rounded focus:ring-amber-400 flex-shrink-0">
                    <span class="text-sm text-slate-700">
                      Saya Setuju dengan
                      <button type="button" onclick="showWaiverModal('important-notice')" class="text-amber-600 font-bold hover:text-amber-700 underline">
                        Important Notice Fun Run Dies Natalis FKG UGM ke-78
                      </button>
                    </span>
                  </label>
                  @error('agree_important_notice') <p class="text-red-500 text-xs mt-1 ml-8">{{ $message }}</p> @enderror
                </div>

                <!-- Waiver Checkbox -->
                <div class="mb-6">
                  <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="checkbox" name="agree_waiver" value="1" {{ old('agree_waiver') ? 'checked' : '' }}
                           class="w-5 h-5 mt-0.5 text-amber-600 border-slate-300 rounded focus:ring-amber-400 flex-shrink-0">
                    <span class="text-sm text-slate-700">
                      Saya Setuju dengan
                      <button type="button" onclick="showWaiverModal('waiver')" class="text-amber-600 font-bold hover:text-amber-700 underline">
                        Waiver Fun Run Dies Natalis FKG UGM ke-78
                      </button>
                    </span>
                  </label>
                  @error('agree_waiver') <p class="text-red-500 text-xs mt-1 ml-8">{{ $message }}</p> @enderror
                </div>

                <!-- Note -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                  <p class="text-sm font-bold text-amber-800 mb-2">Harap diperhatikan:</p>
                  <p class="text-xs text-amber-700 leading-relaxed">Anda harus menyetujui seluruh pernyataan dan persetujuan yang diperlukan untuk dapat melanjutkan pendaftaran.</p>
                  <p class="text-xs text-amber-700 leading-relaxed mt-2">Dengan mengisi nama di bawah ini, saya menyatakan bahwa saya telah membaca dan menyetujui seluruh pernyataan dan persetujuan yang telah saya pilih di atas.</p>
                </div>

                <!-- Electronic Signature -->
                <div>
                  <label class="block text-sm font-bold text-slate-700 mb-2">Tanda Tangan Elektronik</label>
                  <input type="text" name="electronic_signature" value="{{ old('electronic_signature') }}"
                         placeholder="Isi dengan nama lengkap Anda"
                         class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">
                  @error('electronic_signature') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
              </div>
            </div>

            <!-- Submit -->
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

  <!-- Important Notice Modal -->
  <div id="important-notice-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-hidden flex flex-col">
      <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-8 py-6 rounded-t-3xl flex-shrink-0">
        <h2 class="text-xl font-black text-white">Important Notice</h2>
        <p class="text-amber-100 text-sm mt-1">Fun Run Dies Natalis FKG UGM ke-78</p>
      </div>
      <div class="px-8 py-6 overflow-y-auto text-sm text-slate-700 leading-relaxed space-y-4">
        <p>Semua pendaftar diwajibkan untuk membaca dan memahami peraturan dan ketentuan ("Syarat &amp; Ketentuan") ini sebelum mendaftar untuk Fun Run Dies Natalis FKG UGM ke-78. Harap dicatat bahwa para peserta merupakan pihak yang nama dan identitasnya tercatat dalam e-mail konfirmasi resmi yang mengkonfirmasi keikutsertaan pihak tersebut sebagai peserta Fun Run, baik melalui Pendaftaran Umum, Program Khusus atau program lainnya, termasuk yang menerima undangan dan free slot ("Peserta").</p>

        <h4 class="font-black text-slate-800 text-base">I. Umum</h4>
        <ol class="list-decimal list-inside space-y-2 ml-2">
          <li>Fun Run Dies Natalis FKG UGM ke-78 terbuka untuk umum dan merupakan bagian dari rangkaian acara Dies Natalis FKG UGM ke-78 yang dilaksanakan pada tanggal 20 April 2026.</li>
          <li>Peserta adalah yang mendapatkan slot melalui hasil pendaftaran dan telah melalui proses verifikasi pembayaran oleh panitia penyelenggara.</li>
          <li>Peserta wajib mengikuti dan melaksanakan setiap syarat dan ketentuan yang ditetapkan oleh penyelenggara, termasuk yang disampaikan dan/atau diumumkan secara terpisah dengan media apapun.</li>
          <li>Penyelenggara tidak akan bertanggung jawab atas biaya, pengeluaran, maupun kerugian dalam bentuk apapun, yang disebabkan oleh: penyakit bawaan; kecelakaan saat mengikuti acara; kehilangan dan/atau kerusakan properti pribadi masing-masing saat mengikuti acara.</li>
          <li>Fun Run terbuka untuk Warga Negara Indonesia dan Warga Negara Asing.</li>
          <li>Peserta Fun Run harus sudah berumur enam belas (16) tahun pada hari perlombaan. Peserta yang berumur di bawah tujuh belas (17) tahun harus menyerahkan surat izin orang tua.</li>
          <li>Peserta dihimbau untuk berkonsultasi dengan dokter apabila peserta ragu akan kondisi kesehatannya sebelum mengikuti perlombaan.</li>
          <li>Meskipun gaya hidup aktif selama kehamilan itu disarankan, panitia mengharuskan wanita hamil untuk melaporkan kondisi kehamilan dan menyerahkan surat dokter serta menandatangani surat pernyataan sebelum berpartisipasi. Panitia perlombaan tidak bertanggung jawab atas komplikasi atau masalah kesehatan yang dapat muncul akibat berlomba dalam masa kehamilan dan dapat menghentikan peserta dari perlombaan atas alasan kesehatan.</li>
          <li>Peserta tidak boleh menghalangi/mengganggu jalannya perlombaan dengan tidak mematuhi instruksi dari penyelenggara dan/atau petugas. Pelanggaran dapat menjadi dasar diskualifikasi.</li>
          <li>Peserta memberikan hak kepada penyelenggara untuk menggunakan nama, keserupaan, dan dokumentasi terkait acara untuk keperluan produksi, distribusi, dan publikasi.</li>
          <li>Hak cipta dan hak kekayaan intelektual lainnya dari gambar, foto, artikel, catatan waktu, dan informasi yang meliputi acara merupakan milik penyelenggara.</li>
        </ol>

        <h4 class="font-black text-slate-800 text-base">II. Penyelenggaraan dan Keikutsertaan</h4>
        <p>Peserta harus mengikuti protokol kesehatan yang ditetapkan penyelenggara selama rangkaian acara, termasuk namun tidak terbatas kepada ketentuan yang berlaku. Peserta yang tidak mematuhi atau melanggar protokol yang ditetapkan, berdasarkan diskresi penyelenggara, akan dihentikan keikutsertaannya.</p>

        <h4 class="font-black text-slate-800 text-base">III. Perlombaan</h4>
        <ol class="list-decimal list-inside space-y-2 ml-2">
          <li>Batas waktu (cut-off time) perlombaan adalah 1,5 jam untuk kategori 5K dan 1 jam untuk kategori 3K setelah start.</li>
          <li>Setiap peserta akan diberikan nomor bib yang merupakan identifikasi personal dan tidak boleh ditukar, dialihkan atau dipindahtangankan.</li>
          <li>Nomor bib harus dipasang di bagian depan tubuh peserta dan terlihat jelas selama perlombaan.</li>
          <li>Pos minuman tersedia di sepanjang jalur lari dan di garis finish.</li>
          <li>Peserta tidak boleh mengenakan pakaian atau perlengkapan yang dapat membahayakan diri sendiri maupun peserta lain.</li>
          <li>Peserta tidak boleh mengenakan pakaian untuk tujuan pernyataan atau propaganda politik, agama, iklan, serta kampanye lain tanpa persetujuan penyelenggara.</li>
        </ol>

        <h4 class="font-black text-slate-800 text-base">IV. Lain-Lain</h4>
        <ol class="list-decimal list-inside space-y-2 ml-2">
          <li>Syarat dan ketentuan dapat diubah dan ditambahkan sewaktu-waktu oleh penyelenggara. Peserta wajib secara rutin memeriksa ketentuan yang berlaku.</li>
          <li>Apabila terjadi force majeure termasuk namun tidak terbatas pada bencana alam, pandemi, perubahan kebijakan pemerintah, atau hal-hal lain di luar kekuasaan penyelenggara, peserta memahami bahwa tidak dapat mengajukan tuntutan kepada penyelenggara.</li>
          <li>Apabila perlombaan dibatalkan atas alasan force majeure, penyelenggara tidak berkewajiban mengembalikan uang pendaftaran.</li>
        </ol>
      </div>
      <div class="px-8 py-4 border-t border-slate-100 flex-shrink-0">
        <button type="button" onclick="hideWaiverModal('important-notice')"
                class="w-full py-3 rounded-xl font-bold text-sm bg-amber-500 text-white hover:bg-amber-600 transition-all">
          Tutup
        </button>
      </div>
    </div>
  </div>

  <!-- Waiver Modal -->
  <div id="waiver-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-hidden flex flex-col">
      <div class="bg-gradient-to-r from-red-500 to-red-600 px-8 py-6 rounded-t-3xl flex-shrink-0">
        <h2 class="text-xl font-black text-white">Pelepasan dan Pembebasan Tanggung Jawab</h2>
        <p class="text-red-100 text-sm mt-1">Waiver Fun Run Dies Natalis FKG UGM ke-78</p>
      </div>
      <div class="px-8 py-6 overflow-y-auto text-sm text-slate-700 leading-relaxed space-y-4">
        <h4 class="font-black text-slate-800 text-base">Definisi</h4>
        <ul class="list-disc list-inside space-y-1 ml-2">
          <li>"Penyelenggara" berarti Panitia Dies Natalis FKG UGM ke-78.</li>
          <li>"Race Organizer" berarti Panitia Pelaksana Fun Run Dies Natalis FKG UGM ke-78.</li>
          <li>"Event" berarti Fun Run Dies Natalis FKG UGM ke-78 yang diselenggarakan pada tanggal 20 April 2026.</li>
        </ul>

        <p>Peserta secara sukarela ingin berpartisipasi dalam acara Fun Run Dies Natalis FKG UGM ke-78. Saya mengakui bahwa kegiatan atletik ini dapat menguji batas fisik dan mental seseorang serta memiliki potensi kematian, luka-luka dan kerugian harta benda. Risiko meliputi, tetapi tidak terbatas pada, yang disebabkan oleh medan, fasilitas, suhu, cuaca, kondisi pelari, kurangnya hidrasi, peralatan, lalu lintas kendaraan, dan tindakan orang lain, termasuk tidak terbatas pada peserta, relawan, penonton, dan panitia acara.</p>

        <p>Dengan ini, saya menanggung semua risiko partisipasi dalam Event ini. Saya mengakui bahwa Pelepasan dan Pembebasan Tanggung Jawab akan digunakan oleh Penyelenggara dan Race Organizer dan bahwa hal itu akan mengatur tindakan dan tanggung jawab saya di acara ini.</p>

        <p>Saya menyatakan bahwa saya sehat secara fisik, telah cukup terlatih untuk berpartisipasi dalam acara tersebut dan belum disarankan atau dinyatakan untuk tidak melakukan aktivitas olahraga/lari oleh ahli medis.</p>

        <p>Saya dengan ini setuju untuk menerima perawatan medis yang mungkin dianggap perlu dalam hal cedera, kecelakaan, dan/atau penyakit selama acara ini.</p>

        <p>Pelepasan dan Pembebasan Tanggung Jawab ini akan ditafsirkan secara luas untuk memberikan pelepasan dan pengabaian semaksimal mungkin menurut hukum yang berlaku.</p>

        <p>Mengetahui fakta-fakta ini, saya, tertanda di bawah ini, dengan ini melepaskan perjanjian untuk tidak menuntut, dan membebaskan Penyelenggara dan Race Organizer dan para direktur, pejabat, karyawan, perwakilan dan agen dari setiap dan semua kewajiban, kerugian, kerusakan, klaim, tindakan atau tuntutan yang timbul dari atau terkait dengan keikutsertaan saya dalam dan perjalanan ke dan dari acara ini termasuk, namun tidak terbatas pada, kewajiban yang mungkin timbul dari kelalaian atau kecerobohan dari Penyelenggara dan Race Organizer.</p>

        <p>Saya telah membaca dengan saksama dan memahami perjanjian ini. Saya sadar bahwa ini adalah pelepasan dari tanggung jawab, dan saya berjanji untuk tidak menuntut, dan Pelepasan dan Pembebasan Tanggung Jawab ini akan mengikat, ahli waris, wakil pribadi, dan semua anggota keluarga saya, termasuk anak di bawah umur.</p>

        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mt-4">
          <p class="text-xs text-red-700 leading-relaxed"><strong>Disclaimer:</strong> Penulisan informasi Peserta adalah tanggung jawab Peserta sendiri, dalam hal terjadi kesalahan penulisan maka tidak bisa dilakukan revisi.</p>
        </div>
      </div>
      <div class="px-8 py-4 border-t border-slate-100 flex-shrink-0">
        <button type="button" onclick="hideWaiverModal('waiver')"
                class="w-full py-3 rounded-xl font-bold text-sm bg-red-500 text-white hover:bg-red-600 transition-all">
          Tutup
        </button>
      </div>
    </div>
  </div>

  @include('components.footer')

  <script>
    const pricesData = @json($prices->keyBy('id'));
    const satusehatTypes = ['simposium', 'handson', 'pengmas'];
    let currentQuantity = {{ old('quantity', 1) }};
    let currentEventType = null;
    let currentPriceId = null;

    function formatRupiah(amount) {
      return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    function changeQuantity(delta) {
      const newQty = currentQuantity + delta;
      if (newQty < 1 || newQty > 10) return;
      currentQuantity = newQty;
      document.getElementById('input-quantity').value = currentQuantity;
      document.getElementById('quantity-display').textContent = currentQuantity;
      renderAdditionalParticipants();
      updatePriceSummary();
    }

    function renderAdditionalParticipants() {
      const container = document.getElementById('additional-participants');
      container.innerHTML = '';

      for (let i = 1; i < currentQuantity; i++) {
        const isSatusehat = satusehatTypes.includes(currentEventType);
        const isFunrun = currentEventType === 'funrun';

        let html = '<div class="mt-8 pt-8 border-t border-slate-200 participant-section" id="participant-' + i + '">';
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

        // NIK field
        if (isSatusehat) {
          html += '<div>';
          html += '<label class="block text-sm font-bold text-slate-700 mb-2">NIK (Nomor Induk Kependudukan)</label>';
          html += '<input type="text" name="participants[' + (i - 1) + '][nik]" required inputmode="numeric" pattern="[0-9]{16}" maxlength="16" placeholder="16 digit angka" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
          html += '</div>';
        }

        // SatuSehat fields
        if (isSatusehat) {
          html += '<div>';
          html += '<label class="block text-sm font-bold text-slate-700 mb-2">Nama di SatuSehat SDMK</label>';
          html += '<input type="text" name="participants[' + (i - 1) + '][nama_satusehat]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
          html += '</div>';

          html += '<div>';
          html += '<label class="block text-sm font-bold text-slate-700 mb-2">Email SatuSehat SDMK</label>';
          html += '<input type="email" name="participants[' + (i - 1) + '][email_satusehat]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
          html += '</div>';

          html += '<div>';
          html += '<label class="block text-sm font-bold text-slate-700 mb-2">WhatsApp SatuSehat SDMK</label>';
          html += '<input type="text" name="participants[' + (i - 1) + '][whatsapp_satusehat]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
          html += '</div>';
        }

        // Fun Run fields
        if (isFunrun) {
          html += '<div>';
          html += '<label class="block text-sm font-bold text-slate-700 mb-2">Tipe Jersey</label>';
          html += '<div class="flex gap-6">';
          html += '<label class="flex items-center gap-2 cursor-pointer">';
          html += '<input type="radio" name="participants[' + (i - 1) + '][jersey_type]" value="dewasa" required class="w-4 h-4 text-amber-600 border-slate-300 focus:ring-amber-400">';
          html += '<span class="text-sm text-slate-700">Dewasa</span>';
          html += '</label>';
          html += '<label class="flex items-center gap-2 cursor-pointer">';
          html += '<input type="radio" name="participants[' + (i - 1) + '][jersey_type]" value="anak" class="w-4 h-4 text-amber-600 border-slate-300 focus:ring-amber-400">';
          html += '<span class="text-sm text-slate-700">Anak</span>';
          html += '</label>';
          html += '</div>';
          html += '</div>';

          html += '<div>';
          html += '<label class="block text-sm font-bold text-slate-700 mb-2">Ukuran Jersey</label>';
          html += '<select name="participants[' + (i - 1) + '][jersey_size]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
          html += '<option value="">Pilih ukuran</option>';
          html += '<option value="XS">XS</option><option value="S">S</option><option value="M">M</option><option value="L">L</option>';
          html += '<option value="XL">XL</option><option value="XXL">XXL</option><option value="XXXL">XXXL</option>';
          html += '<option value="3XL">3XL</option><option value="4XL">4XL</option><option value="5XL">5XL</option>';
          html += '</select>';
          html += '</div>';

          // Kontak Gawat Darurat
          html += '<div class="bg-red-50 border border-red-100 rounded-2xl p-5 space-y-4">';
          html += '<p class="text-sm font-bold text-red-700 flex items-center gap-2"><i data-lucide="heart-pulse" class="w-4 h-4"></i> Kontak Gawat Darurat (Emergency Contact)</p>';
          html += '<div>';
          html += '<label class="block text-sm font-bold text-slate-700 mb-2">Nama Kontak Darurat</label>';
          html += '<input type="text" name="participants[' + (i - 1) + '][emergency_contact_name]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm" placeholder="Nama lengkap kontak darurat">';
          html += '</div>';
          html += '<div>';
          html += '<label class="block text-sm font-bold text-slate-700 mb-2">WhatsApp Kontak Darurat</label>';
          html += '<input type="text" name="participants[' + (i - 1) + '][emergency_contact_whatsapp]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm" placeholder="08xxxxxxxxxx">';
          html += '</div>';
          html += '</div>';
        }

        // Lembaga
        html += '<div>';
        html += '<label class="block text-sm font-bold text-slate-700 mb-2">Lembaga / Institusi</label>';
        html += '<input type="text" name="participants[' + (i - 1) + '][lembaga]" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm">';
        html += '</div>';

        html += '</div></div>';

        container.insertAdjacentHTML('beforeend', html);
      }
    }

    function updatePriceSummary() {
      if (!currentPriceId) return;
      const price = pricesData[currentPriceId];
      if (!price) return;

      const total = price.display_price * currentQuantity;

      const qtyLabel = currentQuantity > 1 ? '(' + currentQuantity + ' tiket)' : '';
      document.getElementById('summary-qty-label').textContent = qtyLabel;
      document.getElementById('summary-total').textContent = formatRupiah(total);
      document.getElementById('price-summary').classList.remove('hidden');
    }

    function selectEvent(priceId, eventType) {
      currentPriceId = priceId;
      currentEventType = eventType;
      document.getElementById('input-event-price-id').value = priceId;
      document.getElementById('registration-form').classList.remove('hidden');

      // Toggle field visibility based on event type
      const isSatusehat = satusehatTypes.includes(eventType);
      document.getElementById('fields-nik-0').classList.toggle('hidden', !isSatusehat);
      document.getElementById('fields-satusehat-0').classList.toggle('hidden', !isSatusehat);
      document.getElementById('fields-funrun-0').classList.toggle('hidden', eventType !== 'funrun');
      document.getElementById('funrun-waiver-section').classList.toggle('hidden', eventType !== 'funrun');

      // Toggle required attributes for participant 1
      document.querySelectorAll('#fields-nik-0 input').forEach(function(input) {
        input.required = isSatusehat;
      });
      document.querySelectorAll('#fields-satusehat-0 input').forEach(function(input) {
        input.required = isSatusehat;
      });
      document.querySelectorAll('#fields-funrun-0 input, #fields-funrun-0 select').forEach(function(input) {
        input.required = eventType === 'funrun';
      });

      // Toggle waiver required attributes
      var waiverSection = document.getElementById('funrun-waiver-section');
      waiverSection.querySelectorAll('input[type="checkbox"]').forEach(function(input) {
        input.required = eventType === 'funrun';
      });
      var sigInput = waiverSection.querySelector('input[name="electronic_signature"]');
      if (sigInput) sigInput.required = eventType === 'funrun';

      // Update card selection styles
      document.querySelectorAll('[id^="card-"] button').forEach(function(btn) {
        btn.className = 'w-full py-3.5 rounded-xl font-bold text-sm transition-all bg-amber-50 text-amber-700 hover:bg-amber-100';
        btn.textContent = 'Pilih';
      });
      var selectedBtn = document.querySelector('#card-' + priceId + ' button');
      if (selectedBtn) {
        selectedBtn.className = 'w-full py-3.5 rounded-xl font-bold text-sm transition-all bg-amber-600 text-white shadow-lg';
        selectedBtn.textContent = 'Dipilih';
      }

      // Re-render additional participants for the new event type
      renderAdditionalParticipants();
      updatePriceSummary();

      // Smooth scroll to form
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

    function showWaiverModal(type) {
      var modal = document.getElementById(type + '-modal');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.style.overflow = 'hidden';
    }

    function hideWaiverModal(type) {
      var modal = document.getElementById(type + '-modal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      document.body.style.overflow = '';
    }

    // Close popup on backdrop click
    document.getElementById('reg-closed-popup').addEventListener('click', function(e) {
      if (e.target === this) hideClosedPopup();
    });

    // Close waiver modals on backdrop click
    document.getElementById('important-notice-modal').addEventListener('click', function(e) {
      if (e.target === this) hideWaiverModal('important-notice');
    });
    document.getElementById('waiver-modal').addEventListener('click', function(e) {
      if (e.target === this) hideWaiverModal('waiver');
    });

    // Auto-select if only one event card is visible after filtering
    @if($registrationOpen && $selectedEventCode && $filteredPrices->count() === 1)
      document.addEventListener('DOMContentLoaded', function() {
        var priceId = {{ $filteredPrices->first()->id }};
        var eventCode = '{{ $filteredPrices->first()->event_code }}';
        selectEvent(priceId, eventCode);
      });
    @endif
  </script>
@endsection
