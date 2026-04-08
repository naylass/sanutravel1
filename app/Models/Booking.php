<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use App\Models\Payment;
use App\Models\DeliveryOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'booking_code',
        'pickup_time',
        'phone_number',
        'pickup_location',
        'total_passengers',
        'destination',
        'price',
        'status',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function deliveryOrder()
    {
        return $this->hasOne(DeliveryOrder::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }
}