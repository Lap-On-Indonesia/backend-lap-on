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
    
            // Validasi input
            $request->validate([
                'venue_id' => 'required|exists:venues,id',
                'field_id' => 'required|exists:fields,id',
                'booking_date' => 'required|date',
                'time_slots' => 'required|array|min:1', // menerima array slot waktu
                'time_slots.*.start_time' => 'required|date_format:H:i',
                'time_slots.*.end_time' => 'required|date_format:H:i|after:time_slots.*.start_time',
                'tax_percentage' => 'nullable|numeric',
                'total_payment' => 'nullable|numeric',
            ]);
    
            $venue = Venue::find($request->venue_id);
            $taxPercentage = $request->tax_percentage ?? 11;
    
            $bookings = []; // Untuk menyimpan semua booking yang berhasil dibuat
    
            foreach ($request->time_slots as $slot) {
                $startTime = Carbon::parse($slot['start_time']);
                $endTime = Carbon::parse($slot['end_time']);
    
                // Validasi waktu tumpang tindih
                $isBooked = Booking::where('venue_id', $request->venue_id)
                    ->where('booking_date', $request->booking_date)
                    ->where(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<', $endTime)
                              ->where('end_time', '>', $startTime);
                    })
                    ->exists();
    
                if ($isBooked) {
                    return ResponseFormatter::error(null, "Slot waktu dari {$startTime->format('H:i')} sampai {$endTime->format('H:i')} sudah dibooking.", 422);
                }
    
                // Hitung total pembayaran
                $durationInHours = $endTime->diffInHours($startTime);
                $pricePerHour = $venue->price;
                $totalPayment = $durationInHours * $pricePerHour;
                $taxAmount = $totalPayment * ($taxPercentage / 100);
                $totalPaymentWithTax = $totalPayment + $taxAmount;
    
                // Membuat booking
                $bookingData = [
                    'user_id' => $userId,
                    'venue_id' => $request->venue_id,
                    'field_id' => $request->field_id,
                    'booking_date' => $request->booking_date,
                    'start_time' => $startTime->format('H:i:s'),
                    'end_time' => $endTime->format('H:i:s'),
                    'total_payment' => $totalPaymentWithTax,
                    'tax_percentage' => $taxPercentage,
                ];
    
                $booking = Booking::create($bookingData);
                $bookings[] = $booking; // Menyimpan booking ke dalam array
            }
    
            return ResponseFormatter::success($bookings, 'Booking berhasil dibuat untuk beberapa slot waktu.', 201);
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