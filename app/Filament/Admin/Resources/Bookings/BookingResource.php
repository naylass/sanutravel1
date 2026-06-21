<?php

namespace App\Filament\Admin\Resources\Bookings;

use App\Filament\Admin\Resources\Bookings\Pages\CreateBooking;
use App\Filament\Admin\Resources\Bookings\Pages\EditBooking;
use App\Filament\Admin\Resources\Bookings\Pages\ListBookings;
use App\Filament\Admin\Resources\Bookings\Pages\ViewBooking;
use App\Filament\Admin\Resources\Bookings\Schemas\BookingForm;
use App\Filament\Admin\Resources\Bookings\Schemas\BookingInfolist;
use App\Filament\Admin\Resources\Bookings\Tables\BookingsTable;
use App\Models\Booking;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $pluralModelLabel = 'Pemesanan';
    protected static string|UnitEnum|null $navigationGroup = 'Operasional';

    protected static ?string $recordTitleAttribute = 'Booking';

    public static function form(Schema $schema): Schema
    {
        return BookingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BookingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingsTable::configure($table);
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
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'view' => ViewBooking::route('/{record}'),
            'edit' => EditBooking::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // 🔒 kalau bukan admin → hanya lihat booking sendiri
        if (!Auth::user()->hasRole('admin')) {
            $query->where('user_id', Auth::id());
        }

        return $query;
    }

    public static function canViewAny(): bool
    {
        return Auth::user()->hasAnyRole([
            'admin',
            'customer',
        ]);
    }

    public static function canView($record): bool
    {
        return Auth::user()->hasRole('admin') ||
            $record->user_id === Auth::id();
    }

    public static function canCreate(): bool
    {
        return Auth::user()->hasAnyRole([
            'customer'
        ]);
    }
}
