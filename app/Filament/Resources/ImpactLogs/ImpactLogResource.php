<?php

namespace App\Filament\Resources\ImpactLogs;

use App\Filament\Resources\ImpactLogs\Pages\CreateImpactLog;
use App\Filament\Resources\ImpactLogs\Pages\EditImpactLog;
use App\Filament\Resources\ImpactLogs\Pages\ListImpactLogs;
use App\Filament\Resources\ImpactLogs\Pages\ViewImpactLog;
use App\Filament\Resources\ImpactLogs\Schemas\ImpactLogForm;
use App\Filament\Resources\ImpactLogs\Schemas\ImpactLogInfolist;
use App\Filament\Resources\ImpactLogs\Tables\ImpactLogsTable;
use App\Models\ImpactLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ImpactLogResource extends Resource
{
    protected static ?string $model = ImpactLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    protected static \UnitEnum|string|null $navigationGroup = 'Audit';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'impact_log';

    public static function form(Schema $schema): Schema
    {
        return ImpactLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ImpactLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ImpactLogsTable::configure($table);
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
            'index' => ListImpactLogs::route('/'),
            'create' => CreateImpactLog::route('/create'),
            'view' => ViewImpactLog::route('/{record}'),
            'edit' => EditImpactLog::route('/{record}/edit'),
        ];
    }
}
