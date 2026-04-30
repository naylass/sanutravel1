<?php

namespace App\Filament\Admin\Resources\Drivers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class DriverForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('photo')
                    ->label('Foto Driver')
                    ->image(),

                TextInput::make('name')
                    ->label('Nama')
                    ->required(),

                TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),

                TextInput::make('birth_place')
                    ->label('Tempat Lahir')
                    ->required(),

                DatePicker::make('birth_date')
                    ->label('Tanggal Lahir')
                    ->required(),

                Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->required(),

                Textarea::make('address')
                    ->label('Alamat')
                    ->columnSpanFull(),

                Textarea::make('medical_history')
                    ->label('Riwayat Kesehatan')
                    ->columnSpanFull(),

                TextInput::make('license_number')
                    ->label('Nomor SIM')
                    ->required(),
            ]);
    }
}