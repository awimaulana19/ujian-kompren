<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function beranda()
    {
        return view('beranda');
    }

    public function halaman_login()
    {
        return view('login');
    }

    public function halaman_regis()
    {
        return view('regis');
    }

    public function regis_action(Request $request)
    {
        $request->validate([
            'sk_kompren' => 'required|file|mimes:pdf',
        ]);

        if ($request->has('sk_kompren')) {
            $file = $request->file('sk_kompren');
            $nama_file = time() . "_" . $file->getClientOriginalName();

            // Simpan file ke direktori storage
            $file->storeAs('skKompren', $nama_file);

            $hashedPassword = bcrypt($request->password);

            $penguji = json_encode([
                'penguji_1' => ['user_id' => 0, 'matkul_id' => 0, 'dapat_ujian' => false],
                'penguji_2' => ['user_id' => 0, 'matkul_id' => 0, 'dapat_ujian' => false],
                'penguji_3' => ['user_id' => 0, 'matkul_id' => 0, 'dapat_ujian' => false],
            ]);

            $nilai = json_encode([
                'nilai_penguji_1' => ['jumlah_benar' => 0, 'jumlah_salah' => 0, 'nilai_ujian' => null, 'remidial' => false, 'nilai_remidial' => null, 'sk' => null],
                'nilai_penguji_2' => ['jumlah_benar' => 0, 'jumlah_salah' => 0, 'nilai_ujian' => null, 'remidial' => false, 'nilai_remidial' => null, 'sk' => null],
                'nilai_penguji_3' => ['jumlah_benar' => 0, 'jumlah_salah' => 0, 'nilai_ujian' => null, 'remidial' => false, 'nilai_remidial' => null, 'sk' => null],
            ]);

            $regis = new User([
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => $hashedPassword,
                'roles' => $request->roles,
                'penguji' => $penguji,
                'nilai' => $nilai,
                'sk_kompren' => $nama_file,
            ]);

            $regis->save();
        }

        Alert::success('Sukses', 'Akun anda sedang diverfikasi');

        return redirect('/login');
    }

    public function dashboard_admin()
    {
        $soal_mudah = Soal::where('tingkat', '=', 'mudah')->count();
        $soal_menengah = Soal::where('tingkat', '=', 'menengah')->count();
        $soal_sulit = Soal::where('tingkat', '=', 'menengah')->count();
        return view('Admin.Dashboard.dashboard', compact('soal_mudah', 'soal_menengah', 'soal_sulit'));
    }

    public function dashboard_dosen()
    {
        $soal_mudah = Soal::where('tingkat', '=', 'mudah')->count();
        $soal_menengah = Soal::where('tingkat', '=', 'menengah')->count();
        $soal_sulit = Soal::where('tingkat', '=', 'menengah')->count();
        return view('Dosen.Dashboard.dashboard', compact('soal_mudah', 'soal_menengah', 'soal_sulit'));
    }

    public function dashboard_mahasiswa()
    {
        $soal_mudah = Soal::where('tingkat', '=', 'mudah')->count();
        $soal_menengah = Soal::where('tingkat', '=', 'menengah')->count();
        $soal_sulit = Soal::where('tingkat', '=', 'menengah')->count();

        return view('Mahasiswa.Dashboard.dashboard', compact('soal_mudah', 'soal_menengah', 'soal_sulit'));
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            if (Auth::user()->roles == 'admin') {
                return redirect('/dashboard-admin');
            } elseif (Auth::user()->roles == 'dosen') {
                return redirect('/dashboard-dosen');
            } else {
                if (auth()->user()->roles == 'mahasiswa' && auth()->user()->is_verification == true) {
                    return redirect('/dashboard-mahasiswa');
                } else {
                    return back()->with('pesan-danger', 'Akun anda belum di verifikasi oleh admin');
                }
            }
        }
        return back()->withErrors([
            'password' => 'Username atau Password anda salah',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function register_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'sk_kompren' => 'required|file|mimes:pdf',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran Gagal',
                'data' => $validator->errors()
            ]);
        }

        if ($request->has('sk_kompren')) {
            $file = $request->file('sk_kompren');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            
            $file->storeAs('skKompren', $nama_file);

            $hashedPassword = bcrypt($request->password);

            $penguji = json_encode([
                'penguji_1' => ['user_id' => 0, 'matkul_id' => 0, 'dapat_ujian' => false],
                'penguji_2' => ['user_id' => 0, 'matkul_id' => 0, 'dapat_ujian' => false],
                'penguji_3' => ['user_id' => 0, 'matkul_id' => 0, 'dapat_ujian' => false],
            ]);

            $nilai = json_encode([
                'nilai_penguji_1' => ['jumlah_benar' => 0, 'jumlah_salah' => 0, 'nilai_ujian' => null, 'remidial' => false, 'nilai_remidial' => null, 'sk' => null],
                'nilai_penguji_2' => ['jumlah_benar' => 0, 'jumlah_salah' => 0, 'nilai_ujian' => null, 'remidial' => false, 'nilai_remidial' => null, 'sk' => null],
                'nilai_penguji_3' => ['jumlah_benar' => 0, 'jumlah_salah' => 0, 'nilai_ujian' => null, 'remidial' => false, 'nilai_remidial' => null, 'sk' => null],
            ]);

            $regis = new User([
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => $hashedPassword,
                'roles' => 'mahasiswa',
                'penguji' => $penguji,
                'nilai' => $nilai,
                'sk_kompren' => $nama_file,
            ]);

            $regis->save();
        }

        $data['nama'] = $regis->nama;
        $data['username'] = $regis->username;
        $data['roles'] = $regis->roles;

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran Berhasil',
            'data' => $data
        ]);
    }

    public function login_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Login Gagal',
                'data' => $validator->errors()
            ]);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password salah',
                'data' => null
            ]);
        }

        if (!$user->is_verification) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda Belum Di Verifikasi Oleh Admin',
                'data' => null
            ]);
        }

        $data['token'] = $user->createToken('auth_token')->plainTextToken;
        $data['nama'] = $user->nama;
        $data['username'] = $user->username;
        $data['roles'] = $user->roles;

        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil',
            'data' => $data
        ]);
    }

    public function login_gagal()
    {
        return response()->json([
            'success' => false,
            'message' => 'Token Tidak Valid',
            'data' => null
        ]);
    }

    public function logout_api(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout Berhasil',
            'data' => null
        ]);
    }

    public function get_matkul_api()
    {
        $data = auth()->user()->matkul;

        return response()->json([
            'success' => true,
            'message' => 'Get Data Berhasil',
            'data' => $data
        ]);
    }

    public function dashboard_dosen_api()
    {
        $soal_mudah = Soal::where('tingkat', '=', 'mudah')->count();
        $soal_menengah = Soal::where('tingkat', '=', 'menengah')->count();
        $soal_sulit = Soal::where('tingkat', '=', 'menengah')->count();

        $data['soal_mudah'] = $soal_mudah;
        $data['soal_menengah'] = $soal_menengah;
        $data['soal_sulit'] = $soal_sulit;

        return response()->json([
            'success' => true,
            'message' => 'Get Data Berhasil',
            'data' => $data
        ]);
    }
}
