<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DosenController extends Controller
{
    public function index()
    {
        $user = User::where('roles', 'dosen')->get();
        return view('Admin.Dosen.index', compact('user'));
    }

    public function store(Request $request)
    {
        $hashedPassword = bcrypt($request->password);

        $user = new User([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $hashedPassword,
            'roles' => $request->roles,
            'is_verification' => $request->is_verification,
        ]);
        $user->save();

        Alert::success('Sukses', 'Berhasil menambah data');

        return redirect('/admin/dosen');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Ambil data dari request
        $data = $request->all();

        // Periksa apakah ada permintaan untuk mengubah kata sandi
        if ($request->has('password')) {
            // Hash kata sandi baru
            $data['password'] = bcrypt($request->password);
        }

        // Lakukan pembaruan data
        $user->update($data);

        // Tampilkan pesan sukses
        Alert::success('Success', 'Berhasil mengupdate data');

        // Redirect ke halaman yang diinginkan
        return redirect('/admin/dosen');
    }



    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();
        Alert::success('Success', 'Berhasil menghapus akun');
        return redirect('/admin/dosen');
    }
}
