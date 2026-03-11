<?php

namespace App\Filament\Resources;

use App\Enums\EventType;
use App\Enums\ParticipantCategory;
use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Tiket';

    protected static ?string $navigationLabel = 'Tiket';

    protected static ?string $modelLabel = 'Tiket';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticket_code')
                    ->label('Kode Tiket')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('participant_name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('event_label')
                    ->label('Acara'),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ParticipantCategory::from($state)->label())
                    ->color(fn (string $state) => match ($state) {
                        'alumni' => 'primary',
                        'civitas' => 'success',
                        'umum' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('participant_lembaga')
                    ->label('Lembaga')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_checked_in')
                    ->label('Check-in')
                    ->boolean(),
                Tables\Columns\TextColumn::make('checked_in_at')
                    ->label('Waktu Check-in')
                    ->dateTime('d M Y H:i')
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('event_code')
                    ->label('Acara')
                    ->options(collect(EventType::cases())->mapWithKeys(fn ($e) => [$e->value => $e->label()])),
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(collect(ParticipantCategory::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()])),
                Tables\Filters\TernaryFilter::make('is_checked_in')
                    ->label('Status Check-in'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('checkin')
                    ->label('Check-in')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Check-in')
                    ->modalDescription(fn (Ticket $record) => "Check-in {$record->participant_name} untuk {$record->event_label}?")
                    ->visible(fn (Ticket $record) => ! $record->is_checked_in)
                    ->action(function (Ticket $record) {
                        $record->update([
                            'is_checked_in' => true,
                            'checked_in_at' => now(),
                            'checked_in_by' => auth()->user()->name,
                        ]);
                    }),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Detail Tiket')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('ticket_code')->label('Kode Tiket')->copyable(),
                        Infolists\Components\TextEntry::make('event_label')->label('Acara'),
                        Infolists\Components\TextEntry::make('participant_name')->label('Nama'),
                        Infolists\Components\TextEntry::make('participant_lembaga')->label('Lembaga'),
                        Infolists\Components\TextEntry::make('category')
                            ->label('Kategori')
                            ->formatStateUsing(fn (string $state) => ParticipantCategory::from($state)->label()),
                        Infolists\Components\TextEntry::make('order.order_number')->label('No. Pesanan'),
                        Infolists\Components\IconEntry::make('is_checked_in')->label('Check-in')->boolean(),
                        Infolists\Components\TextEntry::make('checked_in_at')->label('Waktu Check-in')->dateTime(),
                        Infolists\Components\TextEntry::make('checked_in_by')->label('Oleh'),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'view' => Pages\ViewTicket::route('/{record}'),
        ];
    }
}
