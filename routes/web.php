<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LupaPasswrodController;
use App\Http\Controllers\LupaPasswordController;
use App\Http\Controllers\CodeVerificationController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\DetailController;
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

// ─── PUBLIC ROUTES ────────────────────────────────────────────
Route::get('/',            [HomeController::class, 'index']);
Route::get('/home',        [HomeController::class, 'index']);
Route::get('/about',       [AboutController::class, 'index']);
Route::get('/contact',     [ContactController::class, 'index']);
Route::get('/detail', [DetailController::class, 'index'])->name('detail');
Route::get('/booking', [PaymentController::class, 'fillData'])->name('booking.fill');
Route::post('/booking', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/payment', [PaymentController::class, 'showPayment'])->name('payment.show');
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


// halaman form (punya kamu)
Route::get('/cek_reservasi', [ReservationController::class, 'cek_reservasi']);

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
Route::get('/logout',      [LoginController::class, 'logout'])->name('logout');

Route::get('/lupapassword', [LupaPasswordController::class, 'index']);
Route::post('/lupapassword', [LupaPasswordController::class, 'sendOtp'])->name('lupapassword');
Route::get('/verification', [CodeVerificationController::class, 'index'])->name('verification');
Route::post('/verification', [CodeVerificationController::class, 'verify'])->name('verification.post');
Route::get('/resetpassword', [ResetPasswordController::class, 'index'])->name('resetpassword');
Route::post('/resetpassword', [ResetPasswordController::class, 'update'])->name('resetpassword.post');

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

// ─── RESERVATION (USER) ───────────────────────────────────────
Route::get('/reservation', fn() => view('pages.reservation'));
Route::post('/reservation/check', [ReservationController::class, 'check'])->name('reservation.check');

// ─── ADMIN ROUTES ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users (placeholder)
Route::get('/users', function () {
    return view('admin.user_management');
})->name('users');

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
    Route::get('/reservations/create',    [AdminReservationController::class, 'create']) ->name('reservations.create');
    Route::post('/reservations',          [AdminReservationController::class, 'store'])  ->name('reservations.store');
    Route::get('/reservations/{id}',      [AdminReservationController::class, 'show'])   ->name('reservations.show');
    Route::get('/reservations/{id}/edit', [AdminReservationController::class, 'edit'])   ->name('reservations.edit');
    Route::put('/reservations/{id}',      [AdminReservationController::class, 'update']) ->name('reservations.update');
    Route::delete('/reservations/{id}',   [AdminReservationController::class, 'destroy'])->name('reservations.destroy');


// 🔹 FACILITY MANAGEMENT ⭐
    Route::prefix('facilities')->name('facilities.')->group(function () {
        Route::get('/', [FacilityController::class, 'index'])->name('index');
    });


    // 🔹 OFFER MANAGEMENT ⭐
    Route::prefix('offers')->name('offers.')->group(function () {
        Route::get('/', [OfferController::class, 'index'])->name('index');
    });

});