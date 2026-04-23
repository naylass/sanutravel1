<?php

namespace App\Filament\Admin\Resources\Bookings\Pages;

use App\Filament\Admin\Resources\Bookings\BookingResource;
use App\Models\Service;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

        protected function mutateFormDataBeforeSave(array $data): array
        {
            $service = Service::find($data['service_id'] ?? null);
    
            if ($service) {
                if (strtolower($service->name) === 'reguler') {
                    $data['pickup_type'] = 'reguler';
                } elseif (strtolower($service->name) === 'eksklusif') {
                    $data['pickup_type'] = 'eksklusif';
                }
            }
    
            return $data;
        }
}
