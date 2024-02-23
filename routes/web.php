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

Route::get('/', [AuthController::class, 'beranda']);

Route::get('/login', [AuthController::class, 'halaman_login'])->name('login');
Route::post('/login', [AuthController::class, 'login_action'])->name('login.action');

Route::get('/regis', [AuthController::class, 'halaman_regis'])->name('regis');
Route::post('/regis', [AuthController::class, 'regis_action']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'OnlyAdmin']], function () {
    Route::get('/dashboard-admin', [AuthController::class, 'dashboard_admin']);

    // mahasiswa
    Route::get('/admin/mahasiswa/belum', [MahasiswaController::class, 'index']);
    Route::get('/admin/mahasiswa/telah', [MahasiswaController::class, 'telah']);
    Route::get('/admin/mahasiswa/tolak', [MahasiswaController::class, 'tolak']);
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
    Route::post('/dosen/finish/{id}', [SoalController::class, 'set_finish']);
    Route::get('/dosen/end/{id}', [SoalController::class, 'set_end']);
    Route::get('/soal/jawaban/{id}', [JawabanController::class, 'edit']);
    Route::post('/soal/jawaban/{id}', [JawabanController::class, 'update']);

    Route::get('/dosen/pengujian/{id}', [MahasiswaController::class, 'pengujian_dosen']);
    Route::get('/dosen/dapat-ujian/{id}/{user_id}', [MahasiswaController::class, 'dapat_ujian']);

    Route::get('/dosen/penilaian/{id}', [MahasiswaController::class, 'penilaian_dosen']);
    Route::get('/dosen/remidial/{id}/{user_id}', [MahasiswaController::class, 'remidial']);
    Route::post('/kirim-nilai/pdf', [DosenController::class, 'pdf']);
    Route::get('/dosen/batal-kirim/{id}/{user_id}', [DosenController::class, 'batal_kirim']);
});

Route::group(['middleware' => ['auth', 'OnlyMahasiswa']], function () {
    Route::get('/dashboard-mahasiswa', [AuthController::class, 'dashboard_mahasiswa']);

    Route::get('/mahasiswa/matkul/{id}', [SoalController::class, 'ujian_mahasiswa']);
    Route::get('/mahasiswa/soal/{id}', [SoalController::class, 'soal_mahasiswa'])->middleware('StartUjian');
    Route::post('/mahasiswa/soal/{id}/{user_id}', [SoalController::class, 'jawab_mahasiswa'])->middleware('StartUjian');
    Route::post('/cetak/pdf', [MahasiswaController::class, 'pdf']);
});

Route::get('/algoritma', [SoalController::class, 'unit_test']);
