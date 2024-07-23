<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Matkul;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    public function index()
    {
        $user = User::where('roles', 'dosen')->get();
        $matakuliah = Matakuliah::get();
        return view('Admin.Dosen.index', compact('user', 'matakuliah'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'matakuliah_id' => 'required|array|min:1',
            'matakuliah_id.*' => 'integer|exists:matakuliahs,id',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', 'Mata Kuliah Tidak Boleh Kosong');

            return redirect('/admin/dosen');
        }

        $already_username = User::where('username', $request->username)->first();

        if ($already_username) {
            Alert::error('Gagal', 'Usernname/Nip Sudah Ada');

            return redirect('/admin/dosen');
        }

        $hashedPassword = bcrypt($request->password);

        $user = new User([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $hashedPassword,
            'roles' => $request->roles,
            'is_verification' => $request->is_verification,
        ]);
        $user->save();

        foreach ($request->matakuliah_id as $item) {
            $matakuliah = Matakuliah::where('id', $item)->first();
            $matkul = new Matkul();

            $matkul->nama = $matakuliah->nama;
            $matkul->matakuliah_id = $matakuliah->id;
            $matkul->user_id = $user->id;
            $matkul->save();
        }

        Alert::success('Sukses', 'Berhasil menambah data');

        return redirect('/admin/dosen');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'matakuliah_id' => 'required|array|min:1',
            'matakuliah_id.*' => 'integer|exists:matakuliahs,id',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', 'Mata Kuliah Tidak Boleh Kosong');

            return redirect('/admin/dosen');
        }

        $user = User::findOrFail($id);
        $data = $request->all();

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        $matkuls_to_delete = Matkul::where('user_id', $id)
            ->whereNotIn('matakuliah_id', $request->matakuliah_id)
            ->get();

        foreach ($matkuls_to_delete as $matkul) {
            $matkul->delete();
        }

        foreach ($request->matakuliah_id as $item) {
            $matakuliah = Matakuliah::where('id', $item)->first();
            $matkul = Matkul::where('user_id', $id)->where('matakuliah_id', $item)->first();

            if (!$matkul) {
                $buat_matkul = new Matkul();
                $buat_matkul->nama = $matakuliah->nama;
                $buat_matkul->matakuliah_id = $matakuliah->id;
                $buat_matkul->user_id = $user->id;
                $buat_matkul->save();
            } else {
                $matkul->nama = $matakuliah->nama;
                $matkul->update();
            }
        }

        Alert::success('Success', 'Berhasil mengupdate data');
        return redirect('/admin/dosen');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();
        Alert::success('Success', 'Berhasil menghapus akun');
        return redirect('/admin/dosen');
    }

    public function lihat_mahasiswa_diuji($dosen, $id)
    {
        $dosen = User::where('id', $dosen)->first();
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

        return view('Admin.Dosen.mahasiswa', compact('mahasiswa', 'matkul_pengujian'));
    }

    public function lihat_bank_soal($id)
    {
        $matkul = Matkul::where('id', $id)->first();

        return view('Admin.Dosen.soal', compact('matkul'));
    }

    public function pdf(Request $request)
    {
        $signature = $request->input('signature');
        $signature = str_replace('data:image/png;base64,', '', $signature);
        $signature = str_replace(' ', '+', $signature);
        $imageName = auth()->user()->username . '.png';
        File::put(public_path('signatures') . '/' . $imageName, base64_decode($signature));

        $user = User::where('username', $request->nim_mahasiswa)->first();
        $matkul = Matkul::where('id', $request->mata_kuliah_id)->first();
        $originalData = json_decode($user->nilai, true);

        $penguji = json_decode($user->penguji);

        if ($matkul->id == $penguji->penguji_1->matkul_id && $matkul->user_id == $penguji->penguji_1->user_id) {
            $originalData['nilai_penguji_1']['nilai_praktik'] = $request->nilai_praktik;
            if ($originalData['nilai_penguji_1']['remidial']) {
                $originalData['nilai_penguji_1']['nilai_ujian'] = $request->nilai_angka;
            }
            $originalData['nilai_penguji_1']['sk'] = $request->tanggal_sk;
            $originalData['nilai_penguji_1']['keterangan'] = $request->keterangan;
            $tanggal_sk = $originalData['nilai_penguji_1']['sk'];
            $keterangan = $originalData['nilai_penguji_1']['keterangan'];
        }
        if ($matkul->id == $penguji->penguji_2->matkul_id && $matkul->user_id == $penguji->penguji_2->user_id) {
            $originalData['nilai_penguji_2']['nilai_praktik'] = $request->nilai_praktik;
            if ($originalData['nilai_penguji_2']['remidial']) {
                $originalData['nilai_penguji_2']['nilai_ujian'] = $request->nilai_angka;
            }
            $originalData['nilai_penguji_2']['sk'] = $request->tanggal_sk;
            $originalData['nilai_penguji_2']['keterangan'] = $request->keterangan;
            $tanggal_sk = $originalData['nilai_penguji_2']['sk'];
            $keterangan = $originalData['nilai_penguji_2']['keterangan'];
        }
        if ($matkul->id == $penguji->penguji_3->matkul_id && $matkul->user_id == $penguji->penguji_3->user_id) {
            $originalData['nilai_penguji_3']['nilai_praktik'] = $request->nilai_praktik;
            if ($originalData['nilai_penguji_3']['remidial']) {
                $originalData['nilai_penguji_3']['nilai_ujian'] = $request->nilai_angka;
            }
            $originalData['nilai_penguji_3']['sk'] = $request->tanggal_sk;
            $originalData['nilai_penguji_3']['keterangan'] = $request->keterangan;
            $tanggal_sk = $originalData['nilai_penguji_3']['sk'];
            $keterangan = $originalData['nilai_penguji_3']['keterangan'];
        }

        $updatedJson = json_encode($originalData);

        $user->nilai = $updatedJson;
        $user->update();

        $rata_rata_nilai = ($request->nilai_angka + $request->nilai_praktik) / 2;

        if ($rata_rata_nilai >= 90 && $rata_rata_nilai <= 100) {
            $nilai_huruf = "A";
        } else if ($rata_rata_nilai >= 80 && $rata_rata_nilai <= 89) {
            $nilai_huruf = "B";
        } else if ($rata_rata_nilai >= 70 && $rata_rata_nilai <= 79) {
            $nilai_huruf = "C";
        } else if ($rata_rata_nilai >= 60 && $rata_rata_nilai <= 69) {
            $nilai_huruf = "D";
        } else if ($rata_rata_nilai >= 0 && $rata_rata_nilai <= 59) {
            $nilai_huruf = "E";
        } else {
            $nilai_huruf = "Nilai tidak valid";
        }

        $signaturePath = public_path('/signatures/' . auth()->user()->username . '.png');
        $signatureBase64 = null;

        if (File::exists($signaturePath)) {
            $fileContents = File::get($signaturePath);
            $signatureBase64 = base64_encode($fileContents);
            $decoded = base64_decode($signatureBase64, true);
            if ($decoded !== false && $decoded !== null && strlen($decoded) > 0) {
                $signaturePath = '/signatures/' . auth()->user()->username . '.png';
            } else {
                $signaturePath = null;
            }
        } else {
            $signaturePath = null;
        }

        $pdf = PDF::loadView('Mahasiswa.SkPenilaian.skPDF', compact('request', 'tanggal_sk', 'keterangan', 'nilai_huruf', 'rata_rata_nilai', 'signaturePath'))->setPaper('A4', 'potrait')->setOptions(['defaultFont' => 'sans-serif']);

        $email = $user->username . '@uin-alauddin.ac.id';
        $subject = 'SK Penilaian Kompren';

        Mail::send('email.pemberitahuan', [], function ($message) use ($email, $subject, $pdf) {
            $message->to($email)
                ->subject($subject)
                ->attachData($pdf->output(), 'SK_Penilaian_Kompren.pdf');
        });

        Alert::success('Success', 'Berhasil mengirim surat penilaian');

        return $pdf->download("Surat Penilaian {$user->nama}.pdf");
    }

    public function batal_kirim($id, $user_id)
    {
        $user = User::where('id', $user_id)->first();
        $matkul = Matkul::where('id', $id)->first();
        $originalData = json_decode($user->nilai, true);

        $penguji = json_decode($user->penguji);

        if ($matkul->id == $penguji->penguji_1->matkul_id && $matkul->user_id == $penguji->penguji_1->user_id) {
            $originalData['nilai_penguji_1']['sk'] = null;
            $originalData['nilai_penguji_1']['keterangan'] = null;
            if ($originalData['nilai_penguji_1']['remidial']) {
                $originalData['nilai_penguji_1']['nilai_ujian'] = $originalData['nilai_penguji_1']['nilai_remidial'];
            }
        }
        if ($matkul->id == $penguji->penguji_2->matkul_id && $matkul->user_id == $penguji->penguji_2->user_id) {
            $originalData['nilai_penguji_2']['sk'] = null;
            $originalData['nilai_penguji_2']['keterangan'] = null;
            if ($originalData['nilai_penguji_2']['remidial']) {
                $originalData['nilai_penguji_2']['nilai_ujian'] = $originalData['nilai_penguji_2']['nilai_remidial'];
            }
        }
        if ($matkul->id == $penguji->penguji_3->matkul_id && $matkul->user_id == $penguji->penguji_3->user_id) {
            $originalData['nilai_penguji_3']['sk'] = null;
            $originalData['nilai_penguji_3']['keterangan'] = null;
            if ($originalData['nilai_penguji_3']['remidial']) {
                $originalData['nilai_penguji_3']['nilai_ujian'] = $originalData['nilai_penguji_3']['nilai_remidial'];
            }
        }

        $updatedJson = json_encode($originalData);

        $user->nilai = $updatedJson;
        $user->update();

        Alert::success('Success', 'Berhasil membatalkan kirim nilai');
        return redirect()->back();
    }

    public function pdf_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dosen_penguji' => 'required',
            'mata_kuliah_id' => 'required|exists:matkuls,id',
            'mata_kuliah' => 'required',
            'nama_mahasiswa' => 'required',
            'nim_mahasiswa' => 'required|exists:users,username',
            'nilai_angka' => 'required',
            'tanggal_sk' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kirim SK Gagal',
                'data' => $validator->errors()
            ], 404);
        }

        $user = User::where('username', $request->nim_mahasiswa)->first();
        $matkul = Matkul::where('id', $request->mata_kuliah_id)->first();
        $originalData = json_decode($user->nilai, true);

        $penguji = json_decode($user->penguji);

        if ($matkul->id == $penguji->penguji_1->matkul_id && $matkul->user_id == $penguji->penguji_1->user_id) {
            if ($originalData['nilai_penguji_1']['remidial']) {
                $originalData['nilai_penguji_1']['nilai_ujian'] = $request->nilai_angka;
            }
            $originalData['nilai_penguji_1']['sk'] = $request->tanggal_sk;
            $originalData['nilai_penguji_1']['keterangan'] = $request->keterangan;
            $tanggal_sk = $originalData['nilai_penguji_1']['sk'];
            $keterangan = $originalData['nilai_penguji_1']['keterangan'];
        }
        if ($matkul->id == $penguji->penguji_2->matkul_id && $matkul->user_id == $penguji->penguji_2->user_id) {
            if ($originalData['nilai_penguji_2']['remidial']) {
                $originalData['nilai_penguji_2']['nilai_ujian'] = $request->nilai_angka;
            }
            $originalData['nilai_penguji_2']['sk'] = $request->tanggal_sk;
            $originalData['nilai_penguji_2']['keterangan'] = $request->keterangan;
            $tanggal_sk = $originalData['nilai_penguji_2']['sk'];
            $keterangan = $originalData['nilai_penguji_2']['keterangan'];
        }
        if ($matkul->id == $penguji->penguji_3->matkul_id && $matkul->user_id == $penguji->penguji_3->user_id) {
            if ($originalData['nilai_penguji_3']['remidial']) {
                $originalData['nilai_penguji_3']['nilai_ujian'] = $request->nilai_angka;
            }
            $originalData['nilai_penguji_3']['sk'] = $request->tanggal_sk;
            $originalData['nilai_penguji_3']['keterangan'] = $request->keterangan;
            $tanggal_sk = $originalData['nilai_penguji_3']['sk'];
            $keterangan = $originalData['nilai_penguji_3']['keterangan'];
        }

        $updatedJson = json_encode($originalData);

        $user->nilai = $updatedJson;
        $user->update();

        if ($request->nilai_angka >= 90 && $request->nilai_angka <= 100) {
            $nilai_huruf = "A";
        } else if ($request->nilai_angka >= 80 && $request->nilai_angka <= 89) {
            $nilai_huruf = "B";
        } else if ($request->nilai_angka >= 70 && $request->nilai_angka <= 79) {
            $nilai_huruf = "C";
        } else if ($request->nilai_angka >= 60 && $request->nilai_angka <= 69) {
            $nilai_huruf = "D";
        } else if ($request->nilai_angka >= 0 && $request->nilai_angka <= 59) {
            $nilai_huruf = "E";
        } else {
            $nilai_huruf = "Nilai tidak valid";
        }

        $pdf = PDF::loadView('Mahasiswa.SkPenilaian.skPDF', compact('request', 'tanggal_sk', 'keterangan', 'nilai_huruf'))->setPaper('A4', 'potrait')->setOptions(['defaultFont' => 'sans-serif']);
        $pdf->render();

        return $pdf->stream("Surat Penilaian {$user->nama}.pdf");
    }

    public function batal_kirim_api($id, $user_id)
    {
        $matkul = Matkul::where('id', $id)->first();

        if (!$matkul) {
            return response()->json([
                'success' => false,
                'message' => 'Batal Kirim Gagal, Id Matkul Tidak Ditemukan',
                'data' => null
            ], 404);
        }

        $user = User::where('id', $user_id)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Batal Kirim Gagal, Id User Tidak Ditemukan',
                'data' => null
            ], 404);
        }

        if (!$user->penguji) {
            return response()->json([
                'success' => false,
                'message' => 'Batal Kirim Gagal, Id User Bukan Mahasiswa',
                'data' => null
            ], 404);
        }

        $originalData = json_decode($user->nilai, true);

        $penguji = json_decode($user->penguji);

        if ($matkul->id == $penguji->penguji_1->matkul_id && $matkul->user_id == $penguji->penguji_1->user_id) {
            $originalData['nilai_penguji_1']['sk'] = null;
            $originalData['nilai_penguji_1']['keterangan'] = null;
            if ($originalData['nilai_penguji_1']['remidial']) {
                $originalData['nilai_penguji_1']['nilai_ujian'] = $originalData['nilai_penguji_1']['nilai_remidial'];
            }
        }
        if ($matkul->id == $penguji->penguji_2->matkul_id && $matkul->user_id == $penguji->penguji_2->user_id) {
            $originalData['nilai_penguji_2']['sk'] = null;
            $originalData['nilai_penguji_2']['keterangan'] = null;
            if ($originalData['nilai_penguji_2']['remidial']) {
                $originalData['nilai_penguji_2']['nilai_ujian'] = $originalData['nilai_penguji_2']['nilai_remidial'];
            }
        }
        if ($matkul->id == $penguji->penguji_3->matkul_id && $matkul->user_id == $penguji->penguji_3->user_id) {
            $originalData['nilai_penguji_3']['sk'] = null;
            $originalData['nilai_penguji_3']['keterangan'] = null;
            if ($originalData['nilai_penguji_3']['remidial']) {
                $originalData['nilai_penguji_3']['nilai_ujian'] = $originalData['nilai_penguji_3']['nilai_remidial'];
            }
        }

        $updatedJson = json_encode($originalData);

        $user->nilai = $updatedJson;
        $user->update();

        $user->makeHidden(['penguji', 'sk_kompren',  'is_verification', 'created_at', 'updated_at']);

        return response()->json([
            'success' => true,
            'message' => 'Batal Kirim Berhasil',
            'data' => $user
        ]);
    }
}
