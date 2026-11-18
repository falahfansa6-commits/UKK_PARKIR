<?php

use App\Http\Controllers\StrukController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/struk/{transaksi}', [StrukController::class, 'cetak'])
    ->middleware('auth')
    ->name('struk.cetak');


