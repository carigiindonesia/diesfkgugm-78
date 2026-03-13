<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Enums\ParticipantCategory;
use App\Enums\PaymentMethod;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Tiket';

    protected static ?string $navigationLabel = 'Pesanan';

    protected static ?string $modelLabel = 'Pesanan';

    protected static ?string $pluralModelLabel = 'Pesanan';

    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('No. Pesanan')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ParticipantCategory::from($state)->label())
                    ->color(fn (string $state) => match ($state) {
                        'alumni' => 'primary',
                        'civitas' => 'success',
                        'umum' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => OrderStatus::from($state)->label())
                    ->color(fn (string $state) => OrderStatus::from($state)->color()),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Cara Pembayaran')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => PaymentMethod::tryFrom($state)?->label() ?? $state)
                    ->color(fn (string $state) => PaymentMethod::tryFrom($state)?->color() ?? 'gray')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('email_sent')
                    ->label('Email')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Dibayar')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(OrderStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])),
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(collect(ParticipantCategory::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()])),
                Tables\Filters\TernaryFilter::make('is_bundle')
                    ->label('Paket Bundling'),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Cara Pembayaran')
                    ->options(collect(PaymentMethod::cases())->mapWithKeys(fn ($m) => [$m->value => $m->label()])),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Data Peserta')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('order_number')->label('No. Pesanan'),
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->formatStateUsing(fn (string $state) => OrderStatus::from($state)->label())
                            ->color(fn (string $state) => OrderStatus::from($state)->color()),
                        Infolists\Components\TextEntry::make('nama_lengkap')->label('Nama Lengkap'),
                        Infolists\Components\TextEntry::make('tanggal_lahir')->label('Tanggal Lahir')->date(),
                        Infolists\Components\TextEntry::make('nik')->label('NIK')
                            ->visible(fn ($record) => $record->nik),
                        Infolists\Components\TextEntry::make('nama_satusehat')->label('Nama SATUSEHAT SDMK'),
                        Infolists\Components\TextEntry::make('email_satusehat')->label('Email SATUSEHAT'),
                        Infolists\Components\TextEntry::make('email')->label('Email'),
                        Infolists\Components\TextEntry::make('whatsapp')->label('WhatsApp'),
                        Infolists\Components\TextEntry::make('lembaga')->label('Lembaga'),
                        Infolists\Components\TextEntry::make('category')
                            ->label('Kategori')
                            ->formatStateUsing(fn (string $state) => ParticipantCategory::from($state)->label()),
                        Infolists\Components\TextEntry::make('jersey_type')
                            ->label('Tipe Jersey')
                            ->visible(fn ($record) => $record->jersey_type),
                        Infolists\Components\TextEntry::make('jersey_size')
                            ->label('Ukuran Jersey')
                            ->visible(fn ($record) => $record->jersey_size),
                    ]),

                Infolists\Components\Section::make('Pembayaran')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('payment_method')
                            ->label('Cara Pembayaran')
                            ->badge()
                            ->formatStateUsing(fn (string $state) => PaymentMethod::tryFrom($state)?->label() ?? $state)
                            ->color(fn (string $state) => PaymentMethod::tryFrom($state)?->color() ?? 'gray'),
                        Infolists\Components\TextEntry::make('subtotal')->money('IDR'),
                        Infolists\Components\TextEntry::make('fee_amount')->label('Biaya')->money('IDR'),
                        Infolists\Components\TextEntry::make('total_amount')->label('Total')->money('IDR'),
                        Infolists\Components\TextEntry::make('xendit_payment_method')->label('Metode Bayar Xendit')
                            ->visible(fn ($record) => $record->payment_method === PaymentMethod::PaymentGateway->value),
                        Infolists\Components\TextEntry::make('paid_at')->label('Dibayar')->dateTime(),
                        Infolists\Components\TextEntry::make('xendit_invoice_id')->label('Xendit Invoice ID')
                            ->visible(fn ($record) => $record->payment_method === PaymentMethod::PaymentGateway->value),
                        Infolists\Components\ImageEntry::make('payment_proof')
                            ->label('Bukti Pembayaran')
                            ->disk('public')
                            ->columnSpanFull()
                            ->visible(fn ($record) => $record->payment_method === PaymentMethod::Manual->value && $record->payment_proof),
                    ]),

                Infolists\Components\Section::make('Item Pesanan')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('event_label')->label('Acara'),
                                Infolists\Components\TextEntry::make('display_price')->label('Harga')->money('IDR'),
                            ])
                            ->columns(2),
                    ]),

                Infolists\Components\Section::make('Tiket')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('tickets')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('ticket_code')->label('Kode Tiket')->copyable(),
                                Infolists\Components\TextEntry::make('event_label')->label('Acara'),
                                Infolists\Components\IconEntry::make('is_checked_in')->label('Check-in')->boolean(),
                                Infolists\Components\TextEntry::make('checked_in_at')->label('Waktu Check-in')->dateTime(),
                            ])
                            ->columns(4),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create-manual' => Pages\CreateManualOrder::route('/create-manual'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
