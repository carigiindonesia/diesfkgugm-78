<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PitchSubmissionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show']);

// Registration
Route::get('/registrasi', [RegistrationController::class, 'index'])->name('registrasi.index');
Route::get('/registrasi/bundling', [RegistrationController::class, 'bundling'])->name('registrasi.bundling');
Route::post('/registrasi', [RegistrationController::class, 'store'])->name('registrasi.store')->middleware('throttle:10,1');

// Payment
Route::get('/pembayaran/{order:uuid}', [PaymentController::class, 'show'])->name('pembayaran.show');

// Xendit Webhook (CSRF excluded in bootstrap/app.php)
Route::post('/webhook/xendit', [WebhookController::class, 'handleXendit'])->name('webhook.xendit');

// Tickets
Route::get('/tiket/{ticket:ticket_code}', [TicketController::class, 'show'])->name('tiket.show');
Route::get('/tiket/{ticket:ticket_code}/verify', [TicketController::class, 'verify'])->name('tiket.verify');
Route::get('/tiket/{ticket:ticket_code}/download', [TicketController::class, 'download'])->name('tiket.download');

// 3MPC
Route::get('/3mpc/submit', [PitchSubmissionController::class, 'create'])->name('3mpc.create');
Route::post('/3mpc/submit', [PitchSubmissionController::class, 'store'])->name('3mpc.store')->middleware('throttle:5,1');
Route::get('/3mpc/submission/{pitchSubmission:uuid}', [PitchSubmissionController::class, 'show'])->name('3mpc.show');
