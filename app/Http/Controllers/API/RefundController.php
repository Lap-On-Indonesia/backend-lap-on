<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RefundController extends Controller
{
    // Fungsi untuk mendapatkan daftar refund
    public function index()
    {
        $refunds = Refund::all(); // Ambil semua data refund

        return response()->json([
            'status' => 'success',
            'data' => $refunds,
        ], Response::HTTP_OK);
    }

    // Fungsi untuk mengonfirmasi refund
    public function confirm(Request $request, $id)
    {
        $refund = Refund::find($id);

        if (!$refund) {
            return response()->json([
                'status' => 'error',
                'message' => 'Refund not found',
            ], Response::HTTP_NOT_FOUND);
        }

        // Update status refund ke "completed"
        $refund->status = 'completed';
        $refund->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Refund has been confirmed',
            'data' => $refund,
        ], Response::HTTP_OK);
    }
}
 