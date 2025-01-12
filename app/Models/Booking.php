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
        'total_payment',
        'booking_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_id)) {
                $booking->booking_id = $booking->generateBookingId();
            }
        });
    }

    private function generateBookingId()
    {
        do {
            $bookingId = 'BK-' . strtoupper(substr(md5(rand()), 0, 6));
        } while (self::where('booking_id', $bookingId)->exists());

        return $bookingId;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
