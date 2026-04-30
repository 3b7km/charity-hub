<?php

namespace App\Filament\Resources\ImpactReports\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ImpactReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('campaign_id')
                    ->relationship('campaign', 'title')
                    ->required(),
                TextInput::make('beneficiary_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('locations')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('summary')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('published_at'),
                TextInput::make('pdf_path')
                    ->default(null),
            ]);
    }
}
