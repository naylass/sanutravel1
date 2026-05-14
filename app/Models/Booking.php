<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\Payment;
use App\Models\DeliveryOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'email',
        'service_id',
        'schedule_id',
        'booking_code',
        'pickup_date',
        'pickup_time',
        'phone_number',
        'pickup_location',
        'total_passengers',
        'destination',
        'base_price',
        'pickup_fee',
        'total_price',
        'status',
        'area',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function deliveryOrder()
    {
        return $this->hasOne(DeliveryOrder::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function isPaid(): bool
    {
        return $this->payment?->status === 'verified';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }
}