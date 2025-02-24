<?php

namespace App\Http\Controllers\API;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\TransactionMarketplace;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

        // Set Midtrans configuration
        Config::$serverKey    = config('services.midtrans.serverKey');
        Config::$clientKey    = config('services.midtrans.clientKey');
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

        // Dapatkan array booking_id dari request
        $bookingIds = $this->request->booking_id;
        // dd($bookingIds);

        // Validasi bahwa bookingIds adalah array
        if (!is_array($bookingIds) || empty($bookingIds)) {
            return ResponseFormatter::error(null, 'Booking IDs must be provided as an array.', 422);
        }

        $totalAmount = 0;
        $itemDetails = [];

        foreach ($bookingIds as $bookingId) {
            // Ambil detail booking
            $booking = Booking::findOrFail($bookingId);

            // Hitung total pembayaran
            $totalAmount += $booking->total_payment;

            // Tambahkan detail item untuk Midtrans
            $itemDetails[] = [
                'id'       => $booking->id,
                'price'    => $booking->total_payment,
                'quantity' => 1,
                'name'     => 'Booking for ' . $booking->venue->name,
            ];

            // Buat transaksi untuk setiap booking
            Transaction::create([
                'transaction_id' => $transactionId,
                'user_id'        => Auth::id(),
                'venue_id'       => $booking->venue_id,
                'field_id'       => $booking->field_id,
                'booking_id'     => $booking->id,
                'total'          => $booking->total_payment,
                'status'         => 'pending',
            ]);
        }

        // Siapkan payload untuk Midtrans
        $payload = [
            'transaction_details' => [
                'order_id'      => $transactionId,
                'gross_amount'  => $totalAmount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
                'phone'      => Auth::user()->phone,
            ],
            'item_details' => $itemDetails,
        ];

        // Generate snap token dari Midtrans
        $snapToken = Snap::getSnapToken($payload);

        // Generate payment URL
        $baseSnapUrl = config('services.midtrans.isProduction')
            ? 'https://app.midtrans.com/snap/v2/vtweb/'
            : 'https://app.sandbox.midtrans.com/snap/v2/vtweb/';

        $paymentUrl = $baseSnapUrl . $snapToken;

        // Update transaksi dengan payment URL
        Transaction::where('transaction_id', $transactionId)->update([
            'payment_url' => $paymentUrl,
        ]);

        DB::commit();

        // Return response sukses
        return ResponseFormatter::success([
            'transaction_id' => $transactionId,
            'payment_url' => $paymentUrl,
            'total_amount' => $totalAmount
        ], 'Transaction successfully created with multiple bookings.');

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
    // Mendapatkan payload dari request
    $payload = $request->getContent();
    $notification = json_decode($payload);

    // Validasi Signature Key
    $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));

    if ($notification->signature_key != $validSignatureKey) {
        return response(['message' => 'Invalid signature'], 403);
    }

    // Mendapatkan status transaksi dan informasi lainnya
    $transactionStatus = $notification->transaction_status;
    $orderId = $notification->order_id;
    $paymentType = $notification->payment_type;
    $fraudStatus = $notification->fraud_status ?? null;

    // Identifikasi jenis transaksi berdasarkan order_id
    if (strpos($orderId, 'TRX-') === 0) {
        // Penanganan untuk transaksi venue
        $transaction = Transaction::where('transaction_id', $orderId)->first();
    } elseif (strpos($orderId, 'MPTRX-') === 0) {
        // Penanganan untuk transaksi marketplace
        $transaction = TransactionMarketplace::where('transaction_id', $orderId)->first();
    } else {
        return response(['message' => 'Transaction type not recognized'], 400);
    }

    if (!$transaction) {
        return response(['message' => 'Transaction not found'], 404);
    }

    // Update status transaksi berdasarkan notifikasi Midtrans
    switch ($transactionStatus) {
        case 'capture':
            if ($paymentType == 'credit_card') {
                $transaction->status = ($fraudStatus == 'challenge') ? 'pending' : 'success';
            }
            break;
        case 'settlement':
            $transaction->status = 'success';
            break;
        case 'pending':
            $transaction->status = 'pending';
            break;
        case 'deny':
        case 'expire':
        case 'cancel':
            $transaction->status = 'failed';
            break;
        default:
            return response(['message' => 'Unknown transaction status'], 400);
    }

    // Simpan perubahan status transaksi
    $transaction->save();

    // Jika diperlukan, update entitas terkait
    if ($transaction->status == 'success' && isset($transaction->booking)) {
        $transaction->booking->update(['status' => 'paid']);
    }

    return response()->json(['message' => 'Notification processed successfully.']);
}


}
