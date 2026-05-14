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
        'transfer_info',
        'payment_date',
        'amount',
        'payment_proof',
        'driver_proof',
        'paid_at',
        'verified_at',
        'driver_received_cash',
        'driver_received_at',
        'settled_to_admin_at',
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

    public function isWaitingVerification(): bool
    {
        return $this->status === 'waiting_verification';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isCashWaiting(): bool
    {
        return $this->status === 'waiting_driver_collection';
    }

    public function isCashReceived(): bool
    {
        return $this->status === 'cash_received';
    }

    public function isSettled(): bool
    {
        return $this->status === 'settled';
    }
}
