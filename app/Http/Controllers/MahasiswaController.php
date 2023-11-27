<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hasil;
use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $originalData = json_decode($user->penguji, true);

        $originalData['penguji_1']['user_id'] = $request->penguji_1;
        $originalData['penguji_1']['matkul_id'] = $request->matkul_1;

        $originalData['penguji_2']['user_id'] = $request->penguji_2;
        $originalData['penguji_2']['matkul_id'] = $request->matkul_2;

        $originalData['penguji_3']['user_id'] = $request->penguji_3;
        $originalData['penguji_3']['matkul_id'] = $request->matkul_3;

        $updatedJson = json_encode($originalData);

        $user->penguji = $updatedJson;

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

    public function pengujian_dosen($id)
    {
        $dosen = Auth::user();
        $mahasiswa = [];
        $matkul_pengujian = Matkul::where('id', $id)->first();

        $user = User::where('roles', 'mahasiswa')->get();

        foreach ($user as $item) {
            $penguji = json_decode($item->penguji, true);

            foreach ($penguji as $key => $value) {
                if ($dosen->id == $value['user_id'] && $matkul_pengujian->id == $value['matkul_id']) {
                    $data_user = User::where('id', $item->id)->first();

                    $mahasiswa[] = $data_user;
                }
            }
        }

        return view('Dosen.Pengujian.index', compact('mahasiswa', 'matkul_pengujian'));
    }

    public function dapat_ujian($id, $user_id)
    {
        $dosen = Auth::user();
        $user = User::where('id', $user_id)->first();

        $originalData = json_decode($user->penguji, true);

        if ($dosen->id == $originalData['penguji_1']['user_id'] && $id == $originalData['penguji_1']['matkul_id']) {
            $originalData['penguji_1']['dapat_ujian'] = !$originalData['penguji_1']['dapat_ujian'];
        }
        if ($dosen->id == $originalData['penguji_2']['user_id']  && $id == $originalData['penguji_2']['matkul_id']) {
            $originalData['penguji_2']['dapat_ujian'] = !$originalData['penguji_2']['dapat_ujian'];
        }
        if ($dosen->id == $originalData['penguji_3']['user_id']  && $id == $originalData['penguji_3']['matkul_id']) {
            $originalData['penguji_3']['dapat_ujian'] = !$originalData['penguji_3']['dapat_ujian'];
        }

        $updatedJson = json_encode($originalData);

        $user->penguji = $updatedJson;
        $user->update();

        Alert::success('Success', 'Berhasil mengupdate data');
        return redirect()->back();
    }

    public function penilaian_dosen($id)
    {
        $dosen = Auth::user();
        $mahasiswa = [];
        $matkul_penilaian = Matkul::where('id', $id)->first();

        $user = User::where('roles', 'mahasiswa')->get();

        foreach ($user as $item) {
            $penguji = json_decode($item->penguji, true);

            foreach ($penguji as $key => $value) {
                if ($dosen->id == $value['user_id'] && $matkul_penilaian->id == $value['matkul_id']) {
                    $data_user = User::where('id', $item->id)->first();

                    $mahasiswa[] = $data_user;
                }
            }
        }

        return view('Dosen.Penilaian.index', compact('mahasiswa', 'matkul_penilaian'));
    }

    public function remidial($id, $user_id)
    {
        $hasil = Hasil::where('user_id', $user_id)->where('matkul_id', $id)->get();

        Hasil::destroy($hasil);

        $dosen = Auth::user();
        $user = User::where('id', $user_id)->first();

        $originalData = json_decode($user->penguji, true);
        $originalNilai = json_decode($user->nilai, true);

        if ($dosen->id == $originalData['penguji_1']['user_id'] && $id == $originalData['penguji_1']['matkul_id']) {
            $originalNilai['nilai_penguji_1']['remidial'] = true;
        }
        if ($dosen->id == $originalData['penguji_2']['user_id']  && $id == $originalData['penguji_2']['matkul_id']) {
            $originalNilai['nilai_penguji_2']['remidial'] = true;
        }
        if ($dosen->id == $originalData['penguji_3']['user_id']  && $id == $originalData['penguji_3']['matkul_id']) {
            $originalNilai['nilai_penguji_2']['remidial'] = true;
        }

        $updatedJson = json_encode($originalNilai);

        $user->nilai = $updatedJson;
        $user->update();

        Alert::success('Success', 'Berhasil mengupdate data');
        return redirect()->back();
    }
}
