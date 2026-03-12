@extends('layouts.app')

@section('content')
  @include('components.navbar')

  <!-- ==================== 3MPC SUBMISSION DETAIL ==================== -->
  <section class="pt-32 pb-20 min-h-screen bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Success Alert -->
      @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-8 text-sm flex items-center gap-3 fade-in">
          <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
          {{ session('success') }}
        </div>
      @endif

      <!-- Header -->
      <div class="text-center mb-10 fade-in">
        <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <i data-lucide="file-text" class="w-10 h-10 text-amber-600"></i>
        </div>
        <h1 class="text-3xl font-black text-slate-800">Detail Submission</h1>
        <p class="text-slate-500 mt-2">3-Minute Pitch Competition</p>
      </div>

      <!-- Submission Card -->
      <div class="bg-white rounded-3xl border border-slate-100 shadow-lg p-8 md:p-10 fade-in">

        <!-- Status Badge -->
        <div class="flex items-center justify-between mb-8">
          <span class="text-sm font-bold text-slate-400">{{ $submission->submission_number }}</span>
          @php
            $statusConfig = [
              'submitted' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Submitted'],
              'reviewing' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Reviewing'],
              'accepted'  => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Accepted'],
              'rejected'  => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Rejected'],
            ];
            $status = $statusConfig[$submission->status] ?? $statusConfig['submitted'];

            $kategoriLabels = [
              'original_article' => 'Original Article',
              'case_report' => 'Case Report',
              'review' => 'Review',
            ];
          @endphp
          <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $status['bg'] }} {{ $status['text'] }}">
            {{ $status['label'] }}
          </span>
        </div>

        <!-- Details -->
        <div class="space-y-6">
          <div>
            <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-1">Nomor Submission</p>
            <p class="text-sm font-bold text-slate-800">{{ $submission->submission_number }}</p>
          </div>

          <div>
            <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-1">Author(s)</p>
            <p class="text-sm font-bold text-slate-800">{{ $submission->authors }}</p>
          </div>

          <div>
            <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-1">Lembaga / Institusi</p>
            <p class="text-sm font-bold text-slate-800">{{ $submission->lembaga }}</p>
          </div>

          @if($submission->kategori)
          <div>
            <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-1">Kategori</p>
            <p class="text-sm font-bold text-slate-800">{{ $kategoriLabels[$submission->kategori] ?? $submission->kategori }}</p>
          </div>
          @endif

          <div>
            <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-1">Judul</p>
            <p class="text-sm font-bold text-slate-800">{{ $submission->judul }}</p>
          </div>

          <div>
            <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-1">Waktu Submit</p>
            <p class="text-sm font-bold text-slate-800">
              {{ $submission->created_at->locale('id')->isoFormat('dddd, D MMMM Y') }}
              pukul {{ $submission->created_at->format('H:i') }} WIB
            </p>
          </div>

          <!-- Links -->
          <div class="border-t border-slate-100 pt-6 space-y-4">
            <div>
              <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-2">Link Abstrak</p>
              <a href="{{ $submission->abstract_link }}" target="_blank" rel="noreferrer"
                 class="inline-flex items-center gap-2 text-sm font-bold text-amber-600 hover:text-amber-700 transition-colors bg-amber-50 px-4 py-2.5 rounded-xl">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                Buka Abstrak
              </a>
            </div>

            @if($submission->video_link)
              <div>
                <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-2">Link Video</p>
                <a href="{{ $submission->video_link }}" target="_blank" rel="noreferrer"
                   class="inline-flex items-center gap-2 text-sm font-bold text-amber-600 hover:text-amber-700 transition-colors bg-amber-50 px-4 py-2.5 rounded-xl">
                  <i data-lucide="external-link" class="w-4 h-4"></i>
                  Buka Video
                </a>
              </div>
            @endif
          </div>

          <!-- Barcode & QR Code -->
          <div class="border-t border-slate-100 pt-6">
            <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-4 text-center">Bukti Submission</p>

            <div class="text-center py-4">
              <div class="inline-block mb-4">
                {!! $ticketService->generateBarcode($submission->submission_number) !!}
              </div>
              <br>
              <div class="inline-block bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(200)->errorCorrection('H')->generate(route('3mpc.show', $submission->uuid)) !!}
              </div>
              <p class="text-xs text-slate-400 mt-3">Scan QR Code untuk verifikasi submission</p>
            </div>
          </div>
        </div>

        <!-- Download Button -->
        <div class="mt-8">
          <a href="{{ route('3mpc.download-ticket', $submission->uuid) }}"
             class="w-full flex items-center justify-center gap-2 bg-amber-500 text-white py-3.5 rounded-xl font-bold text-sm hover:bg-amber-600 transition-all shadow-md">
            <i data-lucide="download" class="w-4 h-4"></i>
            Download Bukti Submission (PDF)
          </a>
        </div>
      </div>

      <!-- Support -->
      <div class="bg-white rounded-3xl border border-slate-100 shadow-lg p-6 mt-6 fade-in">
        <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100">
          <p class="text-xs font-bold text-blue-800 tracking-widest uppercase mb-2">Registrations Support & Helpdesk</p>
          <p class="text-sm font-bold text-blue-900">Carigi Indonesia</p>
          <p class="text-sm text-blue-800">WhatsApp: <strong>085147686127</strong></p>
          <p class="text-xs text-slate-500 mt-2">Hubungi kami jika ada kendala atau kesulitan.</p>
        </div>
      </div>

      <!-- Back Link -->
      <div class="text-center mt-8 fade-in">
        <a href="/"
           class="inline-flex items-center gap-2 text-slate-500 font-bold text-sm hover:text-slate-700 transition-colors">
          <i data-lucide="arrow-left" class="w-4 h-4"></i>
          Kembali ke Beranda
        </a>
      </div>
    </div>
  </section>

  @include('components.footer')
@endsection
