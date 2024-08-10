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
        'category_id',
        'booking_date',
        'start_time',
        'end_time',
        'tax_percentage',
        'total_payment'
    ];
}
