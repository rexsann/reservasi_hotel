<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LupaPasswordController;
use App\Http\Controllers\CodeVerificationController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AdminReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UserManagementController;

// ─── PUBLIC ROUTES ────────────────────────────────────────────
Route::get('/',            [HomeController::class, 'index']);
Route::get('/home',        [HomeController::class, 'index']);
Route::get('/about',       [AboutController::class, 'index']);
Route::get('/contact',     [ContactController::class, 'index']);
Route::get('/booking', [BookingController::class, 'index'])->name('booking')->middleware('auth');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store')->middleware('auth');
Route::get('/payment', [PaymentController::class, 'showPayment'])->name('payment.show');
Route::post('/payment/upload', [PaymentController::class, 'upload'])->name('payment.upload');
Route::post('/payment/order', [PaymentController::class, 'order'])->name('payment.order');
Route::post('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::get('/payment/check', [PaymentController::class, 'checkStatus'])->name('payment.check');
Route::get('/confirmation', [PaymentController::class, 'confirmation'])->name('payment.confirmation');
Route::get('/history', [ReservationController::class, 'index'])->name('history');
Route::get('/pembayaran/{id}', [ReservationController::class, 'pembayaran'])->name('pembayaran');

Route::get('/cek-status/{id}', [ReservationController::class, 'cekStatus']);
// halaman admin pembayaran
Route::get('/admin/pembayaran', [PembayaranController::class, 'index'])
    ->name('admin.pembayaran');

Route::post('/admin/pembayaran/{id}/status', [PembayaranController::class, 'updateStatus']);


// ─── RESERVATION (USER) ───────────────────────────────────────
Route::get('/reservation', fn() => view('pages.reservation'));
Route::post('/reservation/check', [ReservationController::class, 'check'])->name('reservation.check');

// ✅ TAMBAH INI
Route::get('/reservation/cek', [ReservationController::class, 'cek_reservasi'])->name('reservation.cek');

Route::get('/welcome', fn() => view('welcome'));
Route::get('/app',     fn() => view('app'));

Route::get('/user/{id}', fn($id) => 'User dengan ID ' . $id);

Route::post('/cart/add', function (Request $request) {

    $cart = session()->get('cart', []);

    $cart[] = [
        'room_name' => $request->room_name,
        'package' => $request->package,
        'price' => $request->price,
    ];

    session()->put('cart', $cart);

    return back();

})->name('cart.add');

Route::get('/history', [HistoryController::class, 'index'])
    ->name('Pages.history');



// ─── AUTH ROUTES ──────────────────────────────────────────────
Route::get('/registrasi',  [RegistrasiController::class, 'showRegistrasi']);
Route::post('/registrasi', [RegistrasiController::class, 'registrasi']);

Route::get('/login',       [LoginController::class, 'index'])->name('login');
Route::post('/login',      [LoginController::class, 'authenticate']);
Route::post('/logout',      [LoginController::class, 'logout'])->name('logout');

Route::get('/lupapassword', [LupaPasswordController::class, 'index']);
Route::post('/lupapassword', [LupaPasswordController::class, 'sendOtp'])->name('lupapassword');
Route::get('/verification', [CodeVerificationController::class, 'index'])->name('verification');
Route::post('/verification', [CodeVerificationController::class, 'verify'])->name('verification.post');
Route::get('/resetpassword', [ResetPasswordController::class, 'index'])->name('resetpassword');
Route::post('/resetpassword', [ResetPasswordController::class, 'update'])->name('resetpassword.post');

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::put('/profile/update', [ProfilController::class, 'update']);



// ─── ADMIN ROUTES ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users (placeholder)
Route::get('/users', [UserManagementController::class, 'index'])
    ->name('users');

    // Room Management
    Route::get('/rooms',           [RoomController::class, 'index'])  ->name('rooms.index');
    Route::get('/rooms/create',    [RoomController::class, 'create']) ->name('rooms.create');
    Route::post('/rooms',          [RoomController::class, 'store'])  ->name('rooms.store');
    Route::get('/rooms/{id}/edit', [RoomController::class, 'edit'])   ->name('rooms.edit');
    Route::put('/rooms/{id}',      [RoomController::class, 'update']) ->name('rooms.update');
    Route::delete('/rooms/{id}',   [RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::get('/rooms', [RoomController::class, 'index']);

    // Reservation Management
    Route::get('/reservations', function () {
    return view('admin.admin_reservation');
});
    // Reservation Management
 Route::get('/reservations/available-rooms', [AdminReservationController::class, 'availableRooms'])->name('reservations.available-rooms');
    Route::get('/reservations',              [AdminReservationController::class, 'index'])  ->name('reservations.index');
    Route::post('/reservations',             [AdminReservationController::class, 'store'])  ->name('reservations.store');
    Route::put('/reservations/{id}',         [AdminReservationController::class, 'update']) ->name('reservations.update');
    Route::delete('/reservations/{id}',      [AdminReservationController::class, 'destroy'])->name('reservations.destroy');


// 🔹 FACILITY MANAGEMENT ⭐
  Route::prefix('facility')->group(function () {

    Route::get('/', [FacilityController::class, 'index']);

    Route::post('/store', [FacilityController::class, 'store']);

    Route::delete('/{id}', [FacilityController::class, 'destroy']);

});

    // 🔹 OFFER MANAGEMENT ⭐
Route::get('/offers', [OfferController::class, 'index'])
    ->name('offers.index');

Route::post('/offers/store', [OfferController::class, 'store'])
    ->name('offers.store');

Route::put('/offers/{id}', [OfferController::class, 'update'])
    ->name('offers.update');

Route::delete('/offers/{id}', [OfferController::class, 'destroy'])
    ->name('offers.destroy');

});