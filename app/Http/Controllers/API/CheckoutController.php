<?php

namespace App\Http\Controllers\API;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Booking;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

        // Set Midtrans configuration
        Config::$serverKey    = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized  = config('services.midtrans.isSanitized');
        Config::$is3ds        = config('services.midtrans.is3ds');
    }

    public function store()
    {
        DB::beginTransaction();

        try {
            // Generate a unique transaction ID
            $transactionId = 'TRX-' . Str::upper(Str::random(10));

            // Assume you get booking ID from the request
            $bookingId = $this->request->booking_id;

            // Get booking details
            $booking = Booking::findOrFail($bookingId);
            // dd($booking->price);

            // Create a transaction record
            $transaction = Transaction::create([
                'transaction_id' => $transactionId,
                'user_id'        => Auth::id(),
                'venue_id'       => $booking->venue_id,
                'booking_id'     => $booking->id,
                'total'          => $booking->total_payment, // Assuming you have a total amount field
                'status'         => 'pending',
            ]);

            // Prepare payload for Midtrans
            $payload = [
                'transaction_details' => [
                    'order_id'      => $transaction->id,
                    'gross_amount'  => $transaction->total,
                ],
                'customer_details' => [
                    'first_name'       => Auth::user()->name, // Mengambil nama pengguna yang login
                    'email'            => Auth::user()->email, // Mengambil email pengguna yang login
                    'phone'            => Auth::user()->phone, // Mengambil nomor telepon pengguna yang login
                ],
                'item_details' => [
                    [
                        'id'       => $booking->id,
                        'price'    => $booking->total_payment, // Assuming each booking has a price
                        'quantity' => 1,
                        'name'     => 'Booking for ' . $booking->venue->name, // Assuming you have a venue relation
                    ]
                ]
            ];

            // Create snap token
            $snapToken = Snap::getSnapToken($payload);

            // Generate payment URL
            $baseSnapUrl = config('services.midtrans.isProduction')
                ? 'https://app.midtrans.com/snap/v2/vtweb/'
                : 'https://app.sandbox.midtrans.com/snap/v2/vtweb/';

            $paymentUrl = $baseSnapUrl . $snapToken;

            // Save snap token and payment URL in the transaction
            $transaction->update([
                'payment_url' => $paymentUrl,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaction created successfully',
                'payment_url' => $paymentUrl
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Transaction creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function notificationHandler(Request $request)
    {
        $payload      = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));

        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        $transactionStatus = $notification->transaction_status;
        $orderId           = $notification->order_id;
        $paymentType       = $notification->payment_type;
        $fraudStatus       = $notification->fraud_status;

        // Find the transaction
        $transaction = Transaction::where('transaction_id', $orderId)->first();

        if (!$transaction) {
            return response(['message' => 'Transaction not found'], 404);
        }

        // Update transaction status based on Midtrans notification
        if ($transactionStatus == 'capture') {
            if ($paymentType == 'credit_card') {
                if ($fraudStatus == 'challenge') {
                    $transaction->status = 'pending';
                } else {
                    $transaction->status = 'success';
                }
            }
        } elseif ($transactionStatus == 'settlement') {
            $transaction->status = 'success';
        } elseif ($transactionStatus == 'pending') {
            $transaction->status = 'pending';
        } elseif ($transactionStatus == 'deny') {
            $transaction->status = 'failed';
        } elseif ($transactionStatus == 'expire') {
            $transaction->status = 'expired';
        } elseif ($transactionStatus == 'cancel') {
            $transaction->status = 'failed';
        }

        $transaction->save();

        // Update booking status if needed
        if ($transaction->status == 'success') {
            $transaction->booking->update(['status' => 'paid']);
        }

        return response()->json(['message' => 'Notification processed successfully.']);
    }
}
