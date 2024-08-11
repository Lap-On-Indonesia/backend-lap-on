<?php

namespace App\Http\Controllers\API;

use App\Models\Venue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;

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
        $categoryId = $request->input('category_id');

        if ($categoryId) {
            $venues = Venue::with('owner', 'category')
                ->where('category_id', $categoryId)
                ->get();
        } else {
            $venues = Venue::with('owner', 'category')->get();
        }

        return ResponseFormatter::success($venues, 'Venues retrieved successfully');
    }
}
