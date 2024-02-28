<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\MahasiswaController;

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
    if ($request->user()->sk_kompren) {
        $request->user()->sk_kompren = url('/') . '/storage/skKompren/' . $request->user()->sk_kompren;
    }
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register_api']);
Route::post('/login', [AuthController::class, 'login_api']);
Route::get('/logout', [AuthController::class, 'logout_api'])->middleware('auth:sanctum');

Route::get('/login-gagal', [AuthController::class, 'login_gagal'])->name('login_gagal');
Route::get('/start-gagal', [SoalController::class, 'start_gagal'])->name('start_gagal');

Route::group(['middleware' => ['auth:sanctum', 'OnlyDosen']], function () {
    Route::get('/get-matkul-dosen', [AuthController::class, 'get_matkul_api']);
    Route::get('/dashboard-dosen', [AuthController::class, 'dashboard_dosen_api']);

    Route::get('/dosen/matkul/{id}', [SoalController::class, 'soal_matkul_api']);
    Route::post('/dosen/soal', [SoalController::class, 'store_api']);
    Route::get('/dosen/soal/edit/{id}', [SoalController::class, 'edit_api']);
    Route::post('/dosen/soal/edit/{id}', [SoalController::class, 'update_api']);
    Route::get('/dosen/soal/hapus/{id}', [SoalController::class, 'destroy_api']);
    Route::get('/soal/jawaban/{id}', [JawabanController::class, 'edit_api']);
    Route::post('/soal/jawaban/{id}', [JawabanController::class, 'update_api']);
    Route::post('/dosen/finish/{id}', [SoalController::class, 'set_finish_api']);
    Route::get('/dosen/end/{id}', [SoalController::class, 'set_end_api']);

    Route::get('/dosen/pengujian/{id}', [MahasiswaController::class, 'pengujian_dosen_api']);
    Route::get('/dosen/dapat-ujian/{id}/{user_id}', [MahasiswaController::class, 'dapat_ujian_api']);

    Route::get('/dosen/penilaian/{id}', [MahasiswaController::class, 'penilaian_dosen_api']);
    Route::get('/dosen/nilai/{id}/{user_id}', [MahasiswaController::class, 'nilai_mahasiswa_api']);
    Route::get('/dosen/remidial/{id}/{user_id}', [MahasiswaController::class, 'remidial_api']);
    Route::post('/kirim-nilai/pdf', [DosenController::class, 'pdf_api']);
    Route::get('/dosen/batal-kirim/{id}/{user_id}', [DosenController::class, 'batal_kirim_api']);

    Route::get('/dosen/list-mahasiswa/{id}', [MahasiswaController::class, 'list_mahasiswa_api']);
    Route::get('/dosen/detail-mahasiswa/{id}/{user_id}', [MahasiswaController::class, 'detail_mahasiswa_api']);
});

Route::group(['middleware' => ['auth:sanctum', 'OnlyMahasiswa']], function () {
    Route::get('/get-matkul-mahasiswa', [AuthController::class, 'get_pengujian_api']);
    Route::get('/dashboard-mahasiswa', [AuthController::class, 'dashboard_mahasiswa_api']);

    Route::get('/mahasiswa/matkul/{id}', [SoalController::class, 'ujian_mahasiswa_api']);
    Route::get('/mahasiswa/soal/{id}', [SoalController::class, 'soal_mahasiswa_api'])->middleware('StartUjian');
    Route::post('/mahasiswa/soal/{id}', [SoalController::class, 'jawab_mahasiswa_api'])->middleware('StartUjian');
    Route::post('/cetak/pdf', [MahasiswaController::class, 'pdf_api']);
    Route::get('/cetak/pdf/{id}', [MahasiswaController::class, 'pdf_matkul_api']);
});
