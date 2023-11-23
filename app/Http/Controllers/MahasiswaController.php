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
        return view('Admin.Mahasiswa.index', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $data = $request->all();

        $user->update($data);
        Alert::success('Success', 'Verifikasi akun berhasil');
        return redirect('/admin/mahasiswa');
    }


    public function destroy($id)
    {
        $user = User::find($id);

        // Hapus sk_kompren
        if (Storage::exists('public/skKompren/' . $user->sk_kompren)) {
            Storage::delete('public/skKompren/' . $user->sk_kompren);
        }

        $user->delete();
        Alert::success('Success', 'Berhasil menghapus akun');
        return redirect('/admin/mahasiswa');
    }
}
