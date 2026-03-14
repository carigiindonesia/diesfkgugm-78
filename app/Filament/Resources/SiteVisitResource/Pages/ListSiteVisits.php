<?php

namespace App\Filament\Resources\SiteVisitResource\Pages;

use App\Filament\Resources\SiteVisitResource;
use App\Filament\Widgets\TrafficStatsOverview;
use Filament\Resources\Pages\ListRecords;

class ListSiteVisits extends ListRecords
{
    protected static string $resource = SiteVisitResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            TrafficStatsOverview::class,
        ];
    }
}
