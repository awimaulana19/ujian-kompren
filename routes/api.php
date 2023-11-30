<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SoalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register_api']);
Route::post('/login', [AuthController::class, 'login_api']);
Route::get('/login-gagal', [AuthController::class, 'login_gagal'])->name('login_gagal');
Route::get('/logout', [AuthController::class, 'logout_api'])->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum', 'OnlyDosen']], function () {
    Route::get('/dashboard-dosen', [AuthController::class, 'dashboard_dosen_api']);

    Route::get('/dosen/matkul/{id}', [SoalController::class, 'soal_matkul_api']);
    Route::post('/dosen/soal', [SoalController::class, 'store_api']);
    Route::post('/dosen/soal/edit/{id}', [SoalController::class, 'update_api']);
    Route::get('/dosen/soal/hapus/{id}', [SoalController::class, 'destroy_api']);
    // Route::get('/soal/jawaban/{id}', [JawabanController::class, 'edit']);
    // Route::post('/soal/jawaban/{id}', [JawabanController::class, 'update']);
    // Route::post('/dosen/finish/{id}', [SoalController::class, 'set_finish']);
    // Route::get('/dosen/end/{id}', [SoalController::class, 'set_end']);

    // Route::get('/dosen/pengujian/{id}', [MahasiswaController::class, 'pengujian_dosen']);
    // Route::get('/dosen/dapat-ujian/{id}/{user_id}', [MahasiswaController::class, 'dapat_ujian']);

    // Route::get('/dosen/penilaian/{id}', [MahasiswaController::class, 'penilaian_dosen']);
    // Route::get('/dosen/remidial/{id}/{user_id}', [MahasiswaController::class, 'remidial']);
    // Route::post('/kirim-nilai/pdf', [DosenController::class, 'pdf']);
    // Route::get('/dosen/batal-kirim/{id}/{user_id}', [DosenController::class, 'batal_kirim']);
});