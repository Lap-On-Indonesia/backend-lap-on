<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\TransactionMarketplace;

class TransactionMarketplaceController extends Controller
{
    public function index()
    {
        return response()->json(TransactionMarketplace::all(), Response::HTTP_OK);
    }

    public function show($id)
    {
        $transaction = TransactionMarketplace::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($transaction, Response::HTTP_OK);
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

        return response()->json($transaction, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $transaction = TransactionMarketplace::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], Response::HTTP_NOT_FOUND);
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

        return response()->json($transaction, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $transaction = TransactionMarketplace::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], Response::HTTP_NOT_FOUND);
        }

        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted'], Response::HTTP_NO_CONTENT);
    }
}
