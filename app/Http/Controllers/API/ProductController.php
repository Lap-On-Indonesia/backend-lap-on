<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use App\Models\CategoryMarketplace;

class ProductController extends Controller
{
    // Menambahkan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'transaction_marketplace_id' => 'required|exists:transaction_marketplaces,id',
            'name_product' => 'required|string|max:255',
            'category_product' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::create($request->all());

        return ResponseFormatter::success($product, 'Product created successfully', 201);
    }

    // Memperbarui produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'transaction_marketplace_id' => 'required|exists:transaction_marketplaces,id',
            'name_product' => 'required|string|max:255',
            'category_product' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return ResponseFormatter::success($product, 'Product updated successfully');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return ResponseFormatter::success(null, 'Product deleted successfully');
    }

    // Mendapatkan daftar produk
    public function index()
    {
        $products = Product::all();
        return ResponseFormatter::success($products, 'Products retrieved successfully');
    }

    // Mendapatkan produk berdasarkan ID
    public function show($id)
    {
        $product = Product::findOrFail($id);
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
}
