<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        return ResponseFormatter::success($category, 'Category created successfully', 201);
    }

    public function index()
    {
        $categories = Category::all();
        return ResponseFormatter::success($categories, 'Categories retrieved successfully');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return ResponseFormatter::success($category, 'Category retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return ResponseFormatter::success($category, 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return ResponseFormatter::success(null, 'Category deleted successfully');
    }
}
