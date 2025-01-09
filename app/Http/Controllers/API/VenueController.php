<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search'); // Parameter untuk pencarian
        $venues = Venue::with('owner', 'category', 'schedule')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10); // Gunakan paginasi untuk mencegah masalah performa

        return ResponseFormatter::success($venues, 'Venues retrieved successfully');
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'owner_id' => 'required|exists:users,id',
            'link_maps' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90', // Validasi latitude
            'longitude' => 'required|numeric|between:-180,180', // Validasi longitude
            'price' => 'required|numeric|min:0', // Validasi untuk harga
        ]);

        // Simpan data venue
        $venue = Venue::create($request->all());

        return ResponseFormatter::success($venue, 'Venue created successfully', 201);
    }

    public function show($id)
    {
        try {
            $venue = Venue::with('owner', 'category', 'schedule')->findOrFail($id);

            return ResponseFormatter::success($venue, 'Venue retrieved successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ResponseFormatter::error(null, 'Venue not found', 404);
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
            'owner_id' => 'sometimes|exists:users,id',
            'link_maps' => 'sometimes|string|max:255',
            'latitude' => 'sometimes|numeric|between:-90,90', // Validasi latitude
            'longitude' => 'sometimes|numeric|between:-180,180', // Validasi longitude
            'price' => 'sometimes|numeric|min:0', // Validasi untuk harga
        ]);

        try {
            // Cari venue dan update data
            $venue = Venue::findOrFail($id);
            $venue->update($request->all());

            return ResponseFormatter::success($venue, 'Venue updated successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ResponseFormatter::error(null, 'Venue not found', 404);
        }
    }

    public function destroy($id)
    {
        try {
            // Cari venue dan hapus
            $venue = Venue::findOrFail($id);
            $venue->delete();

            return ResponseFormatter::success(null, 'Venue deleted successfully', 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ResponseFormatter::error(null, 'Venue not found', 404);
        }
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

            $venues = Venue::with('owner', 'category', 'schedule')
                ->where('category_id', $categoryId)
                ->paginate(10); // Paginate data untuk performa

            if ($venues->isEmpty()) {
                return ResponseFormatter::error(null, 'No venues found for the given category', 404);
            }

            return ResponseFormatter::success($venues, 'Venues retrieved successfully for the given category');
        } else {
            $venues = Venue::with('owner', 'category', 'schedule')->paginate(10);

            if ($venues->isEmpty()) {
                return ResponseFormatter::error(null, 'No venues available', 404);
            }

            return ResponseFormatter::success($venues, 'All venues retrieved successfully');
        }
    }
}
