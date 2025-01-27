<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;

class HistoryTransactionController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter status dari request
        $status = $request->input('status');
    
        // Mulai query untuk mengambil transaksi milik user yang sedang login
        $query = Transaction::where('user_id', Auth::id())->with(['user', 'venue', 'booking']);
    
        // Jika parameter status ada dan valid, tambahkan kondisi ke query
        if (in_array($status, ['pending', 'success', 'failed'])) {
            $query->where('status', $status);
        }
    
        // Eksekusi query dan dapatkan hasilnya
        $transactions = $query->get();
    
        // Periksa apakah ada transaksi yang ditemukan
        if ($transactions->isEmpty()) {
            return ResponseFormatter::success(null, 'No transactions found');
        }
    
        // Kembalikan respon sukses dengan data transaksi
        return ResponseFormatter::success($transactions, 'Transactions retrieved successfully');
    }
    

    public function show($id)
    {
        // Mengambil satu transaksi berdasarkan ID untuk user yang sedang terautentikasi
        $transaction = Transaction::where('user_id', Auth::id())->where('id', $id)->first();

        if (!$transaction) {
            return ResponseFormatter::error(null, 'Transaction not found', 404);
        }

        return ResponseFormatter::success($transaction, 'Transaction retrieved successfully');
    }
}
