<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaController extends Controller
{
    public function index()
    {
        $user = User::where('roles', 'mahasiswa')->get();
        $dosen = User::where('roles', 'dosen')->get();
        return view('Admin.Mahasiswa.index', compact('user', 'dosen'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'is_verification' => 'required',
            'penguji_1' => 'required',
            'penguji_2' => 'required',
            'penguji_3' => 'required',
            'matkul_1' => 'required',
            'matkul_2' => 'required',
            'matkul_3' => 'required',
        ]);

        $user = User::where('id', $id)->first();
        $user->is_verification = $request->is_verification;
        $user->penguji = json_encode([
            'penguji_1' => ['user_id' => $request->penguji_1, 'matkul_id' => $request->matkul_1],
            'penguji_2' => ['user_id' => $request->penguji_2, 'matkul_id' => $request->matkul_2],
            'penguji_3' => ['user_id' => $request->penguji_3, 'matkul_id' => $request->matkul_3],
        ]);

        $user->update();
        Alert::success('Success', 'Verifikasi akun berhasil');
        return redirect('/admin/mahasiswa');
    }


    public function destroy($id)
    {
        $user = User::find($id);

        // Hapus sk_kompren
        if (Storage::exists('skKompren/' . $user->sk_kompren)) {
            Storage::delete('skKompren/' . $user->sk_kompren);
        }

        $user->delete();
        Alert::success('Success', 'Berhasil menghapus akun');
        return redirect('/admin/mahasiswa');
    }
}
