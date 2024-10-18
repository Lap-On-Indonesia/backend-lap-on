<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use App\Mail\InquiryNotification;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'title' => 'required',
            'message' => 'required',
        ]);

        // Simpan data ke database
        $inquiry = Inquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'title' => $request->title,
            'message' => $request->message,
        ]);

        // Kirim notifikasi email ke admin
        // Mail::to(['reonaldi152@gmail.com', 'vindoraidan@gmail.com', 'khanzawatson@gmail.com', 'nandaputrirama29@gmail.com'])->send(new InquiryNotification($inquiry));
        Mail::to(['reonaldi152@gmail.com', 'vindoraidan@gmail.com', 'khanzawatson@gmail.com'])->send(new InquiryNotification($inquiry));
        // Mail::to(['reonaldi152@gmail.com'])->send(new InquiryNotification($inquiry));

        // Redirect atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Terima kasih, pesan Anda sudah diterima.');
    }
}
