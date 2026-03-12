<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListBarangController; 
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\LoginController;

//Route::get('/', function () {
// return view('welcome');
//});

Route::get('/', [HomeController::class, 'index']);
Route::get('/contact', [HomeController::class, 'contact']);

Route :: get('/welcome', function () {return view('welcome');
});
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
Route::get('/dashboard/{id}/{nama}', [DashboardController::class, 'index']);
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate']);
