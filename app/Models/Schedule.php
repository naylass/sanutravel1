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
        'departure_date',
        'departure_time',
        'pickup_point',
        'destination',
        'available_seats',
    ];

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

    public function remainingSeats(): int
    {
        $used = $this->bookings()->sum('total_passengers');
        return $this->vehicle->capacity - $used;
    }

    public function isFull(): bool
    {
        return $this->remainingSeats() <= 0;
    }
}
