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

    public function show($id)
    {
        try {
            $venue = Venue::with('owner', 'category', 'schedule', 'field')->findOrFail($id);

            return ResponseFormatter::success($venue, 'Venue retrieved successfully');
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

    public function getVenueCoordinates($id)
    {
        try {
            $venue = Venue::findOrFail($id);

            $coordinates = [
                'latitude' => $venue->latitude,
                'longitude' => $venue->longitude
            ];

            return ResponseFormatter::success($coordinates, 'Venue coordinates retrieved successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ResponseFormatter::error(null, 'Venue not found', 404);
        }
    }

}
