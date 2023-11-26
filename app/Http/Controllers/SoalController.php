<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\User;
use App\Models\Hasil;
use App\Models\Matkul;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class SoalController extends Controller
{
    public function soal_matkul($id)
    {
        $matkul = Matkul::where('id', $id)->first();

        return view('Dosen.Matkul.index', compact('matkul'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'matkul_id' => 'required',
            'soal' => 'required|string|max:255',
            'tingkat' => 'required',
            'gambar_soal' => 'mimes:png,jpg,jpeg|max:10240',
        ]);

        $soal = new Soal();
        $soal->matkul_id = $validatedData['matkul_id'];
        $soal->soal = $validatedData['soal'];
        $soal->tingkat = $validatedData['tingkat'];
        if ($request->file('gambar_soal')) {
            $soal->gambar_soal = $request->file('gambar_soal')->store('gambar-soal');
        }
        $soal->save();

        $jawabanA = new Jawaban();
        $jawabanA->soal_id = $soal->id;
        $jawabanA->save();
        $jawabanB = new Jawaban();
        $jawabanB->soal_id = $soal->id;
        $jawabanB->save();
        $jawabanC = new Jawaban();
        $jawabanC->soal_id = $soal->id;
        $jawabanC->save();
        $jawabanD = new Jawaban();
        $jawabanD->soal_id = $soal->id;
        $jawabanD->save();
        $jawabanE = new Jawaban();
        $jawabanE->soal_id = $soal->id;
        $jawabanE->save();
        Alert::success('Success', 'Soal ditambahkan');
        return redirect()->back()->with('success', 'Soal Telah Dibuat.');
    }

    public function update(Request $request, $id)
    {
        $soal = Soal::where('id', $id)->first();

        $validatedData = $request->validate([
            'soal' => 'required|string|max:255',
            'tingkat' => 'required',
            'gambar_soal' => 'mimes:png,jpg,jpeg|max:10240',
        ]);

        $soal->soal = $validatedData['soal'];
        $soal->tingkat = $validatedData['tingkat'];
        if ($request->file('gambar_soal')) {
            if ($request->gambarSoalLama) {
                Storage::delete($request->gambarSoalLama);
            }
            $soal->gambar_soal = $request->file('gambar_soal')->store('gambar-soal');
        }
        $soal->update();

        Alert::success('Success', 'Soal Telah Diupdate');
        return redirect()->back()->with('success', 'Soal Telah Diupdate');
    }

    public function destroy($id)
    {
        $soal = Soal::where('id', $id)->first();
        $soal->delete();

        Alert::success('Success', 'Soal Telah Dihapus');
        return redirect()->back()->with('success', 'Soal Telah Dihapus');
    }

    public function set_finish(Request $request, $id)
    {
        $validatedData = $request->validate([
            'finish_date' => 'required',
            'finish_time' => 'required',
        ]);

        $finish = Matkul::where('id', $id)->first();

        $finish->finish_date = $validatedData['finish_date'];
        $finish->finish_time = $validatedData['finish_time'];
        $finish->update();

        Alert::success('Success', 'Waktu Pengerjaan Soal berhasil diatur');
        return redirect()->back()->with('success', 'Waktu Pengerjaan Soal berhasil diatur');
    }

    public function set_end($id)
    {
        $finish = Matkul::where('id', $id)->first();

        $finish->finish_date = null;
        $finish->finish_time = null;
        $finish->update();

        Alert::success('Success', 'Waktu Pengerjaan Soal berhasil diakhiri');
        return redirect()->back()->with('success', 'Waktu Pengerjaan Soal berhasil diakhiri');
    }

    public function ujian_mahasiswa($id)
    {
        $matkul = Matkul::where('id', $id)->first();
        $finish_date = $matkul->finish_date;
        $finish_time = $matkul->finish_time;

        return view('Mahasiswa.Matkul.index', compact('matkul', 'finish_date', 'finish_time'));
    }

    public function soal_mahasiswa($id)
    {
        $user = Auth::user();
        $nilai = Hasil::where('user_id', $user->id)->where('matkul_id', $id)->get();
        if ($nilai->isEmpty()) {
            $matkul = Matkul::where('id', $id)->first();
            $soal = Soal::where('matkul_id', $id)->get();

            return view('Mahasiswa.Matkul.soal', compact('matkul', 'soal'));
        }

        return redirect('/mahasiswa/matkul/' . $id)->with('error', 'Anda Sudah Mengerjakan Ujian');
    }

    public function jawab_mahasiswa(Request $request, $id, $user_id)
    {
        $hasil = Hasil::where('user_id', $user_id)->where('matkul_id', $id)->get();
        if ($hasil->isEmpty()) {
            $user = User::where('id', $user_id)->first();
            $matkul = Matkul::where('id', $id)->first();
            $soal = Soal::where('matkul_id', $matkul->id)->get();

            foreach ($soal as $item) {
                foreach ($item->jawaban as $pilih) {
                    if ($request->{'soal' . $item->id} == $pilih->id) {
                        if ($pilih->is_correct) {
                            $hasil = new Hasil();
                            $hasil->user_id = $user->id;
                            $hasil->matkul_id = $matkul->id;
                            $hasil->soal_id = $pilih->soal_id;
                            $hasil->benar = true;

                            $hasil->save();
                        } else {
                            $hasil = new Hasil();
                            $hasil->user_id = $user->id;
                            $hasil->matkul_id = $matkul->id;
                            $hasil->soal_id = $pilih->soal_id;
                            $hasil->benar = false;

                            $hasil->save();
                        }
                    }
                }
            }

            $jumlah_soal = $soal->count();
            $jumlahBenar = 0;
            $jumlahSalah = 0;

            $hasil = Hasil::where('user_id', $user->id)->where('matkul_id', $matkul->id)->get();

            foreach ($hasil as $item) {
                if ($item->benar) {
                    $jumlahBenar = $jumlahBenar + 1;
                }
                if (!$item->benar) {
                    $jumlahSalah = $jumlahSalah + 1;
                }
            }

            $nilai_ujian = ($jumlahBenar / $jumlah_soal) * 100;

            $originalData = json_decode($user->nilai, true);

            $penguji = json_decode($user->penguji);
            if ($matkul->id == $penguji->penguji_1->matkul_id && $matkul->user_id == $penguji->penguji_1->user_id) {
                $originalData['nilai_penguji_1']['jumlah_benar'] = $jumlahBenar;
                $originalData['nilai_penguji_1']['jumlah_salah'] = $jumlahSalah;
                $originalData['nilai_penguji_1']['nilai_ujian'] = $nilai_ujian;
            }
            if ($matkul->id == $penguji->penguji_2->matkul_id && $matkul->user_id == $penguji->penguji_2->user_id) {
                $originalData['nilai_penguji_2']['jumlah_benar'] = $jumlahBenar;
                $originalData['nilai_penguji_2']['jumlah_salah'] = $jumlahSalah;
                $originalData['nilai_penguji_2']['nilai_ujian'] = $nilai_ujian;
            }
            if ($matkul->id == $penguji->penguji_3->matkul_id && $matkul->user_id == $penguji->penguji_3->user_id) {
                $originalData['nilai_penguji_3']['jumlah_benar'] = $jumlahBenar;
                $originalData['nilai_penguji_3']['jumlah_salah'] = $jumlahSalah;
                $originalData['nilai_penguji_3']['nilai_ujian'] = $nilai_ujian;
            }

            $updatedJson = json_encode($originalData);

            $user->nilai = $updatedJson;
            $user->update();

            return redirect('/mahasiswa/matkul/' . $id)->with('success', 'Ujian Berhasil Di Kerjakan');
        }

        return redirect('/mahasiswa/matkul/' . $id)->with('error', 'Anda Sudah Mengerjakan Ujian');
    }
}
