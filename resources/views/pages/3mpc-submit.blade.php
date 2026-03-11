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

        <form action="/3mpc/submit" method="POST">
          @csrf

          <div class="space-y-6">
            <!-- Nama Author -->
            <div>
              <label class="block text-sm font-bold text-slate-700 mb-2">Nama Author</label>
              <textarea name="nama_author" rows="3" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm resize-none"
                        placeholder="Dr. John Doe, S.KG., M.Kes.">{{ old('nama_author') }}</textarea>
              <p class="text-xs text-slate-400 mt-1.5">Lengkap dengan gelar. Jika lebih dari satu, pisahkan dengan tanda ;</p>
              @error('nama_author') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Lembaga -->
            <div>
              <label class="block text-sm font-bold text-slate-700 mb-2">Lembaga atau Institusi</label>
              <input type="text" name="lembaga" value="{{ old('lembaga') }}" required
                     class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm"
                     placeholder="Universitas Gadjah Mada">
              @error('lembaga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
              <input type="url" name="link_abstrak" value="{{ old('link_abstrak') }}" required
                     class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm"
                     placeholder="https://drive.google.com/...">
              <div class="flex items-start gap-2 mt-2 bg-yellow-50 border border-yellow-100 rounded-lg px-3 py-2">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-yellow-600 flex-shrink-0 mt-0.5"></i>
                <p class="text-xs text-yellow-700">Pastikan link Google Drive sudah di-set Public!</p>
              </div>
              @error('link_abstrak') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Upload Link Video -->
            <div>
              <label class="block text-sm font-bold text-slate-700 mb-2">
                Upload Link Video
                <span class="text-slate-400 font-normal">(opsional)</span>
              </label>
              <input type="url" name="link_video" value="{{ old('link_video') }}"
                     class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-amber-400 focus:ring-2 focus:ring-amber-100 outline-none transition-all text-sm"
                     placeholder="https://drive.google.com/...">
              <div class="flex items-start gap-2 mt-2 bg-yellow-50 border border-yellow-100 rounded-lg px-3 py-2">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-yellow-600 flex-shrink-0 mt-0.5"></i>
                <p class="text-xs text-yellow-700">Pastikan link Google Drive sudah di-set Public!</p>
              </div>
              @error('link_video') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          <!-- Submit -->
          <button type="submit"
                  class="w-full mt-8 bg-gradient-to-r from-amber-500 to-amber-600 text-white py-4 rounded-xl font-black text-base hover:from-amber-600 hover:to-amber-700 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
            <i data-lucide="send" class="w-5 h-5"></i>
            Kirim Submission
          </button>
        </form>
      </div>
    </div>
  </section>

  @include('components.footer')
@endsection
