<?php

namespace App\Filament\Resources\ImpactReports;

use App\Filament\Resources\ImpactReports\Pages\CreateImpactReport;
use App\Filament\Resources\ImpactReports\Pages\EditImpactReport;
use App\Filament\Resources\ImpactReports\Pages\ListImpactReports;
use App\Filament\Resources\ImpactReports\Schemas\ImpactReportForm;
use App\Filament\Resources\ImpactReports\Tables\ImpactReportsTable;
use App\Models\ImpactReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ImpactReportResource extends Resource
{
    protected static ?string $model = ImpactReport::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static \UnitEnum|string|null $navigationGroup = 'Impact';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ImpactReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ImpactReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListImpactReports::route('/'),
            'create' => CreateImpactReport::route('/create'),
            'edit' => EditImpactReport::route('/{record}/edit'),
        ];
    }
}
