<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Venue;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function getAvailableSchedules(Venue $venue, Request $request)
    {
        try {
            // Dapatkan hari dalam seminggu dari tanggal yang dipilih
            $dayOfWeek = strtolower($request->input('date')->format('l')); // Contoh output: 'monday', 'saturday'

            // Ambil semua jadwal yang tersedia pada hari tersebut untuk venue yang dipilih
            $schedules = Schedule::where('venue_id', $venue->id)
                ->where('day_of_week', $dayOfWeek)
                ->where('is_available', true)
                ->get();

            // Ambil booking untuk venue tersebut pada tanggal yang dipilih
            $bookedSlots = Booking::where('venue_id', $venue->id)
                ->where('booking_date', $request->input('date'))
                ->get();

            // Loop melalui jadwal dan cek apakah ada yang sudah di-booking
            $schedules = $schedules->map(function ($schedule) use ($bookedSlots) {
                $isBooked = $bookedSlots->some(function ($booking) use ($schedule) {
                    return $booking->start_time < $schedule->end_time && $booking->end_time > $schedule->start_time;
                });

                $schedule->is_booked = $isBooked;

                return $schedule;
            });

            return response()->json($schedules);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve schedules',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
