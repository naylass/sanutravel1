<?php

namespace App\Filament\Admin\Resources\DeliveryOrders\Pages;

use App\Filament\Admin\Resources\DeliveryOrders\DeliveryOrderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDeliveryOrder extends ViewRecord
{
    protected static string $resource = DeliveryOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
