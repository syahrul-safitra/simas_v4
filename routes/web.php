<?php

use App\Http\Controllers\Disposisi1Controller;
use App\Http\Controllers\Disposisi2Controller;
use App\Http\Controllers\Disposisi3Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardPengguna;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\InformasiController;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Support\Facades\Route;

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

    return view('index', [
        'seluruhSuratMasuk' => SuratMasuk::seluruh_surat_masuk(),
        'suratMasukBlnIni' => SuratMasuk::surat_masuk_bulan_ini(),
        'seluruhSuratKeluar' => SuratKeluar::seluruh_surat_keluar(),
        'suratKeluarBlnIni' => SuratKeluar::surat_keluar_bulan_ini()
    ]);
})->middleware(['auth', 'master']);

// NOTE : Controller Surat Masuk :
// Resource SuratMasuk Controller :
Route::resource('dashboard/suratmasuk', SuratMasukController::class)->middleware(['auth', 'master']);
// Cetak surat masuk : 
Route::post('dashboard/suratmasuks/cetak', [SuratMasukController::class, 'cetak'])->middleware('auth', 'master');


// NOTE : Controller Disposisi1 : 
// Resource Disposisi1 : 
Route::resource('dashboard/disposisi1', Disposisi1Controller::class)->middleware(['auth', 'kasubag']);
Route::get('dashboard/disposisis1/create/{suratmasuk}', [Disposisi1Controller::class, 'create'])->middleware(['auth', 'kasubag']);

// Disposisi1 Diteruskan edit & update : 
Route::get('dashboard/disposisi1_diteruskan/create_diteruskan/{suratmasuk}', [Disposisi1Controller::class, 'create_diteruskan'])->middleware(['auth', 'kasubag']);
Route::get('dashboard/disposisis1/{disposisi1}/edit_disposisi1_diteruskan', [Disposisi1Controller::class, 'edit_disposisi1_diteruskan'])->middleware(['auth', 'kasubag']);
Route::post('dashboard/disposisi1/diteruskan', [Disposisi1Controller::class, 'store_disposisi1_diteruskan'])->middleware(['auth', 'kasubag']);
Route::post('dashboard/disposisi1_diteruskan/{disposisi1}/update_disposisi1_diteruskan', [Disposisi1Controller::class, 'update_disposisi1_diteruskan'])->middleware(['auth', 'kasubag']);
Route::post('dashboard/disposisi1/{disposisi1}/verifikasi', [Disposisi1Controller::class, 'verifikasi'])->middleware(['auth', 'kasubag']);
Route::post('dashboard/disposisi1/{disposisi1}/arsipkan', [Disposisi1Controller::class, 'arsipkan'])->middleware(['auth', 'kasubag']);
Route::get('dashboard/disposisi1/{disposisi1}/cetak', [Disposisi1Controller::class, 'cetak'])->middleware('auth');


// NOTE : Controller Disposisi2 :
// Disposisi2 :
Route::resource('pengguna/disposisi2', Disposisi2Controller::class)->middleware(['auth', 'pengguna']);
Route::get('pengguna/disposisis2/create/{suratmasuk}', [Disposisi2controller::class, 'create'])->middleware(['auth', 'pengguna']);

// Disposisi2 yang diteruskan : edit & update :  
Route::get('pengguna/disposisis2/create_diteruskan/{suratmasuk}', [Disposisi2Controller::class, 'create_diteruskan'])->middleware(['auth', 'pengguna']);
Route::post('pengguna/disposisis2/diteruskan', [Disposisi2Controller::class, 'store_disposisi2_diteruskan'])->middleware(['auth', 'pengguna']);
Route::get('pengguna/disposisi2/{disposisi2}/edit_disposisi2_diteruskan', [Disposisi2Controller::class, 'edit_disposisi2_diteruskan'])->middleware(['auth', 'pengguna']);
Route::post('pengguna/disposisi2_diteruskan/{disposisi2}/update_disposisi2_diteruskan', [Disposisi2Controller::class, 'update_disposisi2_diteruskan'])->middleware(['auth', 'pengguna']);

// Route::get('dashboard/disposisi1/diteruskan/{suratmasuk}', [Disposisi1Controller::class, 'buat'])->middleware('auth');


// NOTE : Controller Disposisi3 :
// LANJUTAN DISPOSISI : 
Route::resource('pengguna/disposisi3', Disposisi3Controller::class)->middleware(['auth', 'pengguna']);
Route::get('pengguna/disposisis3/create/{suratmasuk}', [Disposisi3Controller::class, 'create'])->middleware(['auth', 'pengguna']);

// Route::dashboard pengguna : 
Route::get('dashboard/pengguna', [DashboardPengguna::class, 'index'])->middleware(['auth', 'pengguna']);

// NOTE : Controller Surat Keluar : 
Route::resource('dashboard/suratkeluar', SuratKeluarController::class)->middleware(['auth', 'master']);
Route::get('dashboard/suratkeluars/replyLetter', [SuratKeluarController::class, 'replyLetter'])->middleware(['auth', 'master']);
Route::post('dashboard/suratkeluars/cetak', [SuratKeluarController::class, 'cetak'])->middleware(['auth', 'master']);

// NOTE : Controller User : 
Route::get('dashboard/user', [UserController::class, 'index'])->middleware(['auth', 'kasubag']);
Route::get('dashboard/user/{user}/edit', [UserController::class, 'edit'])->middleware(['auth', 'kasubag']);
Route::post('dashboard/user/{user}', [UserController::class, 'update'])->middleware(['auth', 'kasubag']);

// NOTE : Controller Informasi : 
Route::resource('dashboard/informasi', InformasiController::class)->middleware(['auth', 'kasubag']);

//  NOTE : Route Arsip Disposisi : 
Route::get('pengguna/arsipdisposisi', [DashboardPengguna::class, 'arsipDisposisi'])->middleware(['auth', 'master']);
Route::get('pengguna/arsipdisposisi/{disposisi}', [DashboardPengguna::class, 'lihatDisposisi'])->middleware(['auth', 'master']);

// NOTE : Controller Authentications : 
// Authenticate Controller : 
Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('logout', [LoginController::class, 'logout']);
Route::post('login', [LoginController::class, 'authenticate']);

// NOTE : Controller Disposisi Arsip : 
Route::get("dashboard/arsip_disposisi", [Disposisi1Controller::class, 'disposisi_arsip'])->middleware('master');
Route::get("dashboard/arsip_disposisi/{disposisi}", [Disposisi1Controller::class, 'lihatArsip'])->middleware('master');

Route::get('lihat_informasi', [InformasiController::class, 'lihatInformasi'])->middleware('guest');