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
        'password',
    ];

    public function venue()
    {
        return $this->hasMany(Venue::class);
    }
}
