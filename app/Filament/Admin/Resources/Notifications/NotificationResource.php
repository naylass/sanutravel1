<?php

namespace App\Filament\Admin\Resources\Notifications;

use App\Filament\Admin\Resources\Notifications\Pages\CreateNotification;
use App\Filament\Admin\Resources\Notifications\Pages\EditNotification;
use App\Filament\Admin\Resources\Notifications\Pages\ListNotifications;
use App\Filament\Admin\Resources\Notifications\Pages\ViewNotification;
use App\Filament\Admin\Resources\Notifications\Schemas\NotificationForm;
use App\Filament\Admin\Resources\Notifications\Schemas\NotificationInfolist;
use App\Filament\Admin\Resources\Notifications\Tables\NotificationsTable;
use App\Models\Notification;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bell';
    protected static ?string $pluralModelLabel = 'Notifikasi';
    protected static string | UnitEnum | null $navigationGroup = 'Notifikasi';
    protected static ?string $recordTitleAttribute = 'Notification';

    public static function form(Schema $schema): Schema
    {
        return NotificationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NotificationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NotificationsTable::configure($table);
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
            'index' => ListNotifications::route('/'),
            'create' => CreateNotification::route('/create'),
            'view' => ViewNotification::route('/{record}'),
            'edit' => EditNotification::route('/{record}/edit'),
        ];
    }
}
