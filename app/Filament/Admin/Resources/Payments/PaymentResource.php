<?php

namespace App\Filament\Admin\Resources\Payments;

use App\Filament\Admin\Resources\Payments\Pages\CreatePayment;
use App\Filament\Admin\Resources\Payments\Pages\EditPayment;
use App\Filament\Admin\Resources\Payments\Pages\ListPayments;
use App\Filament\Admin\Resources\Payments\Pages\ViewPayment;
use App\Filament\Admin\Resources\Payments\Schemas\PaymentForm;
use App\Filament\Admin\Resources\Payments\Schemas\PaymentInfolist;
use App\Filament\Admin\Resources\Payments\Tables\PaymentsTable;
use App\Models\Payment;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $pluralModelLabel = 'Pembayaran';
    protected static string | UnitEnum | null $navigationGroup = 'Keuangan';
    protected static ?string $recordTitleAttribute = 'Payment';

    public static function form(Schema $schema): Schema
    {
        return PaymentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PaymentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PaymentsTable::configure($table);
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
            'index' => ListPayments::route('/'),
            'create' => CreatePayment::route('/create'),
            'view' => ViewPayment::route('/{record}'),
            'edit' => EditPayment::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // kalau bukan admin → hanya lihat pembayaran sendiri
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
