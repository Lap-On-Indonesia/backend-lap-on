<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Transaction;

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

        // Generate Booking ID dan hitung total_payment saat creating
        static::creating(function ($booking) {
            if (empty($booking->booking_id)) {
                $booking->booking_id = $booking->generateBookingId();
            }

            if (empty($booking->total_payment)) {
                $booking->total_payment = $booking->calculateTotalPayment();
            }
        });

        // Buat Transaction otomatis setelah Booking berhasil dibuat
        static::created(function ($booking) {
            Transaction::create([
                'user_id' => $booking->user_id,
                'venue_id' => $booking->venue_id,
                'booking_id' => $booking->id,
                'total' => $booking->total_payment,
                'status' => 'pending', // Set default status
                'payment_url' => null, // Jika nanti Anda integrasi dengan Midtrans, bisa diisi dengan payment URL
                'tax_percentage' => 11,
            ]);
        });
    }

    // Function untuk menghitung total_payment
    private function calculateTotalPayment()
    {
        $durationInHours = Carbon::parse($this->end_time)->diffInHours(Carbon::parse($this->start_time));
        $total = $durationInHours * $this->venue->price;
        $tax = $total * (11 / 100);
        return $total + $tax;
    }

    // Function untuk generate Booking ID
    private function generateBookingId()
    {
        do {
            $bookingId = 'BK-' . strtoupper(substr(md5(rand()), 0, 6));
        } while (self::where('booking_id', $bookingId)->exists());

        return $bookingId;
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Venue
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
