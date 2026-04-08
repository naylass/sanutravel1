<?php

namespace App\Models;

use App\Models\Booking;
use App\Models\Income;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi
     */
    protected $fillable = [
        'booking_id',
        'payment_method',
        'payment_date',
        'amount',
        'proof_image',
        'status',
    ];


    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    
    public function income()
    {
        return $this->hasOne(Income::class);
    }

    

    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    public function isWaiting(): bool
    {
        return $this->status === 'waiting';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public static function generateTransactionCode(): string
    {
        return 'PAY-' . now()->format('YmdHis') . '-' . rand(100, 999);
    }

}
