<?php

namespace App\Filament\Resources\Grants;

use App\Filament\Resources\Grants\Pages\CreateGrant;
use App\Filament\Resources\Grants\Pages\EditGrant;
use App\Filament\Resources\Grants\Pages\ListGrants;
use App\Filament\Resources\Grants\Pages\ViewGrant;
use App\Filament\Resources\Grants\Schemas\GrantForm;
use App\Filament\Resources\Grants\Schemas\GrantInfolist;
use App\Filament\Resources\Grants\Tables\GrantsTable;
use App\Models\Grant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GrantResource extends Resource
{
    protected static ?string $model = Grant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;

    protected static \UnitEnum|string|null $navigationGroup = 'Grant';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'Program';

    public static function form(Schema $schema): Schema
    {
        return GrantForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GrantInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GrantsTable::configure($table);
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
            'index' => ListGrants::route('/'),
            'create' => CreateGrant::route('/create'),
            'view' => ViewGrant::route('/{record}'),
            'edit' => EditGrant::route('/{record}/edit'),
        ];
    }
}
