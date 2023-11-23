<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\User;
use App\Models\Hasil;
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

    public function dashboard_admin()
    {
        $soal_mudah = Soal::where('tingkat', '=', 'mudah')->count();
        $soal_menengah = Soal::where('tingkat', '=', 'menengah')->count();
        $soal_sulit = Soal::where('tingkat', '=', 'menengah')->count();
        return view('Admin.Dashboard.dashboard', compact('soal_mudah', 'soal_menengah', 'soal_sulit'));
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            if (Auth::user()->roles == 'admin') {
                return redirect('/dashboard');
            } elseif (Auth::user()->roles == 'pengawas') {
                return redirect('/dashboard-pengawas');
            } else {
                if (auth()->user()->roles == 'peserta' && auth()->user()->is_verification == 1) {
                    return redirect('/home');
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
