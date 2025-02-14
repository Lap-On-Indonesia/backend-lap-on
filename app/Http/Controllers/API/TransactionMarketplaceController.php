<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionMarketplace;

class TransactionMarketplaceController extends Controller
{
    public function index()
    {
        $transactions = TransactionMarketplace::where('user_id', Auth::id())->with(['user', 'product'])->get();
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
        $userId = Auth::id();

        $validated = $request->validate([
            'product_id' => 'required|string|max:255|exists:products,product_id',
            'total' => 'required|numeric|min:1', // Pastikan total terisi
            'status' => 'required|string|max:10',
            'payment_url' => 'nullable|string|max:255',
        ]);

        // Ambil produk berdasarkan product_id
        $product = Product::where('product_id', $validated['product_id'])->first();

        if (!$product) {
            return ResponseFormatter::error(null, 'Product not found', 404);
        }

        // Periksa apakah stok mencukupi
        if ($product->stock < $validated['total']) {
            return ResponseFormatter::error(null, 'Insufficient stock', 400);
        }

        // Kurangi stok produk berdasarkan total yang dibeli
        $product->stock -= $validated['total'];
        $product->save();

        // Buat transaksi baru
        $validated['transaction_id'] = Str::uuid();
        $validated['user_id'] = $userId;

        $transaction = TransactionMarketplace::create($validated);

        return ResponseFormatter::success($transaction, 'Transaction created successfully', 201);
    }

    public function updateShippingStatus(Request $request, $id)
    {
        $request->validate([
            'shipping_status' => 'required|in:Menunggu konfirmasi,Sedang disiapkan,Sedang dikirim,Sampai tujuan',
        ]);

        $transaction = TransactionMarketplace::find($id);

        if (!$transaction) {
            return ResponseFormatter::error(null, 'Transaction not found', 404);
        }

        $transaction->shipping_status = $request->shipping_status;
        $transaction->save();

        return ResponseFormatter::success($transaction, 'Shipping status updated successfully');
    }   

}
