<?php

namespace App\Models;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'owner_id',
        'name',
        'description',
        'image',
        'address',
        'link_maps',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }
}
