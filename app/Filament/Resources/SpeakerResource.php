<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpeakerResource\Pages;
use App\Models\Speaker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SpeakerResource extends Resource
{
    protected static ?string $model = Speaker::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Pembicara';

    protected static ?string $modelLabel = 'Pembicara';

    protected static ?string $pluralModelLabel = 'Pembicara';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pembicara')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('title')
                            ->label('Gelar / Jabatan')
                            ->maxLength(255)
                            ->helperText('Contoh: Keynote Speaker, Departemen Ortodonsia, Main Speaker'),

                        Forms\Components\Textarea::make('topic')
                            ->label('Topik')
                            ->rows(2),

                        Forms\Components\Select::make('section')
                            ->label('Seksi')
                            ->required()
                            ->options([
                                'keynote' => 'Keynote & Main Speakers',
                                'scientific' => 'Scientific Session',
                                'handson' => 'Hands-on Instructors',
                            ]),

                        Forms\Components\TextInput::make('day')
                            ->label('Hari')
                            ->helperText('Contoh: Day 1, Day 2'),

                        Forms\Components\TextInput::make('initials')
                            ->label('Inisial')
                            ->maxLength(5)
                            ->helperText('Ditampilkan jika belum ada foto'),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ]),

                Forms\Components\Section::make('Foto')
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label('Foto Pembicara')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('400')
                            ->imageResizeTargetHeight('400')
                            ->directory('speakers')
                            ->disk('public')
                            ->helperText('Upload foto dengan rasio 1:1. Maksimal 2MB.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn (Speaker $record) => 'https://ui-avatars.com/api/?name='.urlencode($record->initials_display).'&size=40&background=dbeafe&color=1d4ed8'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('section')
                    ->label('Seksi')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'keynote' => 'Keynote',
                        'scientific' => 'Scientific',
                        'handson' => 'Hands-on',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('title')
                    ->label('Gelar')
                    ->limit(30),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('section')
                    ->label('Seksi')
                    ->options([
                        'keynote' => 'Keynote',
                        'scientific' => 'Scientific',
                        'handson' => 'Hands-on',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpeakers::route('/'),
            'create' => Pages\CreateSpeaker::route('/create'),
            'edit' => Pages\EditSpeaker::route('/{record}/edit'),
        ];
    }
}
