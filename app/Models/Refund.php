<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    // Kolom-kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'booking_id',
        'refund_date_time',
        'status',
        'total_payment',
        'validation_image',
    ];

    // Definisikan relasi ke model Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
