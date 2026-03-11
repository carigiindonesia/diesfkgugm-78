<?php

namespace App\Http\Controllers;

use App\Models\PitchSubmission;
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
            'judul' => 'required|string|max:500',
            'abstract_link' => ['required', 'url', 'regex:/drive\.google\.com|docs\.google\.com/'],
            'video_link' => ['nullable', 'url', 'regex:/drive\.google\.com|docs\.google\.com|youtube\.com|youtu\.be/'],
        ], [
            'abstract_link.regex' => 'Link abstrak harus berupa link Google Drive.',
            'video_link.regex' => 'Link video harus berupa link Google Drive atau YouTube.',
        ]);

        $submission = PitchSubmission::create($validated);

        return redirect()->route('3mpc.show', $submission->uuid)
            ->with('success', 'Submission berhasil dikirim!');
    }

    public function show(PitchSubmission $pitchSubmission)
    {
        return view('pages.3mpc-show', ['submission' => $pitchSubmission]);
    }
}
