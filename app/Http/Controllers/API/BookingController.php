<?php

namespace App\Http\Controllers\API;


use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return ResponseFormatter::success($bookings, 'Bookings retrieved successfully');
    }

    public function store(Request $request)
    {
        // dd($request);
        try {
            // Mendapatkan userId dari Bearer token
            $userId = Auth::id();

            // Validasi data request
            $request->validate([
                'venue_id' => 'required|exists:venues,id',
                'category_id' => 'required|exists:categories,id',
                'booking_date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i',
                'tax_percentage' => 'required|numeric',
                'total_payment' => 'required|numeric',
            ]);

            // Menggabungkan userId ke dalam request data
            $data = $request->all();
            $data['user_id'] = $userId;

            // Membuat booking
            $booking = Booking::create($data);

            // return ResponseFormatter::success($booking, 'Booking created successfully', 201);
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Berhasil mendapatkan semua booking',
                'data' => $booking,
            ]);
        } catch (\Exception $e) {
            // Menangani error lainnya
            // return ResponseFormatter::error(null, 'Failed to create booking: ' . $e->getMessage(), 500);

            return response()->json([
                'code' => 500,
                'status' => 'failed',
                'message' => 'Berhasil mendapatkan semua booking',
            ]);
        }
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
