<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_id',
        'name',
        'description',
        'price',
        'image'
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
