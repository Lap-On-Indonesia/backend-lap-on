<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Transaction;
use App\Models\Venue;
use Carbon\Carbon;
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
        try {
            $userId = Auth::id();

            $request->validate([
                'venue_id' => 'required|exists:venues,id',
                'schedules' => 'required|array',
                'schedules.*.booking_date' => 'required|date',
                'schedules.*.start_time' => 'required|date_format:H:i',
                'schedules.*.end_time' => 'required|date_format:H:i|after:schedules.*.start_time',
                'tax_percentage' => 'nullable|numeric',
            ]);

            $venue = Venue::find($request->venue_id);
            $taxPercentage = $request->tax_percentage ?? 11;
            $bookings = [];

            foreach ($request->schedules as $schedule) {
                $startTime = Carbon::parse($schedule['start_time']);
                $endTime = Carbon::parse($schedule['end_time']);

                // Cek apakah slot waktu sudah dipesan
                $isBooked = Booking::where('venue_id', $request->venue_id)
                    ->where('booking_date', $schedule['booking_date'])
                    ->where(function ($query) use ($startTime, $endTime) {
                        $query->whereBetween('start_time', [$startTime, $endTime])
                            ->orWhereBetween('end_time', [$startTime, $endTime])
                            ->orWhere(function ($query) use ($startTime, $endTime) {
                                $query->where('start_time', '<', $startTime)
                                    ->where('end_time', '>', $endTime);
                            });
                    })
                    ->exists();

                if ($isBooked) {
                    return ResponseFormatter::error(null, 'Jadwal pada ' . $schedule['booking_date'] . ' jam ' . $schedule['start_time'] . ' - ' . $schedule['end_time'] . ' sudah dibooking', 422);
                }

                // Hitung total pembayaran
                $durationInHours = $endTime->diffInHours($startTime);
                $pricePerHour = $venue->price;
                $totalPayment = $durationInHours * $pricePerHour;
                $taxAmount = $totalPayment * ($taxPercentage / 100);
                $totalPaymentWithTax = $totalPayment + $taxAmount;

                // Simpan booking
                $booking = Booking::create([
                    'user_id' => $userId,
                    'venue_id' => $request->venue_id,
                    'booking_date' => $schedule['booking_date'],
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                    'total_payment' => $totalPaymentWithTax,
                    'tax_percentage' => $taxPercentage,
                ]);

                $bookings[] = $booking;
            }

            return ResponseFormatter::success($bookings, 'Booking berhasil dibuat', 201);
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Gagal membuat booking: ' . $e->getMessage(), 500);
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
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'tax_percentage' => 'nullable|numeric', // Ubah menjadi nullable
            'total_payment' => 'nullable|numeric',
        ]);

        $venue = Venue::find($request->venue_id);
        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);
        $durationInHours = $endTime->diffInHours($startTime);
        $pricePerHour = $venue->price;
        $taxPercentage = $request->tax_percentage ?? 11; // Ambil dari request atau set default

        $totalPayment = $durationInHours * $pricePerHour;
        $taxAmount = $totalPayment * ($taxPercentage / 100);
        $totalPaymentWithTax = $totalPayment + $taxAmount;

        $data = $request->all();
        $data['total_payment'] = $totalPaymentWithTax;
        $data['tax_percentage'] = $taxPercentage;

        if (!isset($data['total_payment']) || $data['total_payment'] === null) {
            return ResponseFormatter::error(null, 'Total payment cannot be null', 422);
        }

        $booking->update($data);

        // Memperbarui Transaction secara otomatis
        $transaction = Transaction::where('booking_id', $booking->id)->first(); // Gunakan $booking->id bukan $booking->booking_id
        if ($transaction) {
            $transaction->update([
                'total' => $booking->total_payment,
                'tax_percentage' => $taxPercentage, // Pastikan tax_percentage diisi
            ]);
        }

        return ResponseFormatter::success($booking, 'Booking updated successfully');
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return ResponseFormatter::error('Booking not found', null, 404);
        }

        // Menghapus Transaction terkait
        $transaction = Transaction::where('booking_id', $booking->id)->first(); // Gunakan $booking->id bukan $booking->booking_id
        if ($transaction) {
            $transaction->delete();
        }

        $booking->delete();

        return ResponseFormatter::success(null, 'Booking deleted successfully');
    }
}
