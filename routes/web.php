<?php

use App\Http\Controllers\Disposisi1Controller;
use App\Http\Controllers\Disposisi2Controller;
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

Route::get('dashboard/disposisi1/diteruskan/{suratmasuk}', [Disposisi1Controller::class, 'buat'])->middleware('auth');


// Kelola disposisi1 yang diteruskan :
Route::get('dashboard/disposisi1_diteruskan/create_diteruskan/{suratmasuk}', [Disposisi1Controller::class, 'create_diteruskan'])->middleware('auth');
Route::get('dashboard/disposisis1/{disposisi1}/edit_disposisi1_diteruskan', [Disposisi1Controller::class, 'edit_disposisi1_diteruskan'])->middleware('auth');
Route::post('dashboard/disposisi1/diteruskan', [Disposisi1Controller::class, 'store_disposisi1_diteruskan'])->middleware('auth');
Route::post('dashboard/disposisi1_diteruskan/{disposisi1}/update_disposisi1_diteruskan', [Disposisi1Controller::class, 'update_disposisi1_diteruskan'])->middleware('auth');

// Disposisi2 :
Route::resource('pengguna/disposisi2', Disposisi2Controller::class)->middleware(['auth', 'pengguna']);
Route::get('pengguna/disposisis2/create/{suratmasuk}', [Disposisi2controller::class, 'create'])->middleware(['auth', 'pengguna']);

// Route::dashboard pengguna : 
Route::get('dashboard/pengguna', [DashboardPengguna::class, 'index'])->middleware(['auth', 'pengguna']);

// Authenticate Controller : 
Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('logout', [LoginController::class, 'logout']);
Route::post('login', [LoginController::class, 'authenticate']);
