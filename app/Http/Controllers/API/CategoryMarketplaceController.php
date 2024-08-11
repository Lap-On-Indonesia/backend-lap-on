<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CategoryMarketplace;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;

class CategoryMarketplaceController extends Controller
{
    public function index()
    {
        $categories = CategoryMarketplace::all();
        return ResponseFormatter::success($categories, 'Categories retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = CategoryMarketplace::create($request->all());
        return ResponseFormatter::success($category, 'Category created successfully', Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $category = CategoryMarketplace::find($id);

        if (!$category) {
            return ResponseFormatter::error(null, 'Category not found', Response::HTTP_NOT_FOUND);
        }

        return ResponseFormatter::success($category, 'Category retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
        ]);

        $category = CategoryMarketplace::find($id);

        if (!$category) {
            return ResponseFormatter::error(null, 'Category not found', Response::HTTP_NOT_FOUND);
        }

        $category->update($request->all());
        return ResponseFormatter::success($category, 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = CategoryMarketplace::find($id);

        if (!$category) {
            return ResponseFormatter::error(null, 'Category not found', Response::HTTP_NOT_FOUND);
        }

        $category->delete();
        return ResponseFormatter::success(null, 'Category deleted successfully', Response::HTTP_NO_CONTENT);
    }
}
