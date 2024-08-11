<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::with('owner', 'category')->get();
        return ResponseFormatter::success($venues, 'Venues retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'owner_id' => 'required|exists:users,id',
            'price' => 'required|numeric|min:0', // Validasi untuk price
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);

        $venue = Venue::create($request->all());
        return ResponseFormatter::success($venue, 'Venue created successfully', 201);
    }


    public function show($id)
    {
        $venue = Venue::with('owner', 'category')->findOrFail($id);
        return ResponseFormatter::success($venue, 'Venue retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'category_id' => 'sometimes|exists:categories,id',
            'owner_id' => 'sometimes|exists:users,id',
            'price' => 'sometimes|numeric|min:0', // Validasi untuk price
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);

        $venue = Venue::findOrFail($id);
        $venue->update($request->all());

        return ResponseFormatter::success($venue, 'Venue updated successfully');
    }

    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->delete();

        return ResponseFormatter::success(null, 'Venue deleted successfully', 204);
    }

    public function showbyCategoryId(Request $request)
    {
        $categoryId = $request->category_id;

        if ($categoryId) {
            // Cek apakah category_id ada di database
            $categoryExists = Category::find($categoryId);

            if (!$categoryExists) {
                return ResponseFormatter::error(null, 'Category ID not found', 404);
            }

            $venues = Venue::with('owner', 'category')
                ->where('category_id', $categoryId)
                ->get();

            if ($venues->isEmpty()) {
                return ResponseFormatter::error(null, 'No venues found for the given category', 404);
            }

            return ResponseFormatter::success($venues, 'Venues retrieved successfully for the given category');
        } else {
            $venues = Venue::with('owner', 'category')->get();

            if ($venues->isEmpty()) {
                return ResponseFormatter::error(null, 'No venues available', 404);
            }

            return ResponseFormatter::success($venues, 'All venues retrieved successfully');
        }
    }
}
