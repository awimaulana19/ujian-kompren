@extends('Admin.Layouts.app')

@section('title', 'Mata Kuliah')

@section('content')
    @php
        $data_penguji = json_decode(auth()->user()->penguji);
        $data_nilai = json_decode(auth()->user()->nilai);

        if ($data_penguji->penguji_1->user_id == $matkul->user_id && $data_penguji->penguji_1->matkul_id == $matkul->id) {
            $nilai_asli = $data_nilai->nilai_penguji_1->nilai_ujian;
            $sk = $data_nilai->nilai_penguji_1->sk;
        }
        if ($data_penguji->penguji_2->user_id == $matkul->user_id && $data_penguji->penguji_2->matkul_id == $matkul->id) {
            $nilai_asli = $data_nilai->nilai_penguji_2->nilai_ujian;
            $sk = $data_nilai->nilai_penguji_2->sk;
        }
        if ($data_penguji->penguji_3->user_id == $matkul->user_id && $data_penguji->penguji_3->matkul_id == $matkul->id) {
            $nilai_asli = $data_nilai->nilai_penguji_3->nilai_ujian;
            $sk = $data_nilai->nilai_penguji_3->sk;
        }
    @endphp
    @if ($sk)
        <div class="card p-4">
            <div class="d-flex flex-column justify-content-center align-items-center" style="margin: 18% 0">
                <h2 class="text-center">Cetak Surat Penilaian</h2>
                <form action="/cetak/pdf" method="POST">
                    @csrf
                    <input type="hidden" name="dosen_penguji" value="{{ $matkul->user->nama }}">
                    <input type="hidden" name="mata_kuliah_id" value="{{ $matkul->id }}">
                    <input type="hidden" name="mata_kuliah" value="{{ $matkul->nama }}">
                    <input type="hidden" name="nama_mahasiswa" value="{{ auth()->user()->nama }}">
                    <input type="hidden" name="nim_mahasiswa" value="{{ auth()->user()->username }}">
                    <input type="hidden" name="nilai_angka" value="{{ $nilai_asli }}">
                    @php
                        \Carbon\Carbon::setLocale('id');
                    @endphp
                    <input type="hidden" name="tanggal_sk" value="{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}">
                    <button type="submit" class="btn btn-primary mt-2">Cetak</button>
                </form>
            </div>
        </div>
    @else
        @if ($finish_date && $finish_time)
            <div class="card p-4">
                @if (session('error'))
                    <p class="alert alert-danger">{{ session('error') }}</p>
                @endif
                @if (session('success'))
                    <p class="alert alert-success">{{ session('success') }}</p>
                @endif
                <div class="d-flex flex-column justify-content-center align-items-center" style="margin: 18% 0">
                    <h2 class="text-center">Ujian Dimulai</h2>
                    <a href="/mahasiswa/soal/{{ $matkul->id }}" class="btn btn-primary mt-2">Mulai Ujian</a>
                </div>
            </div>
        @else
            <div class="card p-4">
                <div class="d-flex justify-content-center align-items-center" style="margin: 18% 0">
                    <h2 class="text-center">Ujian Belum Dimulai/Selesai</h2>
                </div>
            </div>
        @endif
    @endif
@endsection
