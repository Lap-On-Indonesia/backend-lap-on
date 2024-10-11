<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KprController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\API\PaymentController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/login', [AuthController::class, 'login'])->name('login');
// Route::post('login', [AuthController::class, 'doLogin']);
// Route::get('/logout', [AuthController::class, 'logout']);

// Route::get('/', [PageController::class, 'user']);

// Route::prefix('/admin')->middleware('auth:admin')->group(
//     function () {
//         Route::get('/', [PageController::class, 'admin']);
//     }
// );
Route::get('/', function () {
    // return redirect('/admin');
    return view('landingpage');
});

Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');

Route::get('/pembayaran/sukses', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

// Route::post('/payment/success', [PaymentController::class, 'paymentSuccess']);

// routes/web.php
// Route::post('/kpr/simulation', [KprController::class, 'simulate'])->name('kpr.simulation');
// Route::get('/kpr/form', function () {
//     return view('kpr.form');
// })->name('kpr.form');
