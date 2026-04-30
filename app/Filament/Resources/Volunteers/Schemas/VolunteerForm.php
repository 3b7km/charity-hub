<?php

namespace App\Filament\Resources\Volunteers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VolunteerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Textarea::make('skills')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('availability')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('total_hours')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                DateTimePicker::make('verified_at'),
                Textarea::make('emergency_contact')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
