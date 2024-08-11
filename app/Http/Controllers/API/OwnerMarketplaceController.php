<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RegisterOwnerMarketplace;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseFormatter;

class OwnerMarketplaceController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:register_owner_marketplaces,email',
            'phone' => 'required|string|max:20',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validation Error', 422);
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        // Handle file uploads
        if ($request->hasFile('photo_profile')) {
            $data['photo_profile'] = $request->file('photo_profile')->store('profile_photos', 'public');
        }

        if ($request->hasFile('photo_ktp')) {
            $data['photo_ktp'] = $request->file('photo_ktp')->store('ktp_photos', 'public');
        }

        $ownerMarketplace = RegisterOwnerMarketplace::create($data);

        return ResponseFormatter::success($ownerMarketplace, 'Owner Marketplace registered successfully', 201);
    }
}
