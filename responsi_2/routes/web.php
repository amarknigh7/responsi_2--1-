<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'admin'], function() {
    Route::get('/admin', [HomeController::class, 'admin'])->name('admin');

    Route::get('/datamenu', [HomeController::class, 'datamenu'])->name('datamenu');
    Route::get('/paginated', [HomeController::class, 'paginated'])->name('paginated');

    Route::post('/insertmenu', [HomeController::class, 'insertmenu'])->name('insertmenu');

    Route::get('/tampildata/{id}', [HomeController::class, 'tampildata'])->name('tampildata');
    Route::post('/updatemenu/{id}', [HomeController::class, 'updatemenu'])->name('updatemenu');

    Route::get('/deletemenu/{id}', [HomeController::class, 'deletemenu'])->name('deletemenu');

    Route::get('/searchproduct', [HomeController::class, 'searchproduct'])->name('searchproduct');

    Route::get('/pesanan', [HomeController::class, 'pesanan'])->name('pesanan');

    Route::put('/tandaipesanan/{id}', [HomeController::class, 'tandaiSelesai'])->name('tandai_pesanan');


});

Route::group(['middleware' => 'user'], function() {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/paginatedU', [HomeController::class, 'paginatedU'])->name('paginatedU');

    Route::get('/searchproductU', [HomeController::class, 'searchproductU'])->name('searchproductU');

    Route::get('/get-menu-details/{id}', [HomeController::class, 'getMenuDetails']);

    Route::get('/filtermenu', [HomeController::class, 'filtermenu'])->name('filtermenu');

    Route::post('/tambahpesanan/{id}', [HomeController::class, 'tambahpesanan'])->name('tambahpesanan');

    Route::get('/pemesan', [HomeController::class, 'pemesan'])->name('pemesan');

    Route::get('/ambilpesanan/{id}', [HomeController::class, 'ambilpesanan'])->name('ambilpesanan');

    Route::post('/bayar', [HomeController::class, 'bayar'])->name('bayar');

    Route::get('/transaksi', [HomeController::class, 'transaksi'])->name('transaksi');

});


Route::controller(AuthController::class)->group(function () {
    Route::get('register','register')->name('register');
    Route::post('register','registrasi')->name('registrasi');

    Route::get('login','login')->name('login');
    Route::post('login','masuk')->name('masuk');

    Route::get('logout','logout')->name('logout');
});


