<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TransactionMarketplace;
use App\Helpers\ResponseFormatter;

class TransactionMarketplaceController extends Controller
{
    public function index()
    {
        $transactions = TransactionMarketplace::all();
        return ResponseFormatter::success($transactions, 'Transactions retrieved successfully');
    }

    public function show($id)
    {
        $transaction = TransactionMarketplace::find($id);

        if (!$transaction) {
            return ResponseFormatter::error(['message' => 'Transaction not found'], 'Transaction not found', 404);
        }

        return ResponseFormatter::success($transaction, 'Transaction retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'venue_id' => 'required|exists:venues,id',
            'booking_id' => 'required|string|max:100',
            'total' => 'nullable|numeric',
            'status' => 'required|string|max:10',
            'payment_url' => 'required|string|max:255',
        ]);

        $transaction = TransactionMarketplace::create($request->all());

        return ResponseFormatter::success($transaction, 'Transaction created successfully', 201);
    }

    public function update(Request $request, $id)
    {
        $transaction = TransactionMarketplace::find($id);

        if (!$transaction) {
            return ResponseFormatter::error(['message' => 'Transaction not found'], 'Transaction not found', 404);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'venue_id' => 'required|exists:venues,id',
            'booking_id' => 'required|string|max:100',
            'total' => 'nullable|numeric',
            'status' => 'required|string|max:10',
            'payment_url' => 'required|string|max:255',
        ]);

        $transaction->update($request->all());

        return ResponseFormatter::success($transaction, 'Transaction updated successfully');
    }

    public function destroy($id)
    {
        $transaction = TransactionMarketplace::find($id);

        if (!$transaction) {
            return ResponseFormatter::error(['message' => 'Transaction not found'], 'Transaction not found', 404);
        }

        $transaction->delete();

        return ResponseFormatter::success(null, 'Transaction deleted successfully', 204);
    }
}
