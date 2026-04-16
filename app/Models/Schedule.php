<?php

namespace App\Models;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'booking_id',
        'departure_date',
        'departure_time',
        'pickup_point',
        'destination',
        'available_seats',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
  
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }


    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function deliveryOrders()
    {
        return $this->hasOne(DeliveryOrder::class);
    }

    public function hasAvailableSeats(int $total): bool
    {
        return $this->available_seats >= $total;
    }

}