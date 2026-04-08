<?php

namespace App\Models;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'booking_id',
        'message',
        'type',
        'status',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }


    public function isUnread(): bool
    {
        return $this->status === 'unread';
    }

    public function isRead(): bool
    {
        return $this->status === 'read';
    }


    public function isBooking(): bool
    {
        return $this->type === 'booking';
    }

    public function isPayment(): bool
    {
        return $this->type === 'payment';
    }

    public function isReminder(): bool
    {
        return $this->type === 'reminder';
    }
}