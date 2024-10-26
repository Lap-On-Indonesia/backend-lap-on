<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerMarketplace extends Model
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
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
