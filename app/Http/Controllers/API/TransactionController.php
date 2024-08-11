<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;

class TransactionController extends Controller
{
    public function index()
{
    $transactions = Transaction::with(['user', 'venue', 'booking'])->get();

    if ($transactions->isEmpty()) {
        return ResponseFormatter::error(null, 'No transactions found', 404);
    }

    return ResponseFormatter::success($transactions, 'Transactions retrieved successfully');
}


    public function store(Request $request)
    {
        $userId = Auth::id();
        dd($userId);
        $validator = Validator::make($request->all(), [
            'venue_id' => 'required|exists:venues,id',
            'booking_id' => 'required|string|max:100|unique:transactions,booking_id',
            'total' => 'nullable|numeric|min:0',
            'status' => 'required|string|max:10',
            'payment_url' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validation Error', 422);
        }

        $transaction = Transaction::create([
            'user_id' => $userId,
            'venue_id' => $request->venue_id,
            'booking_id' => $request->booking_id,
            'total' => $request->total,
            'status' => $request->status,
            'payment_url' => $request->payment_url,
        ]);

        return ResponseFormatter::success($transaction, 'Transaction created successfully', 201);
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'venue', 'booking'])->find($id);

        if (!$transaction) {
            return ResponseFormatter::error(null, 'Transaction not found', 404);
        }

        return ResponseFormatter::success($transaction, 'Transaction retrieved successfully');
    }
}
