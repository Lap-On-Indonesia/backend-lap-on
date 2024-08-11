<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterOwnerMarketplace extends Model
{
    use HasFactory;

    protected $table = 'register_owner_marketplace';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo_profile',
        'photo_ktp',
        'password',
    ];

    // Mutator untuk enkripsi password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}

