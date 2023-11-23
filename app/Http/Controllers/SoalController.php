<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Jawaban;
use App\Models\Countdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class SoalController extends Controller
{
    public function index_mudah()
    {
        $soal = Soal::where('tingkat', 'mudah')->get();
        $tingkat = 'mudah';
        $countdown = Countdown::where('tingkat', 'mudah')->first();
        return view('Admin.Soal.soal', compact('soal', 'tingkat', 'countdown'));
    }

    public function store_mudah(Request $request)
    {
        $validatedData = $request->validate([
            'soal' => 'required|string|max:255',
            'gambar_soal' => 'mimes:png,jpg,jpeg|max:10240',
        ]);

        $soal = new Soal();
        $soal->soal = $validatedData['soal'];
        $soal->tingkat = 'mudah';
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
        Alert::success('Success', 'Soal kategori mudah ditambahkan');
        return redirect('/soal-mudah')->with('success', 'Soal Telah Dibuat.');
    }

    public function index_menengah()
    {
        $soal = Soal::where('tingkat', 'menengah')->get();
        $tingkat = 'menengah';
        $countdown = Countdown::where('tingkat', 'menengah')->first();
        return view('Admin.Soal.soal', compact('soal', 'tingkat', 'countdown'));
    }

    public function store_menengah(Request $request)
    {
        $validatedData = $request->validate([
            'soal' => 'required|string|max:255',
        ]);

        $soal = new Soal();
        $soal->soal = $validatedData['soal'];
        $soal->tingkat = 'menengah';
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
        Alert::success('Success', 'Soal kategori menengah ditambahkan');
        return redirect('/soal-menengah')->with('success', 'Soal Telah Dibuat.');
    }

    public function index_sulit()
    {
        $soal = Soal::where('tingkat', 'sulit')->get();
        $tingkat = 'sulit';
        $countdown = Countdown::where('tingkat', 'sulit')->first();
        return view('Admin.Soal.soal', compact('soal', 'tingkat', 'countdown'));
    }

    public function store_sulit(Request $request)
    {
        $validatedData = $request->validate([
            'soal' => 'required|string|max:255',
        ]);

        $soal = new Soal();
        $soal->soal = $validatedData['soal'];
        $soal->tingkat = 'sulit';
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
        Alert::success('Success', 'Soal kategori sulit ditambahkan');
        return redirect('/soal-sulit')->with('success', 'Soal Telah Dibuat.');
    }

    public function update(Request $request, $id)
    {
        $soal = Soal::where('id', $id)->first();

        $validatedData = $request->validate([
            'soal' => 'required|string|max:255',
            'gambar_soal' => 'mimes:png,jpg,jpeg|max:10240',
        ]);

        $soal->soal = $validatedData['soal'];
        if ($request->file('gambar_soal')) {
            if ($request->gambarSoalLama) {
                Storage::delete($request->gambarSoalLama);
            }
            $soal->gambar_soal = $request->file('gambar_soal')->store('gambar-soal');
        }
        $soal->update();

        if ($soal->tingkat == 'mudah') {
            Alert::success('Success', 'Soal kategori mudah diupdate');
            return redirect('/soal-mudah')->with('success', 'Soal di Edit.');
        }
        if ($soal->tingkat == 'menengah') {
            Alert::success('Success', 'Soal kategori menengah diupdate');
            return redirect('/soal-menengah')->with('success', 'Soal di Edit.');
        }
        if ($soal->tingkat == 'sulit') {
            Alert::success('Success', 'Soal kategori sulit diupdate');
            return redirect('/soal-sulit')->with('success', 'Soal di Edit.');
        }
    }

    public function destroy($id)
    {
        $soal = Soal::where('id', $id)->first();
        $redirect = $soal->tingkat;
        $soal->delete();

        if ($redirect == 'mudah') {
            Alert::success('Success', 'Soal kategori mudah dihapus');
            return redirect('/soal-mudah')->with('success', 'Soal di Hapus.');
        }
        if ($redirect == 'menengah') {
            Alert::success('Success', 'Soal kategori menengah dihapus');
            return redirect('/soal-menengah')->with('success', 'Soal di Hapus.');
        }
        if ($redirect == 'sulit') {
            Alert::success('Success', 'Soal kategori sulit dihapus');
            return redirect('/soal-sulit')->with('success', 'Soal di Hapus.');
        }
    }

    public function countdown_mudah(Request $request)
    {
        $validatedData = $request->validate([
            'countdown_date' => 'required',
            'countdown_time' => 'required',
        ]);

        $countdown = new Countdown();
        $countdown->tingkat = 'mudah';
        $countdown->countdown_date = $validatedData['countdown_date'];
        $countdown->countdown_time = $validatedData['countdown_time'];
        $countdown->save();
        Alert::success('Success', 'Waktu Pengerjaan Soal berhasil diatur');
        return redirect('/soal-mudah')->with('success', 'Countdown Telah Dibuat.');
    }

    public function countdown_menengah(Request $request)
    {
        $validatedData = $request->validate([
            'countdown_date' => 'required',
            'countdown_time' => 'required',
        ]);

        $countdown = new Countdown();
        $countdown->tingkat = 'menengah';
        $countdown->countdown_date = $validatedData['countdown_date'];
        $countdown->countdown_time = $validatedData['countdown_time'];
        $countdown->save();
        Alert::success('Success', 'Waktu Pengerjaan Soal berhasil diatur');
        return redirect('/soal-menengah')->with('success', 'Countdown Telah Dibuat.');
    }

    public function countdown_sulit(Request $request)
    {
        $validatedData = $request->validate([
            'countdown_date' => 'required',
            'countdown_time' => 'required',
        ]);

        $countdown = new Countdown();
        $countdown->tingkat = 'sulit';
        $countdown->countdown_date = $validatedData['countdown_date'];
        $countdown->countdown_time = $validatedData['countdown_time'];
        $countdown->save();
        Alert::success('Success', 'Waktu Pengerjaan Soal berhasil diatur');
        return redirect('/soal-sulit')->with('success', 'Countdown Telah Dibuat.');
    }

    public function countdownEdit(Request $request, $id)
    {
        $countdown = Countdown::where('id', $id)->first();

        $validatedData = $request->validate([
            'countdown_date' => 'required',
            'countdown_time' => 'required',
        ]);

        $countdown->countdown_date = $validatedData['countdown_date'];
        $countdown->countdown_time = $validatedData['countdown_time'];
        $countdown->update();

        if ($countdown->tingkat == 'mudah') {
            Alert::success('Success', 'Waktu Pengerjaan Soal berhasil diatur');
            return redirect('/soal-mudah')->with('success', 'Countdown di Edit.');
        }
        if ($countdown->tingkat == 'menengah') {
            Alert::success('Success', 'Waktu Pengerjaan Soal berhasil diatur');
            return redirect('/soal-menengah')->with('success', 'Countdown di Edit.');
        }
        if ($countdown->tingkat == 'sulit') {
            Alert::success('Success', 'Waktu Pengerjaan Soal berhasil diatur');
            return redirect('/soal-sulit')->with('success', 'Countdown di Edit.');
        }
    }

    public function countdownHapus($id)
    {
        $countdown = Countdown::where('id', $id)->first();
        $redirect = $countdown->tingkat;
        $countdown->delete();

        if ($redirect == 'mudah') {
            Alert::success('Success', 'Waktu Pengerjaan Soal Selesai');
            return redirect('/soal-mudah')->with('success', 'Countdown di Edit.');
        }
        if ($redirect == 'menengah') {
            Alert::success('Success', 'Waktu Pengerjaan Soal Selesai');
            return redirect('/soal-menengah')->with('success', 'Countdown di Edit.');
        }
        if ($redirect == 'sulit') {
            Alert::success('Success', 'Waktu Pengerjaan Soal Selesai');
            return redirect('/soal-sulit')->with('success', 'Countdown di Edit.');
        }
    }
}
