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
            <p class="text-sm font-bold text-slate-800">{{ $submission->nama_author }}</p>
          </div>

          <div>
            <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-1">Lembaga / Institusi</p>
            <p class="text-sm font-bold text-slate-800">{{ $submission->lembaga }}</p>
          </div>

          <div>
            <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-1">Judul</p>
            <p class="text-sm font-bold text-slate-800">{{ $submission->judul }}</p>
          </div>

          <!-- Links -->
          <div class="border-t border-slate-100 pt-6 space-y-4">
            <div>
              <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-2">Link Abstrak</p>
              <a href="{{ $submission->link_abstrak }}" target="_blank" rel="noreferrer"
                 class="inline-flex items-center gap-2 text-sm font-bold text-amber-600 hover:text-amber-700 transition-colors bg-amber-50 px-4 py-2.5 rounded-xl">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                Buka Abstrak
              </a>
            </div>

            @if($submission->link_video)
              <div>
                <p class="text-xs text-slate-400 font-bold tracking-widest uppercase mb-2">Link Video</p>
                <a href="{{ $submission->link_video }}" target="_blank" rel="noreferrer"
                   class="inline-flex items-center gap-2 text-sm font-bold text-amber-600 hover:text-amber-700 transition-colors bg-amber-50 px-4 py-2.5 rounded-xl">
                  <i data-lucide="external-link" class="w-4 h-4"></i>
                  Buka Video
                </a>
              </div>
            @endif
          </div>
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
