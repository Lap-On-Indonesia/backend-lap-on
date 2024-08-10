<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'venue_id' => 'required|exists:venues,id',
            'booking_id' => 'required|string|max:100|unique:transactions,booking_id',
            'total' => 'nullable|numeric|min:0',
            'status' => 'required|string|max:10',
            'payment_url' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $transaction = Transaction::create([
            'user_id' => $userId,
            'venue_id' => $request->venue_id,
            'booking_id' => $request->booking_id,
            'total' => $request->total,
            'status' => $request->status,
            'payment_url' => $request->payment_url,
        ]);

        return response()->json($transaction, 201);
    }
}

