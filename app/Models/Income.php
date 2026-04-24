<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'amount',
        'income_type',
        'income_date',
        'description',
    ];

    // 🔗 RELASI KE PAYMENT
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // 📊 CHECK TYPE
    public function isBookingIncome(): bool
    {
        return $this->income_type === 'booking';
    }

    public function isOtherIncome(): bool
    {
        return $this->income_type === 'other';
    }
}