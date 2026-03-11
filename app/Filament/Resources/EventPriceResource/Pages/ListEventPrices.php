<?php

namespace App\Filament\Resources\EventPriceResource\Pages;

use App\Filament\Resources\EventPriceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventPrices extends ListRecords
{
    protected static string $resource = EventPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
