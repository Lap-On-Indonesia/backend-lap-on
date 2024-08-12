<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function paymentSuccess(Request $request)
    {
        // Data yang akan dikirim ke view
        $data = [
            'message' => 'Pembayaran sukses'
            // Tambahkan data lain yang diperlukan di sini
        ];

        // Mengirim data ke view
        return view('user.payment_success', $data);
    }
}
