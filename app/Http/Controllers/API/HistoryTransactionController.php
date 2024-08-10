<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HistoryTransactionController extends Controller
{
    public function index()
    {
        // Get all transactions for the authenticated user
        $transactions = Transaction::where('user_id', Auth::id())->get();

        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ], 200);
    }

    public function show($id)
    {
        // Get a single transaction by ID for the authenticated user
        $transaction = Transaction::where('user_id', Auth::id())->where('id', $id)->first();

        if (!$transaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transaction
        ], 200);
    }
}
