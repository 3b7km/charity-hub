<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampaignResource\Pages;
use App\Models\Campaign;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-megaphone';

    protected static \UnitEnum|string|null $navigationGroup = 'Campaign Management';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make('Campaign Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true),

                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->dehydrated(true)
                            ->helperText('Auto-generated from title'),

                        Forms\Components\RichEditor::make('description')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Section::make('Funding & Timeline')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('goal_amount')
                            ->required()
                            ->numeric()
                            ->prefix('£')
                            ->helperText('Enter amount in pence (e.g. 10000 = £100.00)')
                            ->minValue(100),

                        Forms\Components\TextInput::make('raised_amount')
                            ->numeric()
                            ->prefix('£')
                            ->disabled()
                            ->default(0),

                        Forms\Components\DatePicker::make('start_date')
                            ->required()
                            ->native(false),

                        Forms\Components\DatePicker::make('end_date')
                            ->required()
                            ->native(false)
                            ->after('start_date'),
                    ]),

                \Filament\Schemas\Components\Section::make('Status & Media')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Active',
                                'paused' => 'Paused',
                                'closed' => 'Closed',
                            ])
                            ->required()
                            ->default('active'),

                        \Filament\Forms\Components\FileUpload::make('featured_image')
                            ->disk('public')
                            ->directory('campaign-images')
                            ->image()
                            ->maxSize(5120)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'active',
                        'warning' => 'paused',
                        'danger' => 'closed',
                    ]),

                Tables\Columns\TextColumn::make('formatted_goal')
                    ->label('Goal'),

                Tables\Columns\TextColumn::make('formatted_raised')
                    ->label('Raised'),

                Tables\Columns\TextColumn::make('progress_percentage')
                    ->label('Progress')
                    ->suffix('%')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('confirmed_donations_count')
                    ->counts('confirmedDonations')
                    ->label('Donations'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'paused' => 'Paused',
                        'closed' => 'Closed',
                    ]),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}
