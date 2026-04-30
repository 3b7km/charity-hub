<?php

namespace App\Filament\Resources\ImpactReports\Pages;

use App\Filament\Resources\ImpactReports\ImpactReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListImpactReports extends ListRecords
{
    protected static string $resource = ImpactReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
