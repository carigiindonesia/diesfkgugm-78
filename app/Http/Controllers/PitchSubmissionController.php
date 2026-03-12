<?php

namespace App\Http\Controllers;

use App\Models\PitchSubmission;
use App\Services\TicketService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PitchSubmissionController extends Controller
{
    public function create()
    {
        return view('pages.3mpc-submit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'authors' => 'required|string|max:1000',
            'lembaga' => 'required|string|max:255',
            'kategori' => 'required|in:original_article,case_report,review',
            'judul' => 'required|string|max:500',
            'abstract_link' => ['required', 'url', 'regex:/drive\.google\.com|docs\.google\.com/'],
            'video_link' => ['nullable', 'url', 'regex:/drive\.google\.com|docs\.google\.com|youtube\.com|youtu\.be/'],
            'consent' => 'required|accepted',
        ], [
            'abstract_link.regex' => 'Link abstrak harus berupa link Google Drive.',
            'video_link.regex' => 'Link video harus berupa link Google Drive atau YouTube.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.in' => 'Kategori yang dipilih tidak valid.',
            'consent.required' => 'Anda harus menyetujui pernyataan keaslian naskah.',
            'consent.accepted' => 'Anda harus menyetujui pernyataan keaslian naskah.',
        ]);

        unset($validated['consent']);

        $submission = PitchSubmission::create($validated);

        return redirect()->route('3mpc.show', $submission->uuid)
            ->with('success', 'Submission berhasil dikirim!');
    }

    public function show(PitchSubmission $pitchSubmission)
    {
        $ticketService = app(TicketService::class);

        return view('pages.3mpc-show', [
            'submission' => $pitchSubmission,
            'ticketService' => $ticketService,
        ]);
    }

    public function downloadTicket(PitchSubmission $pitchSubmission)
    {
        $ticketService = app(TicketService::class);

        $barcode = $ticketService->generateBarcodeForPdf($pitchSubmission->submission_number);
        $verifyUrl = route('3mpc.show', $pitchSubmission->uuid);
        $qrCode = $ticketService->generateQrCodeForPdf($verifyUrl);

        $pdf = Pdf::loadView('pages.3mpc-ticket-pdf', [
            'submission' => $pitchSubmission,
            'barcode' => $barcode,
            'qrCode' => $qrCode,
        ])->setPaper('a5', 'portrait');

        return $pdf->download("bukti-submission-{$pitchSubmission->submission_number}.pdf");
    }
}
