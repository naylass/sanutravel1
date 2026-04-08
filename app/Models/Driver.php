<?php

namespace App\Models;

use App\Models\User;
use App\Models\Schedule;
use App\Models\DeliveryOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo',
        'name',
        'phone',
        'birth_place',
        'birth_date',
        'gender',
        'address',
        'medical_history',
        'license_number',
        'status',
    ];

    protected $attributes = [
        'status' => 'available',
    ];
    
    protected $casts = [
        'birth_date' => 'date',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function deliveryOrders()
    {
        return $this->hasMany(DeliveryOrder::class);
    }
}
