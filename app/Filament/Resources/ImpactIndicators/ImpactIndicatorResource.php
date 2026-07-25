<?php

namespace App\Filament\Resources\ImpactIndicators;

use App\Filament\Resources\ImpactIndicators\Pages\CreateImpactIndicator;
use App\Filament\Resources\ImpactIndicators\Pages\EditImpactIndicator;
use App\Filament\Resources\ImpactIndicators\Pages\ListImpactIndicators;
use App\Filament\Resources\ImpactIndicators\Pages\ViewImpactIndicator;
use App\Filament\Resources\ImpactIndicators\Schemas\ImpactIndicatorForm;
use App\Filament\Resources\ImpactIndicators\Schemas\ImpactIndicatorInfolist;
use App\Filament\Resources\ImpactIndicators\Tables\ImpactIndicatorsTable;
use App\Models\ImpactIndicator;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ImpactIndicatorResource extends Resource
{
    protected static ?string $model = ImpactIndicator::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartBarSquare;

    protected static \UnitEnum|string|null $navigationGroup = 'Audit';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'impact_indicator';

    public static function form(Schema $schema): Schema
    {
        return ImpactIndicatorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ImpactIndicatorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ImpactIndicatorsTable::configure($table);
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
            'index' => ListImpactIndicators::route('/'),
            'create' => CreateImpactIndicator::route('/create'),
            'view' => ViewImpactIndicator::route('/{record}'),
            'edit' => EditImpactIndicator::route('/{record}/edit'),
        ];
    }
}
