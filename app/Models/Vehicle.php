<?php

namespace App\Models;

use App\Models\Schedule;
use App\Models\DeliveryOrder;
use App\Models\VehicleMaintenance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'brand',
        'type',
        'capacity',
        'status',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }


    public function deliveryOrders()
    {
        return $this->hasMany(DeliveryOrder::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isOnTrip(): bool
    {
        return $this->status === 'on_trip';
    }

}