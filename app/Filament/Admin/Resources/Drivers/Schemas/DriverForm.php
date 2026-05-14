<?php

namespace App\Filament\Admin\Resources\Drivers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DriverForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            FileUpload::make('photo')
                ->label('Foto Driver')
                ->image()
                ->avatar()
                ->imageEditor()
                ->imageEditorAspectRatios([
                    '1:1',
                ])
                ->directory('drivers')
                ->maxSize(2048)
                ->downloadable(false)
                ->openable(),

            Section::make('Data Identitas')
                ->schema([

                    Grid::make(2)
                        ->schema([

                            TextInput::make('name')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255),

                            Select::make('gender')
                                ->label('Jenis Kelamin')
                                ->options([
                                    'male' => 'Laki-laki',
                                    'female' => 'Perempuan',
                                ])
                                ->required(),
                        ]),

                    Grid::make(2)
                        ->schema([

                            TextInput::make('birth_place')
                                ->label('Tempat Lahir')
                                ->required(),

                            DatePicker::make('birth_date')
                                ->label('Tanggal Lahir')
                                ->required(),
                        ]),
                ]),

            Section::make('Kontak')
                ->schema([

                    Grid::make(2)
                        ->schema([

                            TextInput::make('phone')
                                ->label('Nomor Telepon')
                                ->tel()
                                ->required(),

                            TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required(),
                        ]),

                    TextInput::make('license_number')
                        ->label('Nomor SIM')
                        ->required(),
                ]),

            Section::make('Informasi Tambahan')
                ->schema([

                    Textarea::make('address')
                        ->label('Alamat')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('medical_history')
                        ->label('Riwayat Kesehatan')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
