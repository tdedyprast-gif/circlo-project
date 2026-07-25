<?php

namespace App\Filament\Resources\CourseSessions;

use App\Filament\Resources\CourseSessions\Pages\CreateCourseSession;
use App\Filament\Resources\CourseSessions\Pages\EditCourseSession;
use App\Filament\Resources\CourseSessions\Pages\ListCourseSessions;
use App\Filament\Resources\CourseSessions\Pages\ViewCourseSession;
use App\Filament\Resources\CourseSessions\Schemas\CourseSessionForm;
use App\Filament\Resources\CourseSessions\Schemas\CourseSessionInfolist;
use App\Filament\Resources\CourseSessions\Tables\CourseSessionsTable;
use App\Models\CourseSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourseSessionResource extends Resource
{
    protected static ?string $model = CourseSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $recordTitleAttribute = 'courses-session';


    protected static \UnitEnum|string|null $navigationGroup = 'Course';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return CourseSessionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CourseSessionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseSessionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MaterialsRelationManager::class,
            RelationManagers\AssignmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourseSessions::route('/'),
            'create' => CreateCourseSession::route('/create'),
            'view' => ViewCourseSession::route('/{record}'),
            'edit' => EditCourseSession::route('/{record}/edit'),
        ];
    }
}
