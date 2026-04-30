<?php

namespace App\Filament\Resources\ImpactReports\Pages;

use App\Filament\Resources\ImpactReports\ImpactReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditImpactReport extends EditRecord
{
    protected static string $resource = ImpactReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
