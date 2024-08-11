<?php

namespace App\Http\Controllers\API;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return ResponseFormatter::success($bookings, 'Bookings retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'venue_id' => 'required|exists:venues,id',
            'category_id' => 'required|exists:categories,id',
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'tax_percentage' => 'required|numeric',
            'total_payment' => 'required|numeric',
        ]);

        $booking = Booking::create($request->all());

        return ResponseFormatter::success($booking, 'Booking created successfully', 201);
    }

    public function show($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return ResponseFormatter::error('Booking not found', null, 404);
        }

        return ResponseFormatter::success($booking, 'Booking retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return ResponseFormatter::error('Booking not found', null, 404);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'venue_id' => 'required|exists:venues,id',
            'category_id' => 'required|exists:categories,id',
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'tax_percentage' => 'required|numeric',
            'total_payment' => 'required|numeric',
        ]);

        $booking->update($request->all());

        return ResponseFormatter::success($booking, 'Booking updated successfully');
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return ResponseFormatter::error('Booking not found', null, 404);
        }

        $booking->delete();

        return ResponseFormatter::success(null, 'Booking deleted successfully');
    }
}
