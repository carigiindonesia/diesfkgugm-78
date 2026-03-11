<?php

namespace App\Filament\Resources;

use App\Enums\ParticipantCategory;
use App\Filament\Resources\EventPriceResource\Pages;
use App\Models\EventPrice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventPriceResource extends Resource
{
    protected static ?string $model = EventPrice::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Tiket';

    protected static ?string $navigationLabel = 'Harga Acara';

    protected static ?string $modelLabel = 'Harga';

    protected static ?string $pluralModelLabel = 'Harga Acara';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('category')
                            ->label('Kategori')
                            ->options(collect(ParticipantCategory::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()]))
                            ->required(),

                        Forms\Components\TextInput::make('event_code')
                            ->label('Kode Acara')
                            ->required()
                            ->helperText('simposium, handson, funrun, pengmas'),

                        Forms\Components\TextInput::make('event_label')
                            ->label('Nama Acara')
                            ->required(),

                        Forms\Components\Toggle::make('is_bundle')
                            ->label('Paket Bundling')
                            ->reactive(),

                        Forms\Components\TextInput::make('bundle_code')
                            ->label('Kode Bundle')
                            ->visible(fn (Forms\Get $get) => $get('is_bundle'))
                            ->helperText('Contoh: sim+run+pm'),

                        Forms\Components\TextInput::make('bundle_label')
                            ->label('Label Bundle')
                            ->visible(fn (Forms\Get $get) => $get('is_bundle')),

                        Forms\Components\TagsInput::make('bundle_events')
                            ->label('Event dalam Bundle')
                            ->visible(fn (Forms\Get $get) => $get('is_bundle'))
                            ->helperText('Masukkan kode event: simposium, funrun, pengmas'),

                        Forms\Components\TextInput::make('base_price')
                            ->label('Harga Dasar (Rp)')
                            ->numeric()
                            ->required()
                            ->helperText('Harga sebelum biaya layanan (10%) dan PPN (11%). Display price dihitung otomatis.'),

                        Forms\Components\TextInput::make('display_price')
                            ->label('Harga Tampil (Rp)')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Dihitung otomatis: harga dasar × 1.10 × 1.11 (termasuk biaya layanan + PPN 11%)'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ParticipantCategory::from($state)->label()),
                Tables\Columns\TextColumn::make('event_label')
                    ->label('Acara')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_bundle')
                    ->label('Bundle')
                    ->boolean(),
                Tables\Columns\TextColumn::make('base_price')
                    ->label('Harga Dasar')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('display_price')
                    ->label('Harga Tampil')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(collect(ParticipantCategory::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()])),
                Tables\Filters\TernaryFilter::make('is_bundle')
                    ->label('Bundle'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventPrices::route('/'),
            'create' => Pages\CreateEventPrice::route('/create'),
            'edit' => Pages\EditEventPrice::route('/{record}/edit'),
        ];
    }
}
