@extends('layouts.app')

@section('content')
  @include('components.navbar')

  <!-- ==================== 3MPC SUBMISSION FORM ==================== -->
  <section class="pt-32 pb-20 min-h-screen bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Header -->
      <div class="text-center mb-12 fade-in">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-orange-50 rounded-full text-xs font-bold mb-6 border border-orange-200 text-orange-700 tracking-widest uppercase">
          <i data-lucide="trophy" class="w-3.5 h-3.5"></i> Kompetisi
        </div>
        <h1 class="text-3xl md:text-5xl font-black bg-gradient-to-r from-amber-600 via-yellow-500 to-amber-600 bg-clip-text text-transparent">
          Submit 3-Minute Pitch Competition
        </h1>
        <p class="text-slate-500 mt-4 max-w-xl mx-auto">Kirimkan abstrak dan video presentasi riset Anda dalam 3 menit.</p>
      </div>

      <!-- Form Card -->
      <div class="bg-white rounded-3xl border border-slate-100 shadow-lg p-8 md:p-10 fade-in">

        @if(session('success'))
          <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-6 text-sm flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
            {{ session('success') }}
          </div>
        @endif

        @if($errors->any())
          <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-6 text-sm">
            <ul class="list-disc list-inside space-y-1">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form id="submissionForm" action="/3mpc/submit" method="POST">
          @csrf

          <div class="space-y-6">
            <!-- Nama Author -->
            <div>
              <label class="block text-sm font-bold text-slate-700 mb-2">Nama Author</label>
              <textarea name="authors" rows="3" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm resize-none"
                        placeholder="Dr. John Doe, S.KG., M.Kes.">{{ old('authors') }}</textarea>
              <p class="text-xs text-slate-400 mt-1.5">Lengkap dengan gelar. Jika lebih dari satu, pisahkan dengan tanda ;</p>
              @error('authors') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Lembaga -->
            <div>
              <label class="block text-sm font-bold text-slate-700 mb-2">Lembaga atau Institusi</label>
              <input type="text" name="lembaga" value="{{ old('lembaga') }}" required
                     class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm"
                     placeholder="Universitas Gadjah Mada">
              @error('lembaga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Kategori -->
            <div>
              <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all
                  {{ old('kategori') === 'original_article' ? 'border-amber-400 bg-amber-50' : 'border-slate-200 hover:border-amber-300' }}">
                  <input type="radio" name="kategori" value="original_article" {{ old('kategori') === 'original_article' ? 'checked' : '' }} required
                         class="w-4 h-4 text-amber-500 border-slate-300 focus:ring-amber-400"
                         onchange="this.closest('.grid').querySelectorAll('label').forEach(l => l.classList.remove('border-amber-400','bg-amber-50')); this.closest('label').classList.add('border-amber-400','bg-amber-50');">
                  <span class="text-sm font-bold text-slate-700">Original Article</span>
                </label>
                <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all
                  {{ old('kategori') === 'case_report' ? 'border-amber-400 bg-amber-50' : 'border-slate-200 hover:border-amber-300' }}">
                  <input type="radio" name="kategori" value="case_report" {{ old('kategori') === 'case_report' ? 'checked' : '' }}
                         class="w-4 h-4 text-amber-500 border-slate-300 focus:ring-amber-400"
                         onchange="this.closest('.grid').querySelectorAll('label').forEach(l => l.classList.remove('border-amber-400','bg-amber-50')); this.closest('label').classList.add('border-amber-400','bg-amber-50');">
                  <span class="text-sm font-bold text-slate-700">Case Report</span>
                </label>
                <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all
                  {{ old('kategori') === 'review' ? 'border-amber-400 bg-amber-50' : 'border-slate-200 hover:border-amber-300' }}">
                  <input type="radio" name="kategori" value="review" {{ old('kategori') === 'review' ? 'checked' : '' }}
                         class="w-4 h-4 text-amber-500 border-slate-300 focus:ring-amber-400"
                         onchange="this.closest('.grid').querySelectorAll('label').forEach(l => l.classList.remove('border-amber-400','bg-amber-50')); this.closest('label').classList.add('border-amber-400','bg-amber-50');">
                  <span class="text-sm font-bold text-slate-700">Review</span>
                </label>
              </div>
              @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Judul -->
            <div>
              <label class="block text-sm font-bold text-slate-700 mb-2">Judul</label>
              <input type="text" name="judul" value="{{ old('judul') }}" required
                     class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm"
                     placeholder="Judul penelitian Anda">
              @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Upload Link Abstrak -->
            <div>
              <label class="block text-sm font-bold text-slate-700 mb-2">Upload Link Abstrak</label>
              <input type="url" name="abstract_link" value="{{ old('abstract_link') }}" required
                     class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm"
                     placeholder="https://drive.google.com/...">
              <div class="flex items-start gap-2 mt-2 bg-yellow-50 border border-yellow-100 rounded-lg px-3 py-2">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-yellow-600 flex-shrink-0 mt-0.5"></i>
                <p class="text-xs text-yellow-700">Pastikan link Google Drive sudah di-set Public!</p>
              </div>
              @error('abstract_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Upload Link Video -->
            <div>
              <label class="block text-sm font-bold text-slate-700 mb-2">
                Upload Link Video
                <span class="text-slate-400 font-normal">(opsional)</span>
              </label>
              <input type="url" name="video_link" value="{{ old('video_link') }}"
                     class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm"
                     placeholder="https://drive.google.com/...">
              <div class="flex items-start gap-2 mt-2 bg-yellow-50 border border-yellow-100 rounded-lg px-3 py-2">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-yellow-600 flex-shrink-0 mt-0.5"></i>
                <p class="text-xs text-yellow-700">Pastikan link Google Drive sudah di-set Public!</p>
              </div>
              @error('video_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Hidden consent field -->
            <input type="hidden" name="consent" id="consentField" value="{{ old('consent', '') }}">
            @error('consent') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <!-- Submit -->
          <button type="button" id="showConsentBtn"
                  class="w-full mt-8 bg-gradient-to-r from-amber-500 to-amber-600 text-white py-4 rounded-xl font-black text-base hover:from-amber-600 hover:to-amber-700 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
            <i data-lucide="send" class="w-5 h-5"></i>
            Kirim Submission
          </button>
        </form>
      </div>
    </div>
  </section>

  <!-- Informed Consent Modal -->
  <div id="consentModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="consentOverlay"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
      <!-- Modal Header -->
      <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-8 py-6 rounded-t-3xl">
        <h2 class="text-xl font-black text-white">Pernyataan Keaslian Naskah</h2>
        <p class="text-amber-100 text-sm mt-1">Informed Consent Submission</p>
      </div>

      <!-- Modal Body -->
      <div class="px-8 py-6 space-y-4">
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
          <p class="text-sm text-slate-700 leading-relaxed">
            Dengan mengirimkan naskah ini, saya menyatakan bahwa:
          </p>
        </div>

        <ol class="space-y-3 text-sm text-slate-700 leading-relaxed list-decimal list-inside">
          <li>Naskah yang diajukan merupakan <strong>karya asli</strong> penulis dan <strong>belum pernah dipublikasikan</strong> sebelumnya di jurnal, prosiding, atau media ilmiah lainnya.</li>
          <li>Naskah <strong>tidak sedang dalam proses review</strong> atau diajukan ke publikasi lain secara bersamaan.</li>
          <li>Semua data, referensi, dan sumber yang digunakan telah <strong>dicantumkan dengan benar dan jujur</strong> sesuai kaidah penulisan ilmiah.</li>
          <li>Naskah <strong>tidak mengandung unsur plagiarisme</strong> dalam bentuk apapun.</li>
          <li>Penulis bersedia <strong>bertanggung jawab sepenuhnya</strong> atas keaslian dan isi naskah yang diajukan.</li>
          <li>Penulis menyetujui bahwa panitia berhak <strong>mendiskualifikasi</strong> naskah apabila ditemukan pelanggaran terhadap pernyataan di atas.</li>
        </ol>

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
          <p class="text-xs text-blue-700 leading-relaxed">
            Dengan mengklik "Setuju & Kirim", Anda menyatakan telah membaca, memahami, dan menyetujui seluruh ketentuan di atas.
          </p>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="px-8 py-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
        <button type="button" id="cancelConsentBtn"
                class="flex-1 py-3 px-6 rounded-xl font-bold text-sm text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all">
          Batal
        </button>
        <button type="button" id="agreeConsentBtn"
                class="flex-1 py-3 px-6 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 transition-all shadow-md">
          Setuju & Kirim
        </button>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const showConsentBtn = document.getElementById('showConsentBtn');
      const consentModal = document.getElementById('consentModal');
      const consentOverlay = document.getElementById('consentOverlay');
      const cancelConsentBtn = document.getElementById('cancelConsentBtn');
      const agreeConsentBtn = document.getElementById('agreeConsentBtn');
      const consentField = document.getElementById('consentField');
      const form = document.getElementById('submissionForm');

      showConsentBtn.addEventListener('click', function() {
        if (!form.checkValidity()) {
          form.reportValidity();
          return;
        }
        consentModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      });

      function closeModal() {
        consentModal.classList.add('hidden');
        document.body.style.overflow = '';
      }

      cancelConsentBtn.addEventListener('click', closeModal);
      consentOverlay.addEventListener('click', closeModal);

      agreeConsentBtn.addEventListener('click', function() {
        consentField.value = '1';
        form.submit();
      });
    });
  </script>

  @include('components.footer')
@endsection
