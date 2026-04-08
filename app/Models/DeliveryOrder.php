<?php

namespace App\Models;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'driver_id',
        'vehicle_id',
        'schedule_id',
        'departure_datetime',
        'pickup_point',
        'destination',
        'status',
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

    
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }


    public function isPrepared(): bool
    {
        return $this->status === 'prepared';
    }

    public function isOngoing(): bool
    {
        return $this->status === 'ongoing';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }
}
