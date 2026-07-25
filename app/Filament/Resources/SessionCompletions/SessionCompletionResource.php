<?php

namespace App\Filament\Resources\SessionCompletions;

use App\Filament\Resources\SessionCompletions\Pages\CreateSessionCompletion;
use App\Filament\Resources\SessionCompletions\Pages\EditSessionCompletion;
use App\Filament\Resources\SessionCompletions\Pages\ListSessionCompletions;
use App\Filament\Resources\SessionCompletions\Pages\ViewSessionCompletion;
use App\Filament\Resources\SessionCompletions\Schemas\SessionCompletionForm;
use App\Filament\Resources\SessionCompletions\Schemas\SessionCompletionInfolist;
use App\Filament\Resources\SessionCompletions\Tables\SessionCompletionsTable;
use App\Models\SessionCompletion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SessionCompletionResource extends Resource
{
    protected static ?string $model = SessionCompletion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'session-completion';

    public static function form(Schema $schema): Schema
    {
        return SessionCompletionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SessionCompletionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SessionCompletionsTable::configure($table);
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
            'index' => ListSessionCompletions::route('/'),
            'create' => CreateSessionCompletion::route('/create'),
            'view' => ViewSessionCompletion::route('/{record}'),
            'edit' => EditSessionCompletion::route('/{record}/edit'),
        ];
    }
}
