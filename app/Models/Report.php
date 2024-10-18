<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Tambahkan relasi belongsTo ke Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Tambahkan relasi belongsTo ke Venue (jika venue juga perlu dihubungkan)
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
