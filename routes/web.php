<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListBarangController; 
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LupaPasswrodController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RoomController;

//Route::get('/', function () {
// return view('welcome');
//});

Route::get('/', [HomeController::class, 'index']);
Route::get('/contact', [ContactController::class, 'index']);

Route :: get('/welcome', function () {return view('welcome');
});

Route :: get('/app', function () {return view('app');
});

Route :: get('/home', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);

Route::get('/registrasi', [RegistrasiController::class, 'showRegistrasi']);
Route::post('/registrasi', [RegistrasiController::class, 'registrasi']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/lupapassword', [LupaPasswrodController::class, 'index']);
Route::post('/lupapassword', [LupaPasswrodController::class, 'resetPassword']);

Route :: get('/user/{id}', function ($id) {return 'User dengan ID ' . $id;
});

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

//Route::get('/list_barang/{id}/{nama}', function ($id, $nama) {
    //return view('list_barang', ['id' => $id, 'nama' => $nama]);
//  });
Route::get('/list_barang/{id}/{nama}', [ListBarangController::class, 'tampilkan']);
Route::get('/dashboard', [DashboardController::class, 'tampilkan']);

    Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/kamar', [KamarController::class, 'index']);

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/users', function () {
        return 'Admin Users';
    });

    // ROOM MANAGEMENT
    Route::get('/rooms', [RoomController::class, 'index'])->name('admin.rooms');
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('admin.rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('admin.rooms.store');
    Route::get('/rooms/{id}/edit', [RoomController::class, 'edit'])->name('admin.rooms.edit');
    Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('admin.rooms.update');
    Route::delete('/rooms/{id}', [RoomController::class, 'destroy'])->name('admin.rooms.destroy');

});