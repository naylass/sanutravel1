<?php

namespace App\Filament\Admin\Resources\Payments\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('booking_id')
                    ->numeric(),
                TextEntry::make('transaction_code'),
                TextEntry::make('payment_method'),
                TextEntry::make('payment_date')
                    ->dateTime(),
                TextEntry::make('amount')
                    ->numeric(),
                ImageEntry::make('proof_image'),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
