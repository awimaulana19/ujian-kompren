<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StartUjian
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (request()->is('api*')) {
            $id = $request->route('id');

            $user = Auth::user();
            $penguji = json_decode($user->penguji);

            $matkul = Matkul::where('id', $id)->first();

            if (!$matkul) {
                return response()->json([
                    'success' => false,
                    'message' => 'Id Matkul Tidak Ditemukan',
                    'data' => null
                ], 404);
            }

            if ($penguji->penguji_1->matkul_id == $matkul->id) {
                $dapat_ujian = $penguji->penguji_1->dapat_ujian;
            }
            if ($penguji->penguji_2->matkul_id == $matkul->id) {
                $dapat_ujian = $penguji->penguji_2->dapat_ujian;
            }
            if ($penguji->penguji_3->matkul_id == $matkul->id) {
                $dapat_ujian = $penguji->penguji_3->dapat_ujian;
            }

            $finish_date = $matkul->finish_date;
            $finish_time = $matkul->finish_time;

            if ($finish_date && $finish_time && $dapat_ujian) {
                return $next($request);
            }

            return response()->json([
                'success' => false,
                'message' => 'Anda Belum Diizinkan Untuk Ujian',
                'data' => null
            ], 404);
        } else {
            $id = $request->route('id');

            $user = Auth::user();
            $penguji = json_decode($user->penguji);

            $matkul = Matkul::where('id', $id)->first();

            if (!$matkul) {
                return redirect()->back();
            }

            if ($penguji->penguji_1->matkul_id == $matkul->id) {
                $dapat_ujian = $penguji->penguji_1->dapat_ujian;
            }
            if ($penguji->penguji_2->matkul_id == $matkul->id) {
                $dapat_ujian = $penguji->penguji_2->dapat_ujian;
            }
            if ($penguji->penguji_3->matkul_id == $matkul->id) {
                $dapat_ujian = $penguji->penguji_3->dapat_ujian;
            }

            $finish_date = $matkul->finish_date;
            $finish_time = $matkul->finish_time;

            if ($finish_date && $finish_time && $dapat_ujian) {
                return $next($request);
            }

            return redirect('/mahasiswa/matkul/' . $id)->with('error', 'Anda Belum Diizinkan Untuk Ujian');
        }
    }
}
