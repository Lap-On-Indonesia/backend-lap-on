<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo_profile',
        'photo_ktp',
        'no_rekening',
        'store_name',
        'store_address',
        'photo_store',
        'link_maps',
        'status'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function venue()
    {
        return $this->hasMany(Venue::class);
    }

    // public function schedule()
    // {
    //     return $this->hasMany(Schedule::class);
    // }

    // public function booking()
    // {
    //     return $this->hasMany(Booking::class);
    // }
}
