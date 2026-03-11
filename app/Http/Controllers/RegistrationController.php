<?php

namespace App\Http\Controllers;

use App\Enums\ParticipantCategory;
use App\Models\EventPrice;
use App\Models\Order;
use App\Services\PricingService;
use App\Services\XenditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('kategori', 'umum');
        if (! in_array($category, ['alumni', 'civitas', 'umum'])) {
            $category = 'umum';
        }

        $categories = ParticipantCategory::cases();
        $prices = EventPrice::active()->individual()->forCategory($category)->get();
        $selectedEvent = $request->query('event');

        return view('pages.registrasi', compact('category', 'categories', 'prices', 'selectedEvent'));
    }

    public function bundling(Request $request)
    {
        $category = $request->query('kategori', 'umum');
        if (! in_array($category, ['alumni', 'civitas', 'umum'])) {
            $category = 'umum';
        }

        $categories = ParticipantCategory::cases();
        $bundles = EventPrice::active()->bundle()->forCategory($category)->get();
        $individualPrices = EventPrice::active()->individual()->forCategory($category)->get();

        return view('pages.registrasi-bundling', compact('category', 'categories', 'bundles', 'individualPrices'));
    }

    public function store(Request $request)
    {
        $eventPrice = EventPrice::findOrFail($request->input('event_price_id'));

        $formType = $this->determineFormType($eventPrice);

        $rules = $this->buildValidationRules($formType);
        $validated = $request->validate($rules);

        $validated = $this->resolveContactFields($validated, $formType);

        $recentPending = Order::where('email', $validated['email'])
            ->where('status', 'pending')
            ->where('created_at', '>', now()->subMinutes(5))
            ->first();

        if ($recentPending) {
            return redirect()->route('pembayaran.show', $recentPending->uuid);
        }

        $order = null;

        DB::transaction(function () use ($validated, $eventPrice, &$order) {
            $order = Order::create([
                'nama_lengkap' => $validated['nama_lengkap'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'nama_satusehat' => $validated['nama_satusehat'] ?? null,
                'email_satusehat' => $validated['email_satusehat'] ?? null,
                'email' => $validated['email'],
                'whatsapp_satusehat' => $validated['whatsapp_satusehat'] ?? null,
                'whatsapp' => $validated['whatsapp'],
                'lembaga' => $validated['lembaga'],
                'category' => $validated['category'],
                'jersey_type' => $validated['jersey_type'] ?? null,
                'jersey_size' => $validated['jersey_size'] ?? null,
                'subtotal' => $eventPrice->base_price,
                'fee_amount' => PricingService::calculateFee($eventPrice->base_price),
                'total_amount' => $eventPrice->display_price,
                'is_bundle' => $eventPrice->is_bundle,
                'bundle_code' => $eventPrice->bundle_code,
                'expired_at' => now()->addHours(24),
            ]);

            $this->createOrderItems($order, $eventPrice);
        });

        return $this->createInvoiceAndRedirect($order);
    }

    private function determineFormType(EventPrice $eventPrice): string
    {
        if (! $eventPrice->is_bundle && $eventPrice->event_code === 'funrun') {
            return 'funrun';
        }

        if ($eventPrice->is_bundle && in_array('funrun', $eventPrice->bundle_events ?? [])) {
            return 'mixed';
        }

        return 'satusehat';
    }

    private function buildValidationRules(string $formType): array
    {
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before:today',
            'lembaga' => 'required|string|max:255',
            'category' => 'required|in:alumni,civitas,umum',
            'event_price_id' => 'required|exists:event_prices,id',
        ];

        if ($formType === 'satusehat' || $formType === 'mixed') {
            $rules['nama_satusehat'] = 'required|string|max:255';
            $rules['email_satusehat'] = 'required|email|max:255';
            $rules['whatsapp_satusehat'] = 'required|string|max:20';
        }

        if ($formType === 'funrun') {
            $rules['email'] = 'required|email|max:255';
            $rules['whatsapp'] = 'required|string|max:20';
            $rules['jersey_type'] = 'required|in:dewasa,anak';
            $rules['jersey_size'] = 'required|in:S,M,L,XL,XXL,XXXL';
        }

        if ($formType === 'mixed') {
            $rules['jersey_type'] = 'required|in:dewasa,anak';
            $rules['jersey_size'] = 'required|in:S,M,L,XL,XXL,XXXL';
        }

        return $rules;
    }

    private function resolveContactFields(array $validated, string $formType): array
    {
        if ($formType !== 'funrun') {
            $validated['email'] = $validated['email_satusehat'];
            $validated['whatsapp'] = $validated['whatsapp_satusehat'];
        }

        return $validated;
    }

    private function createOrderItems(Order $order, EventPrice $eventPrice): void
    {
        if ($eventPrice->is_bundle) {
            foreach ($eventPrice->bundle_events as $eventCode) {
                $individual = EventPrice::where('category', $eventPrice->category)
                    ->where('event_code', $eventCode)
                    ->where('is_bundle', false)
                    ->first();

                $order->items()->create([
                    'event_code' => $eventCode,
                    'event_label' => $individual?->event_label ?? \App\Enums\EventType::from($eventCode)->label(),
                    'base_price' => $individual?->base_price ?? 0,
                    'display_price' => $individual?->display_price ?? 0,
                ]);
            }

            return;
        }

        $order->items()->create([
            'event_code' => $eventPrice->event_code,
            'event_label' => $eventPrice->event_label,
            'base_price' => $eventPrice->base_price,
            'display_price' => $eventPrice->display_price,
        ]);
    }

    private function createInvoiceAndRedirect(Order $order)
    {
        try {
            $xenditService = app(XenditService::class);
            $invoice = $xenditService->createInvoice($order);

            $order->update([
                'xendit_invoice_id' => $invoice['id'],
                'xendit_invoice_url' => $invoice['invoice_url'],
            ]);

            return redirect($invoice['invoice_url']);
        } catch (\Exception $e) {
            return redirect()->route('pembayaran.show', $order->uuid)
                ->with('error', 'Gagal membuat invoice pembayaran. Silakan coba lagi.');
        }
    }
}
