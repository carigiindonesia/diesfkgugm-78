<?php

namespace App\Filament\Resources\EventPriceResource\Pages;

use App\Filament\Resources\EventPriceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventPrice extends EditRecord
{
    protected static string $resource = EventPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
