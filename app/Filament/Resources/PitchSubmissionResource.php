<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PitchSubmissionResource\Pages;
use App\Models\PitchSubmission;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PitchSubmissionResource extends Resource
{
    protected static ?string $model = PitchSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    protected static ?string $navigationGroup = 'Kompetisi';

    protected static ?string $navigationLabel = '3MPC Submissions';

    protected static ?string $modelLabel = 'Submission';

    protected static ?string $pluralModelLabel = '3MPC Submissions';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('submission_number')
                    ->label('Nomor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('authors')
                    ->label('Penulis')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('lembaga')
                    ->label('Lembaga')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'original_article' => 'Original Article',
                        'case_report' => 'Case Report',
                        'review' => 'Review',
                        default => $state ?? '-',
                    })
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'submitted' => 'info',
                        'reviewing' => 'warning',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dikirim')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'submitted' => 'Submitted',
                        'reviewing' => 'Reviewing',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'original_article' => 'Original Article',
                        'case_report' => 'Case Report',
                        'review' => 'Review',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('updateStatus')
                    ->label('Ubah Status')
                    ->icon('heroicon-o-pencil-square')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->options([
                                'submitted' => 'Submitted',
                                'reviewing' => 'Reviewing',
                                'accepted' => 'Accepted',
                                'rejected' => 'Rejected',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Catatan Admin'),
                    ])
                    ->fillForm(fn (PitchSubmission $record) => [
                        'status' => $record->status,
                        'admin_notes' => $record->admin_notes,
                    ])
                    ->action(function (PitchSubmission $record, array $data) {
                        $record->update($data);
                    }),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Detail Submission')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('submission_number')->label('Nomor'),
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state) => match ($state) {
                                'submitted' => 'info',
                                'reviewing' => 'warning',
                                'accepted' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('authors')->label('Penulis')->columnSpanFull(),
                        Infolists\Components\TextEntry::make('lembaga')->label('Lembaga'),
                        Infolists\Components\TextEntry::make('kategori')
                            ->label('Kategori')
                            ->formatStateUsing(fn (?string $state) => match ($state) {
                                'original_article' => 'Original Article',
                                'case_report' => 'Case Report',
                                'review' => 'Review',
                                default => $state ?? '-',
                            }),
                        Infolists\Components\TextEntry::make('judul')->label('Judul')->columnSpanFull(),
                        Infolists\Components\TextEntry::make('abstract_link')
                            ->label('Link Abstrak')
                            ->url(fn ($record) => $record->abstract_link, true),
                        Infolists\Components\TextEntry::make('video_link')
                            ->label('Link Video')
                            ->url(fn ($record) => $record->video_link, true)
                            ->visible(fn ($record) => $record->video_link),
                        Infolists\Components\TextEntry::make('admin_notes')
                            ->label('Catatan Admin')
                            ->columnSpanFull()
                            ->visible(fn ($record) => $record->admin_notes),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPitchSubmissions::route('/'),
            'view' => Pages\ViewPitchSubmission::route('/{record}'),
        ];
    }
}
