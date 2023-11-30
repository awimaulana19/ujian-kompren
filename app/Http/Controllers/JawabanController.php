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
        $soal = Soal::where('id', $id)->first();
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

        return view('Dosen.Matkul.jawaban', compact('soal', 'matkul', 'a', 'b', 'c', 'd', 'e', 'id'));
    }

    public function update(Request $request, $id)
    {
        $jawaban = Jawaban::where('soal_id', $id)->get();
        $soal = Soal::where('id', $id)->first();

        foreach ($jawaban as $key => $value) {
            if ($key == 0) {
                $value->jawaban = $request->jawabanA;
                if ($request->file('gambar_jawabanA')) {
                    if ($request->gambarJawabanLamaA) {
                        Storage::delete($request->gambarJawabanLamaA);
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
                    if ($request->gambarJawabanLamaB) {
                        Storage::delete($request->gambarJawabanLamaB);
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
                    if ($request->gambarJawabanLamaC) {
                        Storage::delete($request->gambarJawabanLamaC);
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
                    if ($request->gambarJawabanLamaD) {
                        Storage::delete($request->gambarJawabanLamaD);
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
                    if ($request->gambarJawabanLamaE) {
                        Storage::delete($request->gambarJawabanLamaE);
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

        Alert::success('Success', 'Jawaban Di Update');
        return redirect('/dosen/matkul/' . $soal->matkul_id)->with('success', 'Jawaban Di Update');
    }

    public function edit_api($id)
    {
        $soal = Soal::where('id', $id)->first();

        if (!$soal) {
            return response()->json([
                'success' => false,
                'message' => 'Get Data Gagal, Id Soal Tidak Ditemukan',
                'data' => null
            ]);
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

        $data['soal'] = $soal;
        $data['matkul'] = $matkul;
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
            ]);
        }

        $jawaban = Jawaban::where('soal_id', $id)->get();

        foreach ($jawaban as $key => $value) {
            if ($key == 0) {
                $value->jawaban = $request->jawabanA;
                if ($request->file('gambar_jawabanA')) {
                    if ($request->gambarJawabanLamaA) {
                        $desiredPart = Str::after($request->gambarJawabanLamaA, 'storage/');
                        Storage::delete($desiredPart);
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
                    if ($request->gambarJawabanLamaB) {
                        $desiredPart = Str::after($request->gambarJawabanLamaB, 'storage/');
                        Storage::delete($desiredPart);
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
                    if ($request->gambarJawabanLamaC) {
                        $desiredPart = Str::after($request->gambarJawabanLamaC, 'storage/');
                        Storage::delete($desiredPart);
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
                    if ($request->gambarJawabanLamaD) {
                        $desiredPart = Str::after($request->gambarJawabanLamaD, 'storage/');
                        Storage::delete($desiredPart);
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
                    if ($request->gambarJawabanLamaE) {
                        $desiredPart = Str::after($request->gambarJawabanLamaE, 'storage/');
                        Storage::delete($desiredPart);
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
