<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RegisterOwnerMarketplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseFormatter;

class RegisterOwnerMarketplaceController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:register_owner_marketplace,email',
            'phone' => 'required|string|max:20',
            'photo_profile' => 'nullable|string|max:255',
            'photo_ktp' => 'nullable|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validation failed', 422);
        }

        $owner = RegisterOwnerMarketplace::create($request->all());

        return ResponseFormatter::success($owner, 'Owner Marketplace registered successfully!');
    }
}

