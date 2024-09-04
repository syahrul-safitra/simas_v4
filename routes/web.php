<?php

use App\Http\Controllers\Disposisi1Controller;
use App\Http\Controllers\Disposisi2Controller;
use App\Http\Controllers\Disposisi3Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardPengguna;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratMasukController;

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

Route::get('/', function () {
    return view('index');
})->middleware(['auth', 'master']);

// Resource SuratMasuk Controller :
Route::resource('dashboard/suratmasuk', SuratMasukController::class)->middleware(['auth', 'master']);

// Resource Disposisi1 : 
Route::resource('dashboard/disposisi1', Disposisi1Controller::class)->middleware('auth');
Route::get('dashboard/disposisis1/create/{suratmasuk}', [Disposisi1Controller::class, 'create'])->middleware('auth');

// Disposisi1 Diteruskan edit & update : 
Route::get('dashboard/disposisi1_diteruskan/create_diteruskan/{suratmasuk}', [Disposisi1Controller::class, 'create_diteruskan'])->middleware('auth');
Route::get('dashboard/disposisis1/{disposisi1}/edit_disposisi1_diteruskan', [Disposisi1Controller::class, 'edit_disposisi1_diteruskan'])->middleware('auth');
Route::post('dashboard/disposisi1/diteruskan', [Disposisi1Controller::class, 'store_disposisi1_diteruskan'])->middleware('auth');
Route::post('dashboard/disposisi1_diteruskan/{disposisi1}/update_disposisi1_diteruskan', [Disposisi1Controller::class, 'update_disposisi1_diteruskan'])->middleware('auth');
Route::post('dashboard/disposisi1/{disposisi1}', [Disposisi1Controller::class, 'verifikasi'])->middleware('auth');
Route::get('dashboard/disposisi1/{disposisi1}/cetak', [Disposisi1Controller::class, 'cetak']);


// Disposisi2 :
Route::resource('pengguna/disposisi2', Disposisi2Controller::class)->middleware(['auth', 'pengguna']);
Route::get('pengguna/disposisis2/create/{suratmasuk}', [Disposisi2controller::class, 'create'])->middleware(['auth', 'pengguna']);

// Disposisi2 yang diteruskan : edit & update :  
Route::get('pengguna/disposisis2/create_diteruskan/{suratmasuk}', [Disposisi2Controller::class, 'create_diteruskan'])->middleware(['auth']);
Route::post('pengguna/disposisis2/diteruskan', [Disposisi2Controller::class, 'store_disposisi2_diteruskan'])->middleware('auth');
Route::get('pengguna/disposisi2/{disposisi2}/edit_disposisi2_diteruskan', [Disposisi2Controller::class, 'edit_disposisi2_diteruskan']);
Route::post('pengguna/disposisi2_diteruskan/{disposisi2}/update_disposisi2_diteruskan', [Disposisi2Controller::class, 'update_disposisi2_diteruskan'])->middleware('auth');

// Route::get('dashboard/disposisi1/diteruskan/{suratmasuk}', [Disposisi1Controller::class, 'buat'])->middleware('auth');

// LANJUTAN DISPOSISI : 
Route::resource('pengguna/disposisi3', Disposisi3Controller::class)->middleware('auth');
Route::get('pengguna/disposisis3/create/{suratmasuk}', [Disposisi3Controller::class, 'create'])->middleware('auth');

// Route::dashboard pengguna : 
Route::get('dashboard/pengguna', [DashboardPengguna::class, 'index'])->middleware(['auth', 'pengguna']);

// Authenticate Controller : 
Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('logout', [LoginController::class, 'logout']);
Route::post('login', [LoginController::class, 'authenticate']);
