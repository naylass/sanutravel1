<?php

namespace App\Filament\Admin\Resources\Notifications\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class NotificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('booking_id')
                    ->numeric(),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                Select::make('type')
                    ->options(['booking' => 'Booking', 'payment' => 'Payment', 'reminder' => 'Reminder', 'cancel' => 'Cancel'])
                    ->required(),
                Select::make('status')
                    ->options(['unread' => 'Unread', 'read' => 'Read'])
                    ->default('unread')
                    ->required(),
            ]);
    }
}
