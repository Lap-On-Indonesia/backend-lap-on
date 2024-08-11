<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function getAvailableSchedules(Venue $venue, Request $request)
    {
        try {
            // Konversi tanggal ke instance Carbon dan dapatkan hari dalam seminggu
            $dayOfWeek = Carbon::parse($request->input('date'))->format('l'); // Contoh output: 'Monday'

            // Ambil semua jadwal yang tersedia pada hari tersebut untuk venue yang dipilih
            $schedules = Schedule::where('venue_id', $venue->id)
                ->where('day_of_week', strtolower($dayOfWeek)) // Gunakan lowercase untuk keseragaman
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

            // Menyertakan informasi venue bersama dengan jadwal yang tersedia
            $response = [
                'venue' => [
                    'id' => $venue->id,
                    'name' => $venue->name,
                    'address' => $venue->address,
                    'description' => $venue->description,
                    'opening_time' => $venue->opening_time,
                    'closing_time' => $venue->closing_time,
                ],
                'schedules' => $schedules,
            ];

            return ResponseFormatter::success($response, 'Schedules retrieved successfully');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Failed to retrieve schedules: ' . $e->getMessage(), 500);
        }
    }
}
