<?php

namespace App\Filament\Admin\Resources\DeliveryOrders;

use App\Filament\Admin\Resources\DeliveryOrders\Pages\CreateDeliveryOrder;
use App\Filament\Admin\Resources\DeliveryOrders\Pages\EditDeliveryOrder;
use App\Filament\Admin\Resources\DeliveryOrders\Pages\ListDeliveryOrders;
use App\Filament\Admin\Resources\DeliveryOrders\Pages\ViewDeliveryOrder;
use App\Filament\Admin\Resources\DeliveryOrders\Schemas\DeliveryOrderForm;
use App\Filament\Admin\Resources\DeliveryOrders\Schemas\DeliveryOrderInfolist;
use App\Filament\Admin\Resources\DeliveryOrders\Tables\DeliveryOrdersTable;
use App\Models\DeliveryOrder;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeliveryOrderResource extends Resource
{
    protected static ?string $model = DeliveryOrder::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $pluralModelLabel = 'Surat Jalan';
    protected static string|UnitEnum|null $navigationGroup = 'Operasional';
    protected static ?string $recordTitleAttribute = 'DeliveryOrder';

    public static function form(Schema $schema): Schema
    {
        return DeliveryOrderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DeliveryOrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeliveryOrdersTable::configure($table);
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
            'index' => ListDeliveryOrders::route('/'),
            'create' => CreateDeliveryOrder::route('/create'),
            'view' => ViewDeliveryOrder::route('/{record}'),
            'edit' => EditDeliveryOrder::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasAnyRole([
            'admin',
            'driver',
        ]);
    }
}
