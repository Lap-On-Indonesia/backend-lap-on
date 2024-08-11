<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RegisterOwnerMarketplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegisterOwnerMarketplaceController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:register_owner_marketplaces,email',
            'phone' => 'required|string|max:20',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only('name', 'email', 'phone', 'password');
        $data['password'] = Hash::make($data['password']);

        // Handle file uploads
        if ($request->hasFile('photo_profile')) {
            $data['photo_profile'] = $request->file('photo_profile')->store('profile_photos', 'public');
        }
        if ($request->hasFile('photo_ktp')) {
            $data['photo_ktp'] = $request->file('photo_ktp')->store('ktp_photos', 'public');
        }

        $owner = RegisterOwnerMarketplace::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Owner registered successfully',
            'data' => $owner
        ], 201);
    }
}
