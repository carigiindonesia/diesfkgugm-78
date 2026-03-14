<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteVisitResource\Pages;
use App\Models\SiteVisit;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteVisitResource extends Resource
{
    protected static ?string $model = SiteVisit::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Monitoring';

    protected static ?string $navigationLabel = 'Traffic Website';

    protected static ?string $modelLabel = 'Kunjungan';

    protected static ?string $pluralModelLabel = 'Traffic Website';

    protected static ?int $navigationSort = 10;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('method')
                    ->label('Method')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'GET' => 'info',
                        'POST' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->url),
                Tables\Columns\TextColumn::make('page_type')
                    ->label('Tipe Halaman')
                    ->badge()
                    ->color(fn (?string $state) => match ($state) {
                        'home' => 'gray',
                        'registration' => 'info',
                        'registration_submit' => 'warning',
                        'payment' => 'success',
                        'ticket' => 'primary',
                        'article' => 'gray',
                        '3mpc' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('order_status')
                    ->label('Status Order')
                    ->badge()
                    ->placeholder('—')
                    ->color(fn (?string $state) => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'expired' => 'danger',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->toggleable(),
                Tables\Columns\TextColumn::make('referer')
                    ->label('Referer')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('page_type')
                    ->label('Tipe Halaman')
                    ->options([
                        'home' => 'Home',
                        'registration' => 'Registrasi',
                        'registration_submit' => 'Submit Registrasi',
                        'payment' => 'Pembayaran',
                        'ticket' => 'Tiket',
                        'article' => 'Artikel',
                        '3mpc' => '3MPC',
                    ]),
                Tables\Filters\SelectFilter::make('method')
                    ->options([
                        'GET' => 'GET',
                        'POST' => 'POST',
                    ]),
                Tables\Filters\Filter::make('has_email')
                    ->label('Dengan Email')
                    ->query(fn ($query) => $query->whereNotNull('email')),
                Tables\Filters\Filter::make('today')
                    ->label('Hari Ini')
                    ->query(fn ($query) => $query->whereDate('created_at', today()))
                    ->default(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->poll('30s');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteVisits::route('/'),
        ];
    }
}
