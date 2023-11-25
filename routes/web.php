<?php

use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\MahasiswaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [AuthController::class, 'halaman_login'])->name('login');
Route::post('/login', [AuthController::class, 'login_action'])->name('login.action');

Route::get('/regis', [AuthController::class, 'halaman_regis'])->name('regis');
Route::post('/regis', [AuthController::class, 'regis_action']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'OnlyAdmin']], function () {
    Route::get('/dashboard-admin', [AuthController::class, 'dashboard_admin']);

    // mahasiswa
    Route::get('/admin/mahasiswa', [MahasiswaController::class, 'index']);
    Route::post('/admin/mahasiswa/update/{id}', [MahasiswaController::class, 'update']);
    Route::get('/admin/mahasiswa/delete/{id}', [MahasiswaController::class, 'destroy']);

    Route::get('/matkul-list', function (Request $request) {
        $matkul = Matkul::where('user_id', $request->penguji)->get();

        return response()->json($matkul);
    });

    // dosen
    Route::get('/admin/dosen', [DosenController::class, 'index']);
    Route::post('/admin/dosen', [DosenController::class, 'store']);
    Route::post('/admin/dosen/update/{id}', [DosenController::class, 'update']);
    Route::get('/admin/dosen/delete/{id}', [DosenController::class, 'destroy']);

    // matkul
    Route::get('/admin/matkul', [MatkulController::class, 'index']);
    Route::post('/admin/matkul', [MatkulController::class, 'store']);
    Route::post('/admin/matkul/update/{id}', [MatkulController::class, 'update']);
    Route::get('/admin/matkul/delete/{id}', [MatkulController::class, 'destroy']);
});

Route::group(['middleware' => ['auth', 'OnlyDosen']], function () {
    Route::get('/dashboard-dosen', [AuthController::class, 'dashboard_dosen']);

    Route::get('/dosen/matkul/{id}', [SoalController::class, 'soal_matkul']);
    Route::post('/dosen/soal', [SoalController::class, 'store']);
    Route::post('/dosen/soal/edit/{id}', [SoalController::class, 'update']);
    Route::get('/dosen/soal/hapus/{id}', [SoalController::class, 'destroy']);
    Route::get('/soal/jawaban/{id}', [JawabanController::class, 'edit']);
    Route::post('/soal/jawaban/{id}', [JawabanController::class, 'update']);

    Route::get('/soal-mudah', [SoalController::class, 'index_mudah']);
    Route::post('/soal-mudah', [SoalController::class, 'store_mudah']);
    Route::get('/soal-menengah', [SoalController::class, 'index_menengah']);
    Route::post('/soal-menengah', [SoalController::class, 'store_menengah']);
    Route::get('/soal-sulit', [SoalController::class, 'index_sulit']);
    Route::post('/soal-sulit', [SoalController::class, 'store_sulit']);
    Route::post('/countdown-mudah', [SoalController::class, 'countdown_mudah']);
    Route::post('/countdown-menengah', [SoalController::class, 'countdown_menengah']);
    Route::post('/countdown-sulit', [SoalController::class, 'countdown_sulit']);
    Route::post('/countdown/edit/{id}', [SoalController::class, 'countdownEdit']);
    Route::get('/countdown/hapus/{id}', [SoalController::class, 'countdownHapus']);
});

Route::group(['middleware' => ['auth', 'OnlyMahasiswa']], function () {
    Route::get('/dashboard-mahasiswa', [AuthController::class, 'dashboard_mahasiswa']);
});
