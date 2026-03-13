<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\ParticipantCategory;
use App\Filament\Resources\OrderResource;
use App\Models\EventPrice;
use App\Models\Order;
use App\Services\PricingService;
use App\Services\TicketService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;

class CreateManualOrder extends Page
{
    protected static string $resource = OrderResource::class;

    protected static string $view = 'filament.resources.order-resource.pages.create-manual-order';

    protected static ?string $title = 'Registrasi Manual';

    protected static ?string $breadcrumb = 'Registrasi Manual';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Peserta')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required(),
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->maxLength(16),
                        Forms\Components\TextInput::make('nama_satusehat')
                            ->label('Nama SATUSEHAT SDMK')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('lembaga')
                            ->label('Lembaga')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('category')
                            ->label('Kategori')
                            ->options(collect(ParticipantCategory::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()]))
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn (Forms\Set $set) => $set('event_price_id', null)),
                    ]),

                Forms\Components\Section::make('Event')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('event_price_id')
                            ->label('Pilih Event')
                            ->options(function (Forms\Get $get) {
                                $category = $get('category');
                                if (! $category) {
                                    return [];
                                }

                                return EventPrice::where('category', $category)
                                    ->where('is_active', true)
                                    ->get()
                                    ->mapWithKeys(fn ($ep) => [
                                        $ep->id => $ep->event_label.' - '.PricingService::formatRupiah($ep->display_price).($ep->is_bundle ? ' (Bundling)' : ''),
                                    ]);
                            })
                            ->required()
                            ->reactive()
                            ->searchable()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('jersey_type')
                            ->label('Tipe Jersey')
                            ->placeholder('dewasa / anak')
                            ->visible(fn (Forms\Get $get) => $this->isFunrunEvent($get('event_price_id'))),
                        Forms\Components\TextInput::make('jersey_size')
                            ->label('Ukuran Jersey')
                            ->placeholder('XS / S / M / L / XL / 2XL / 3XL / 4XL / 5XL')
                            ->visible(fn (Forms\Get $get) => $this->isFunrunEvent($get('event_price_id'))),
                        Forms\Components\TextInput::make('emergency_contact_name')
                            ->label('Nama Kontak Darurat')
                            ->visible(fn (Forms\Get $get) => $this->isFunrunEvent($get('event_price_id'))),
                        Forms\Components\TextInput::make('emergency_contact_whatsapp')
                            ->label('WhatsApp Kontak Darurat')
                            ->maxLength(20)
                            ->visible(fn (Forms\Get $get) => $this->isFunrunEvent($get('event_price_id'))),
                    ]),

                Forms\Components\Section::make('Bukti Pembayaran')
                    ->schema([
                        Forms\Components\FileUpload::make('payment_proof')
                            ->label('Upload Bukti Pembayaran')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->maxSize(2048)
                            ->directory('payment-proofs')
                            ->disk('public')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $eventPrice = EventPrice::findOrFail($data['event_price_id']);

        DB::transaction(function () use ($data, $eventPrice) {
            $order = Order::create([
                'nama_lengkap' => $data['nama_lengkap'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'nik' => $data['nik'] ?? null,
                'nama_satusehat' => $data['nama_satusehat'] ?? null,
                'email' => $data['email'],
                'whatsapp' => $data['whatsapp'],
                'lembaga' => $data['lembaga'],
                'category' => $data['category'],
                'jersey_type' => $data['jersey_type'] ?? null,
                'jersey_size' => $data['jersey_size'] ?? null,
                'emergency_contact_name' => $data['emergency_contact_name'] ?? null,
                'emergency_contact_whatsapp' => $data['emergency_contact_whatsapp'] ?? null,
                'quantity' => 1,
                'subtotal' => $eventPrice->base_price,
                'fee_amount' => PricingService::calculateFee($eventPrice->base_price),
                'total_amount' => $eventPrice->display_price,
                'status' => 'paid',
                'payment_method' => 'manual',
                'payment_proof' => $data['payment_proof'],
                'paid_at' => now(),
                'is_bundle' => $eventPrice->is_bundle,
                'bundle_code' => $eventPrice->bundle_code,
            ]);

            $events = $eventPrice->is_bundle
                ? $eventPrice->bundle_events
                : [$eventPrice->event_code];

            foreach ($events as $eventCode) {
                $label = $eventPrice->is_bundle
                    ? (EventPrice::where('event_code', $eventCode)->where('is_bundle', false)->first()?->event_label ?? $eventCode)
                    : $eventPrice->event_label;

                $order->items()->create([
                    'event_code' => $eventCode,
                    'event_label' => $label,
                    'base_price' => $eventPrice->base_price,
                    'display_price' => $eventPrice->display_price,
                    'participant_name' => $data['nama_lengkap'],
                    'participant_lembaga' => $data['lembaga'],
                ]);
            }

            $ticketService = app(TicketService::class);
            $ticketService->generateTickets($order);
        });

        Notification::make()
            ->title('Registrasi manual berhasil')
            ->body('Peserta telah didaftarkan dan tiket telah dibuat.')
            ->success()
            ->send();

        $this->redirect(OrderResource::getUrl('index'));
    }

    protected function isFunrunEvent(?int $eventPriceId): bool
    {
        if (! $eventPriceId) {
            return false;
        }

        $eventPrice = EventPrice::find($eventPriceId);
        if (! $eventPrice) {
            return false;
        }

        if ($eventPrice->is_bundle && $eventPrice->bundle_events) {
            return in_array('funrun', $eventPrice->bundle_events);
        }

        return $eventPrice->event_code === 'funrun';
    }
}
