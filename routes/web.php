<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\HasilController;
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

    // dosen
    Route::get('/admin/dosen', [DosenController::class, 'index']);

    Route::get('/soal-mudah', [SoalController::class, 'index_mudah']);
    Route::post('/soal-mudah', [SoalController::class, 'store_mudah']);
    Route::get('/soal-menengah', [SoalController::class, 'index_menengah']);
    Route::post('/soal-menengah', [SoalController::class, 'store_menengah']);
    Route::get('/soal-sulit', [SoalController::class, 'index_sulit']);
    Route::post('/soal-sulit', [SoalController::class, 'store_sulit']);
    Route::post('/soal/edit/{id}', [SoalController::class, 'update']);
    Route::get('/soal/hapus/{id}', [SoalController::class, 'destroy']);
    Route::get('/soal/jawaban/{id}', [JawabanController::class, 'edit']);
    Route::post('/soal/jawaban/{id}', [JawabanController::class, 'update']);
    Route::post('/countdown-mudah', [SoalController::class, 'countdown_mudah']);
    Route::post('/countdown-menengah', [SoalController::class, 'countdown_menengah']);
    Route::post('/countdown-sulit', [SoalController::class, 'countdown_sulit']);
    Route::post('/countdown/edit/{id}', [SoalController::class, 'countdownEdit']);
    Route::get('/countdown/hapus/{id}', [SoalController::class, 'countdownHapus']);
});

Route::group(['middleware' => ['auth', 'OnlyMahasiswa']], function () {
    Route::get('/dashboard-mahasiswa', [AuthController::class, 'dashboard_mahasiswa']);
});
