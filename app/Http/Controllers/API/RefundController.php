<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RefundRequestNotification;
use App\Mail\RefundApprovedMail;
use Illuminate\Support\Facades\Cache;

class RefundController extends Controller
{
    // Fungsi untuk mendapatkan daftar refund
    public function index()
    {
        $refunds = Refund::all(); // Ambil semua data refund

        return response()->json([
            'status' => 'success',
            'data' => $refunds,
        ], Response::HTTP_OK);
    }

    // Fungsi untuk mengonfirmasi refund
    public function confirm(Request $request, $id)
    {
        $refund = Refund::find($id);

        if (!$refund) {
            return response()->json([
                'status' => 'error',
                'message' => 'Refund not found',
            ], Response::HTTP_NOT_FOUND);
        }

        // Update status refund ke "completed"
        $refund->status = 'completed';
        $refund->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Refund has been confirmed',
            'data' => $refund,
        ], Response::HTTP_OK);
    }

    public function requestRefund(Request $request, $bookingId)
{
    $lockKey = 'refund_request_' . $bookingId;

    // Attempt to acquire the lock
    $lock = Cache::lock($lockKey, 10); // Lock expires in 10 seconds

    if (!$lock->get()) {
        return response()->json(['code' => 429,'message' => 'A refund request is already being processed for this booking'], 429);
    }

    try {
        $booking = Booking::findOrFail($bookingId);

        if ($booking->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$booking->isEligibleForRefund()) {
            return response()->json(['message' => 'Refund can only be requested 24 hours before the booking time'], 400);
        }

        // Cek apakah sudah ada refund untuk booking ini
        $existingRefund = Refund::where('booking_id', $bookingId)->first();
        if ($existingRefund) {
            return response()->json(['message' => 'Refund has already been requested for this booking'], 400);
        }

        $refund = Refund::create([
            'booking_id' => $booking->id,
            'refund_date_time' => now(),
            'status' => 'pending',
            'total_payment' => $booking->total_payment * 0.80, // Potongan 20%
        ]);

        // Kirim notifikasi email ke admin
        $adminEmail = 'admin@example.com'; // Ganti dengan email admin yang sesuai
        Mail::to($adminEmail)->send(new RefundRequestNotification($refund));

        return response()->json(['code' => 201,'message' => 'Refund request submitted', 'refund' => $refund], 201);
    } finally {
        // Release the lock
        $lock->release();
    }
}

    public function approveRefund(Request $request, $refundId)
    {
        $refund = Refund::findOrFail($refundId);
        $refund->status = 'approved';
        $refund->save();

        // Kirim email notifikasi ke pengguna
        Mail::to($refund->booking->user->email)->send(new RefundApprovedMail($refund));

        return response()->json(['message' => 'Refund approved', 'refund' => $refund], 200);
    }
}
 