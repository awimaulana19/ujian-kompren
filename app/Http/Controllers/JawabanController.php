<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Matkul;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class JawabanController extends Controller
{
    public function edit($id)
    {
        $soal = Soal::findOrFail($id);
        $jawaban = Jawaban::where('soal_id', $id)->get();
        $matkul = Matkul::findOrFail($soal->matkul_id);

        return view('Dosen.Matkul.jawaban', compact('soal', 'matkul', 'jawaban', 'id'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'matkul_id' => 'required',
            'soal' => 'required|string|max:255',
            'tingkat' => 'required',
            'gambar_soal' => 'mimes:png,jpg,jpeg|max:10240',
            'jawaban.*' => 'required|string|max:255', // Validasi untuk jawaban
            'gambar_jawaban.*' => 'mimes:png,jpg,jpeg|max:10240', // Validasi untuk gambar jawaban
            'benar' => 'required|string', // Validasi untuk jawaban benar
        ]);

        $soal = Soal::findOrFail($id);
        $soal->matkul_id = $validatedData['matkul_id'];
        $soal->soal = $validatedData['soal'];
        $soal->tingkat = $validatedData['tingkat'];
        if ($request->file('gambar_soal')) {
            $soal->gambar_soal = $request->file('gambar_soal')->store('gambar-soal');
        }
        $soal->save();

        // Hapus jawaban yang ada terlebih dahulu
        $soal->jawaban()->delete();

        // Simpan jawaban yang baru
        foreach ($request->jawaban as $index => $jawabanText) {
            $jawaban = new Jawaban();
            $jawaban->soal_id = $soal->id;
            $jawaban->jawaban = $jawabanText;
            $jawaban->is_correct = ($request->benar == chr(65 + $index)) ? true : false;

            if ($request->file('gambar_jawaban') && isset($request->file('gambar_jawaban')[$index])) {
                $jawaban->gambar_jawaban = $request->file('gambar_jawaban')[$index]->store('gambar-jawaban');
            }
            $jawaban->save();
        }

        Alert::success('Success', 'Soal dan jawaban berhasil diperbarui');
        return redirect('/dosen/matkul/' . $soal->matkul_id)->with('success', 'Soal dan jawaban berhasil diperbarui.');
    }


    public function edit_api($id)
    {
        $soal = Soal::where('id', $id)->first();

        if (!$soal) {
            return response()->json([
                'success' => false,
                'message' => 'Get Data Gagal, Id Soal Tidak Ditemukan',
                'data' => null
            ], 404);
        }

        $jawaban = Jawaban::where('soal_id', $id)->get();
        $matkul = Matkul::where('id', $soal->matkul_id)->first();

        foreach ($jawaban as $key => $value) {
            if ($key == 0) {
                $a = $value;
            } elseif ($key == 1) {
                $b = $value;
            } elseif ($key == 2) {
                $c = $value;
            } elseif ($key == 3) {
                $d = $value;
            } elseif ($key == 4) {
                $e = $value;
            }
        }

        if ($soal->gambar_soal) {
            $soal->gambar_soal = url('/') . '/storage/' . $soal->gambar_soal;
        }

        if ($a->gambar_jawaban) {
            $a->gambar_jawaban = url('/') . '/storage/' . $a->gambar_jawaban;
        }

        if ($b->gambar_jawaban) {
            $b->gambar_jawaban = url('/') . '/storage/' . $b->gambar_jawaban;
        }

        if ($c->gambar_jawaban) {
            $c->gambar_jawaban = url('/') . '/storage/' . $c->gambar_jawaban;
        }

        if ($d->gambar_jawaban) {
            $d->gambar_jawaban = url('/') . '/storage/' . $d->gambar_jawaban;
        }

        if ($e->gambar_jawaban) {
            $e->gambar_jawaban = url('/') . '/storage/' . $e->gambar_jawaban;
        }

        $soal->makeHidden(['created_at', 'updated_at']);
        $a->makeHidden(['created_at', 'soal_id', 'updated_at']);
        $b->makeHidden(['created_at', 'soal_id', 'updated_at']);
        $c->makeHidden(['created_at', 'soal_id', 'updated_at']);
        $d->makeHidden(['created_at', 'soal_id', 'updated_at']);
        $e->makeHidden(['created_at', 'soal_id', 'updated_at']);

        $data['soal'] = $soal;
        $data['a'] = $a;
        $data['b'] = $b;
        $data['c'] = $c;
        $data['d'] = $d;
        $data['e'] = $e;

        return response()->json([
            'success' => true,
            'message' => 'Get Data Berhasil',
            'data' => $data
        ]);
    }

    public function update_api(Request $request, $id)
    {
        $soal = Soal::where('id', $id)->first();

        if (!$soal) {
            return response()->json([
                'success' => false,
                'message' => 'Update Data Gagal, Id Soal Tidak Ditemukan',
                'data' => null
            ], 404);
        }

        $jawaban = Jawaban::where('soal_id', $id)->get();

        foreach ($jawaban as $key => $value) {
            if ($key == 0) {
                $value->jawaban = $request->jawabanA;
                if ($request->file('gambar_jawabanA')) {
                    if ($value->gambar_jawaban) {
                        Storage::delete($value->gambar_jawaban);
                    }
                    $value->gambar_jawaban = $request->file('gambar_jawabanA')->store('gambar-jawaban');
                }
                if ($request->benar == "A") {
                    $value->is_correct = true;
                } else {
                    $value->is_correct = false;
                }
                $value->update();
            } elseif ($key == 1) {
                $value->jawaban = $request->jawabanB;
                if ($request->file('gambar_jawabanB')) {
                    if ($value->gambar_jawaban) {
                        Storage::delete($value->gambar_jawaban);
                    }
                    $value->gambar_jawaban = $request->file('gambar_jawabanB')->store('gambar-jawaban');
                }
                if ($request->benar == "B") {
                    $value->is_correct = true;
                } else {
                    $value->is_correct = false;
                }
                $value->update();
            } elseif ($key == 2) {
                $value->jawaban = $request->jawabanC;
                if ($request->file('gambar_jawabanC')) {
                    if ($value->gambar_jawaban) {
                        Storage::delete($value->gambar_jawaban);
                    }
                    $value->gambar_jawaban = $request->file('gambar_jawabanC')->store('gambar-jawaban');
                }
                if ($request->benar == "C") {
                    $value->is_correct = true;
                } else {
                    $value->is_correct = false;
                }
                $value->update();
            } elseif ($key == 3) {
                $value->jawaban = $request->jawabanD;
                if ($request->file('gambar_jawabanD')) {
                    if ($value->gambar_jawaban) {
                        Storage::delete($value->gambar_jawaban);
                    }
                    $value->gambar_jawaban = $request->file('gambar_jawabanD')->store('gambar-jawaban');
                }
                if ($request->benar == "D") {
                    $value->is_correct = true;
                } else {
                    $value->is_correct = false;
                }
                $value->update();
            } elseif ($key == 4) {
                $value->jawaban = $request->jawabanE;
                if ($request->file('gambar_jawabanE')) {
                    if ($value->gambar_jawaban) {
                        Storage::delete($value->gambar_jawaban);
                    }
                    $value->gambar_jawaban = $request->file('gambar_jawabanE')->store('gambar-jawaban');
                }
                if ($request->benar == "E") {
                    $value->is_correct = true;
                } else {
                    $value->is_correct = false;
                }
                $value->update();
            }
        }

        if ($soal->gambar_soal) {
            $soal->gambar_soal = url('/') . '/storage/' . $soal->gambar_soal;
        }

        foreach ($jawaban as $item) {
            if ($item->gambar_jawaban) {
                $item->gambar_jawaban = url('/') . '/storage/' . $item->gambar_jawaban;
            }
        }

        $data['soal'] = $soal;
        $data['jawaban'] = $jawaban;

        return response()->json([
            'success' => true,
            'message' => 'Update Data Berhasil',
            'data' => $data
        ]);
    }
}
