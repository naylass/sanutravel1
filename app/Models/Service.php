<?php

namespace App\Models;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
    ];

    
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }


    public function isReguler(): bool
    {
        return strtolower($this->name) === 'reguler';
    }

    public function isEksklusif(): bool
    {
        return strtolower($this->name) === 'eksklusif';
    }
}
