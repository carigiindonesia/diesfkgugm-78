<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\EventType;
use App\Enums\OrderStatus;
use App\Enums\ParticipantCategory;
use App\Enums\PaymentMethod;
use App\Filament\Resources\OrderResource;
use App\Models\EventPrice;
use App\Models\Order;
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

    protected static ?string $title = 'Tambah Peserta Manual';

    protected static ?string $breadcrumb = 'Tambah Manual';

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
                            ->required()
                            ->maxDate(now()->subDay()),
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->maxLength(16),
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
                            ->label('Lembaga/Institusi')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('category')
                            ->label('Kategori Peserta')
                            ->options(collect(ParticipantCategory::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()]))
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn (Forms\Set $set) => $set('event_price_id', null)),
                        Forms\Components\TextInput::make('nama_satusehat')
                            ->label('Nama SATUSEHAT SDMK')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email_satusehat')
                            ->label('Email SATUSEHAT')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('whatsapp_satusehat')
                            ->label('WhatsApp SATUSEHAT')
                            ->maxLength(20),
                    ]),

                Forms\Components\Section::make('Event & Pembayaran')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('event_price_id')
                            ->label('Event')
                            ->options(function (Forms\Get $get) {
                                $category = $get('category');
                                if (! $category) {
                                    return EventPrice::active()->get()
                                        ->mapWithKeys(fn ($ep) => [
                                            $ep->id => $ep->event_label.' - '.ParticipantCategory::from($ep->category)->label().' ('.$ep->formatted_display_price.')',
                                        ]);
                                }

                                return EventPrice::active()->forCategory($category)->get()
                                    ->mapWithKeys(fn ($ep) => [
                                        $ep->id => $ep->event_label.' ('.$ep->formatted_display_price.')',
                                    ]);
                            })
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Forms\Set $set, $state) {
                                if ($state) {
                                    $eventPrice = EventPrice::find($state);
                                    if ($eventPrice) {
                                        $set('subtotal', $eventPrice->base_price);
                                        $set('fee_amount', $eventPrice->display_price - $eventPrice->base_price);
                                        $set('total_amount', $eventPrice->display_price);
                                    }
                                }
                            }),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->maxValue(10)
                            ->required(),
                        Forms\Components\TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('fee_amount')
                            ->label('Biaya')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('total_amount')
                            ->label('Total')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),
                        Forms\Components\FileUpload::make('payment_proof')
                            ->label('Bukti Pembayaran')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png'])
                            ->maxSize(2048)
                            ->directory('payment-proofs')
                            ->disk('public')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Fun Run (Opsional)')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        Forms\Components\Select::make('jersey_type')
                            ->label('Tipe Jersey')
                            ->options([
                                'dewasa' => 'Dewasa',
                                'anak' => 'Anak',
                            ]),
                        Forms\Components\Select::make('jersey_size')
                            ->label('Ukuran Jersey')
                            ->options([
                                'XS' => 'XS', 'S' => 'S', 'M' => 'M', 'L' => 'L',
                                'XL' => 'XL', 'XXL' => 'XXL', 'XXXL' => 'XXXL',
                                '3XL' => '3XL', '4XL' => '4XL', '5XL' => '5XL',
                            ]),
                        Forms\Components\TextInput::make('emergency_contact_name')
                            ->label('Nama Kontak Darurat')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emergency_contact_whatsapp')
                            ->label('WhatsApp Kontak Darurat')
                            ->maxLength(20),
                    ]),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $eventPrice = EventPrice::findOrFail($data['event_price_id']);
        $quantity = (int) ($data['quantity'] ?? 1);

        DB::transaction(function () use ($data, $eventPrice, $quantity) {
            $order = Order::create([
                'nama_lengkap' => $data['nama_lengkap'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'nik' => $data['nik'] ?? null,
                'nama_satusehat' => $data['nama_satusehat'] ?? null,
                'email_satusehat' => $data['email_satusehat'] ?? null,
                'email' => $data['email'],
                'whatsapp_satusehat' => $data['whatsapp_satusehat'] ?? null,
                'whatsapp' => $data['whatsapp'],
                'lembaga' => $data['lembaga'],
                'category' => $data['category'],
                'jersey_type' => $data['jersey_type'] ?? null,
                'jersey_size' => $data['jersey_size'] ?? null,
                'emergency_contact_name' => $data['emergency_contact_name'] ?? null,
                'emergency_contact_whatsapp' => $data['emergency_contact_whatsapp'] ?? null,
                'quantity' => $quantity,
                'subtotal' => $data['subtotal'],
                'fee_amount' => $data['fee_amount'],
                'total_amount' => $data['total_amount'],
                'status' => OrderStatus::Paid->value,
                'payment_method' => PaymentMethod::Manual->value,
                'payment_proof' => $data['payment_proof'],
                'paid_at' => now(),
                'is_bundle' => $eventPrice->is_bundle,
                'bundle_code' => $eventPrice->bundle_code,
            ]);

            // Create order items
            if ($eventPrice->is_bundle) {
                foreach ($eventPrice->bundle_events as $eventCode) {
                    $individual = EventPrice::where('category', $eventPrice->category)
                        ->where('event_code', $eventCode)
                        ->where('is_bundle', false)
                        ->first();

                    $order->items()->create([
                        'event_code' => $eventCode,
                        'event_label' => $individual?->event_label ?? EventType::from($eventCode)->label(),
                        'base_price' => $individual?->base_price ?? 0,
                        'display_price' => $individual?->display_price ?? 0,
                        'participant_name' => $data['nama_lengkap'],
                        'participant_tanggal_lahir' => $data['tanggal_lahir'],
                        'participant_nik' => $data['nik'] ?? null,
                        'participant_lembaga' => $data['lembaga'],
                        'participant_nama_satusehat' => $data['nama_satusehat'] ?? null,
                        'participant_jersey_type' => $eventCode === 'funrun' ? ($data['jersey_type'] ?? null) : null,
                        'participant_jersey_size' => $eventCode === 'funrun' ? ($data['jersey_size'] ?? null) : null,
                        'participant_emergency_contact_name' => $eventCode === 'funrun' ? ($data['emergency_contact_name'] ?? null) : null,
                        'participant_emergency_contact_whatsapp' => $eventCode === 'funrun' ? ($data['emergency_contact_whatsapp'] ?? null) : null,
                    ]);
                }
            } else {
                $order->items()->create([
                    'event_code' => $eventPrice->event_code,
                    'event_label' => $eventPrice->event_label,
                    'base_price' => $eventPrice->base_price,
                    'display_price' => $eventPrice->display_price,
                    'participant_name' => $data['nama_lengkap'],
                    'participant_tanggal_lahir' => $data['tanggal_lahir'],
                    'participant_nik' => $data['nik'] ?? null,
                    'participant_lembaga' => $data['lembaga'],
                    'participant_nama_satusehat' => $data['nama_satusehat'] ?? null,
                    'participant_jersey_type' => $data['jersey_type'] ?? null,
                    'participant_jersey_size' => $data['jersey_size'] ?? null,
                    'participant_emergency_contact_name' => $data['emergency_contact_name'] ?? null,
                    'participant_emergency_contact_whatsapp' => $data['emergency_contact_whatsapp'] ?? null,
                ]);
            }

            // Generate tickets immediately since payment is manual and confirmed
            $ticketService = app(TicketService::class);
            $ticketService->generateTickets($order);
        });

        Notification::make()
            ->title('Peserta berhasil ditambahkan')
            ->body('Order manual berhasil dibuat dan tiket telah digenerate.')
            ->success()
            ->send();

        $this->redirect(OrderResource::getUrl('index'));
    }
}
