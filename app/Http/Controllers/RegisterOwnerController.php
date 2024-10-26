<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterOwnerController extends Controller
{
    // Menampilkan form register
    public function showRegistrationForm()
    {
        return view('register_owner.register'); // Pastikan Anda memiliki view `auth.register` untuk form register
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
            'photo_store' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk photo_store
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Simpan foto toko
        // Pastikan file photo_store ada

        // dd($request->file('photo_store'));
        if ($request->hasFile('photo_store')) {
            // Simpan foto toko
            $photoPath = $request->file('photo_store')->store('photos', 'public');
        } else {
            // Jika file tidak ditemukan, kembalikan dengan pesan error
            return redirect()->back()->withErrors(['photo_store' => 'Photo store is required.'])->withInput();
        }

        // Buat data Owner terlebih dahulu
        $owner = Owner::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'store_name' => $request->store_name,
            'store_address' => $request->store_address,
            'link_maps' => $request->link_maps,
            'photo_store' => $photoPath,
        ]);

        // Buat data User dan kaitkan dengan Owner yang baru dibuat
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke halaman login atau halaman lain
        return view('status.index')->with('success', 'Registration successful!');
    }
}
