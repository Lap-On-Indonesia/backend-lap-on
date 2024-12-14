<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
            $booking->booking_id = self::generateBookingId();
        }
    });
}

public static function generateBookingId()
{
    do {
        $bookingId = strtoupper(Str::random(9)); // Generate string acak 9 karakter
    } while (self::where('booking_id', $bookingId)->exists()); // Pastikan ID unik

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

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
}
