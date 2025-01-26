<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TransactionMarketplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use App\Helpers\ResponseFormatter;


class MarketplaceCheckoutController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

        // Set Midtrans configuration
        Config::$serverKey    = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized  = config('services.midtrans.isSanitized');
        Config::$is3ds        = config('services.midtrans.is3ds');
    }

    public function store()
    {
        DB::beginTransaction();

        try {
            // Generate a unique transaction ID
            $transactionId = 'MPTRX-' . Str::upper(Str::random(10));

            // Assume you get product ID from the request
            $productId = $this->request->product_id;

            // Get product details
            $product = Product::findOrFail($productId);

            // Calculate total amount (you can modify this if there are multiple products or discounts)
            $grossAmount = $product->price;

            // Create a transaction record in transaction_marketplaces table
            $transaction = TransactionMarketplace::create([
                'transaction_id' => $transactionId,
                'user_id'        => Auth::id(),
                'product_id'     => $productId,
                'total'          => $grossAmount,
                'status'         => 'pending',
            ]);

            // Prepare payload for Midtrans
            $payload = [
                'transaction_details' => [
                    'order_id'      => $transactionId,
                    'gross_amount'  => $transaction->total,
                ],
                'customer_details' => [
                    'first_name'       => Auth::user()->name,
                    'email'            => Auth::user()->email,
                    'phone'            => Auth::user()->phone,
                ],
                'item_details' => [
                    [
                        'id'       => $productId,
                        'price'    => $product->price,
                        'quantity' => 1,
                        'name'     => $product->name_product,
                    ]
                ]
            ];

            // Create snap token
            $snapToken = Snap::getSnapToken($payload);

            // Generate payment URL
            $baseSnapUrl = config('services.midtrans.isProduction')
                ? 'https://app.midtrans.com/snap/v2/vtweb/'
                : 'https://app.sandbox.midtrans.com/snap/v2/vtweb/';

            $paymentUrl = $baseSnapUrl . $snapToken;

            // Save snap token and payment URL in the transaction

            $transaction->update([
                'payment_url' => $paymentUrl,
            ]);

            DB::commit();

            // return response()->json([
            //     'success' => true,
            //     'message' => 'Transaction created successfully',
            //     'payment_url' => $paymentUrl
            // ]);
            return ResponseFormatter::success($transaction, 'Transaction successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Transaction creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
}
