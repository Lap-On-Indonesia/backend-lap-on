<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Helpers\ResponseFormatter;
use App\Models\CategoryMarketplace;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{


    // Mendapatkan daftar produk
    public function index()
    {
        $products = Product::with('variations')->get();
        return ResponseFormatter::success($products, 'Products retrieved successfully');
    }

    // Mendapatkan produk berdasarkan ID
    public function show($id)
    {
        $product = Product::with('variations')->findOrFail($id);
        return ResponseFormatter::success($product, 'Product retrieved successfully');
    }

    public function showByCategoryId(Request $request)
    {
        // Mengambil category_id dari request
        $categoryId = $request->category_marketplace_id;

        // Jika category_id diberikan
        if ($categoryId) {
            // Cek apakah category_id ada di database
            $categoryExists = CategoryMarketplace::find($categoryId);

            if (!$categoryExists) {
                return ResponseFormatter::error(null, 'Category ID not found', 404);
            }

            // Mengambil produk berdasarkan category_id
            $products = Product::with('categoryMarketplace')
                ->where('category_marketplace_id', $categoryId)
                ->get();

            if ($products->isEmpty()) {
                return ResponseFormatter::error(null, 'No product found for the given category', 404);
            }

            return ResponseFormatter::success($products, 'Products retrieved successfully for the given category');
        } else {
            // Jika category_id tidak diberikan, mengambil semua produk
            $products = Product::with('categoryMarketplace')->get();

            if ($products->isEmpty()) {
                return ResponseFormatter::error(null, 'No products available', 404);
            }

            return ResponseFormatter::success($products, 'All products retrieved successfully');
        }
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'product_variation_id' => 'required|exists:product_variations,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $variation = ProductVariation::findOrFail($request->product_variation_id);

        if ($variation->stock < $request->quantity) {
            return ResponseFormatter::error(null, 'Stock not available', 400);
        }

        return ResponseFormatter::success([
            'product' => $variation->product->name_product,
            'variation' => [
                'material' => $variation->material,
                'size' => $variation->size,
                'price' => $variation->price,
                'quantity' => $request->quantity,
                'total_price' => $variation->price * $request->quantity,
            ]
        ], 'Checkout successful');
    }

}
