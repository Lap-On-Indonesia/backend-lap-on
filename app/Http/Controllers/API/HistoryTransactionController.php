<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;

class HistoryTransactionController extends Controller
{
    public function index()
    {
        // Mengambil semua transaksi untuk user yang sedang terautentikasi
        $transactions = Transaction::where('user_id', Auth::id())->get();

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
