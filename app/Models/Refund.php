<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Mail\RefundApprovedMail;
use Illuminate\Support\Facades\Mail;



class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'refund_date_time',
        'status',
        'total_payment',
        'validation_image',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function calculateRefundAmount()
    {
        $booking = $this->booking;
        $refundAmount = $booking->total_payment * 0.80; // Potongan 20%
        return $refundAmount;
    }

    protected static function booted()
{
    static::updated(function ($refund) {
        if ($refund->wasChanged('status') && $refund->status === 'approved') {
            $user = $refund->booking->user;
            if ($user) {
                // Jika RefundApprovedMail adalah Mailable
                Mail::to($user->email)->send(new RefundApprovedMail($refund));

                // Jika RefundApprovedMail adalah Notification
                // $user->notify(new RefundApprovedNotification($refund));
            }

            // Menghapus booking terkait
            $booking = $refund->booking;
            if ($booking) {
                $booking->delete();
            }
        }
    });
}
}

