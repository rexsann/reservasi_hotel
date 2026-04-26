<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListBarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LupaPasswrodController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AdminReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\OfferController;

// ─── PUBLIC ROUTES ────────────────────────────────────────────
Route::get('/',            [HomeController::class, 'index']);
Route::get('/home',        [HomeController::class, 'index']);
Route::get('/about',       [AboutController::class, 'index']);
Route::get('/contact',     [ContactController::class, 'index']);
Route::get('/detail',      [DetailController::class, 'index']);
Route::get('/kamar',       [KamarController::class, 'index']);
Route::get('/dashboard',   [DashboardController::class, 'tampilkan']);

Route::get('/welcome', fn() => view('welcome'));
Route::get('/app',     fn() => view('app'));

Route::get('/list_barang/{id}/{nama}', [ListBarangController::class, 'tampilkan']);
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



// ─── AUTH ROUTES ──────────────────────────────────────────────
Route::get('/registrasi',  [RegistrasiController::class, 'showRegistrasi']);
Route::post('/registrasi', [RegistrasiController::class, 'registrasi']);

Route::get('/login',       [LoginController::class, 'index'])->name('login');
Route::post('/login',      [LoginController::class, 'authenticate']);
Route::get('/logout',      [LoginController::class, 'logout'])->name('logout');

Route::get('/lupapassword',  [LupaPasswrodController::class, 'index']);
Route::post('/lupapassword', [LupaPasswrodController::class, 'resetPassword']);

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
    Route::get('/reservations',           [AdminReservationController::class, 'index'])  ->name('reservations.index');
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