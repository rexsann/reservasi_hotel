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
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/lupapassword', [LupaPasswrodController::class, 'index']);
Route::post('/lupapassword', [LupaPasswrodController::class, 'resetPassword']);

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

Route :: get('/user/{id}', function ($id) {return 'User dengan ID ' . $id;
});



Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return 'Admin Dashboard';
    });
    Route::get('/users', function () {
        return 'Admin Users';
    });
});
//Route::get('/list_barang/{id}/{nama}', function ($id, $nama) {
    //return view('list_barang', ['id' => $id, 'nama' => $nama]);
//  });
Route::get('/list_barang/{id}/{nama}', [ListBarangController::class, 'tampilkan']);
Route::get('/dashboard', [DashboardController::class, 'tampilkan']);

    Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/kamar', [KamarController::class, 'index']);
