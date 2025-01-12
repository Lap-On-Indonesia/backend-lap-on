<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OwnerMarketplace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterOwnerMarketplaceController extends Controller
{
    // Menampilkan form register
    public function showRegistrationForm()
    {
        return view('register_owner_marketplace.register_marketplace'); // Pastikan view ini ada
    }

    // Proses registrasi pengguna baru
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string|max:255',
            'link_maps' => 'required|url',
            'photo_store' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Periksa apakah email sudah terdaftar
        if (OwnerMarketplace::where('email', $request->email)->exists() || User::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'Email sudah terdaftar. Silakan gunakan email yang berbeda.')->withInput();
        }

        // Simpan foto toko
        if ($request->hasFile('photo_store')) {
            $photoPath = $request->file('photo_store')->store('photos', 'public');
        } else {
            return redirect()->back()->withErrors(['photo_store' => 'Photo store is required.'])->withInput();
        }

        // Buat data OwnerMarketplace
        $owner = OwnerMarketplace::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'store_name' => $request->store_name,
            'store_address' => $request->store_address,
            'link_maps' => $request->link_maps,
            'photo_store' => $photoPath,
        ]);

        // Buat data User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'owner_marketplace_id' => $owner->id
        ]);

        // Redirect ke halaman status dengan pesan sukses
        return view('status.index')->with('success', 'Registrasi berhasil!');
    }
}
