<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkDownload;

class LandingPageController extends Controller
{
    public function show()
    {
        // Mengambil semua data dari model LinkDownload
        $links = LinkDownload::all();

        // Mengirim data ke view landingpage.blade.php
        return view('landingpage', compact('links'));
    }
}
