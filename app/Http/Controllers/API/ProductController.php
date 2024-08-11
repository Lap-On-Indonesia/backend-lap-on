<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;

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
}
