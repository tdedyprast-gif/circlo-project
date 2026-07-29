<?php

namespace App\Filament\Resources\MaterialProgress;

use App\Filament\Resources\MaterialProgress\Pages\CreateMaterialProgress;
use App\Filament\Resources\MaterialProgress\Pages\EditMaterialProgress;
use App\Filament\Resources\MaterialProgress\Pages\ListMaterialProgress;
use App\Filament\Resources\MaterialProgress\Pages\ViewMaterialProgress;
use App\Filament\Resources\MaterialProgress\Schemas\MaterialProgressForm;
use App\Filament\Resources\MaterialProgress\Schemas\MaterialProgressInfolist;
use App\Filament\Resources\MaterialProgress\Tables\MaterialProgressTable;
use App\Models\MaterialProgress;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MaterialProgressResource extends Resource
{
    protected static ?string $model = MaterialProgress::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowTrendingUp;

    protected static ?string $recordTitleAttribute = 'material-progress';

    protected static \UnitEnum|string|null $navigationGroup = 'Progess';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return MaterialProgressForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MaterialProgressInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaterialProgressTable::configure($table);
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
            'index' => ListMaterialProgress::route('/'),
            'create' => CreateMaterialProgress::route('/create'),
            'view' => ViewMaterialProgress::route('/{record}'),
            'edit' => EditMaterialProgress::route('/{record}/edit'),
        ];
    }
}
