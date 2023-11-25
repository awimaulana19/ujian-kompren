<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\User;
use App\Models\Hasil;
use App\Models\Matkul;
use App\Models\Countdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
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
            $file->storeAs('public/skKompren', $nama_file);

            $hashedPassword = bcrypt($request->password);

            $penguji = json_encode([
                'penguji_1' => ['user_id' => 0, 'matkul_id' => 0],
                'penguji_2' => ['user_id' => 0, 'matkul_id' => 0],
                'penguji_3' => ['user_id' => 0, 'matkul_id' => 0],
            ]);

            $regis = new User([
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => $hashedPassword,
                'roles' => $request->roles,
                'penguji' => $penguji,
                'sk_kompren' => $nama_file,
            ]);
        }
        $regis->save();

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
}
