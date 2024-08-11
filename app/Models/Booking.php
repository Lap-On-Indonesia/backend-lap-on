<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'venue_id',
        'booking_date',
        'start_time',
        'end_time',
        'tax_percentage',
        'total_payment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the venue that owns the booking.
     */
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
