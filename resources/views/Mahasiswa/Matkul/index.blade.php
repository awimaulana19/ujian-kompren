@extends('Admin.Layouts.app')

@section('title', 'Mata Kuliah')

@section('content')
    @php
        $data_penguji = json_decode(auth()->user()->penguji);
        $data_nilai = json_decode(auth()->user()->nilai);

        if ($data_penguji->penguji_1->user_id == $matkul->user_id && $data_penguji->penguji_1->matkul_id == $matkul->id) {
            $nilai_asli = $data_nilai->nilai_penguji_1->nilai_ujian;
            $jumlah_benar = $data_nilai->nilai_penguji_1->jumlah_benar;
            $jumlah_salah = $data_nilai->nilai_penguji_1->jumlah_salah;
            $remidial = $data_nilai->nilai_penguji_1->remidial;
            $nilai_remidial = $data_nilai->nilai_penguji_1->nilai_remidial;
            $sk = $data_nilai->nilai_penguji_1->sk;
        }
        if ($data_penguji->penguji_2->user_id == $matkul->user_id && $data_penguji->penguji_2->matkul_id == $matkul->id) {
            $nilai_asli = $data_nilai->nilai_penguji_2->nilai_ujian;
            $jumlah_benar = $data_nilai->nilai_penguji_2->jumlah_benar;
            $jumlah_salah = $data_nilai->nilai_penguji_2->jumlah_salah;
            $remidial = $data_nilai->nilai_penguji_2->remidial;
            $nilai_remidial = $data_nilai->nilai_penguji_2->nilai_remidial;
            $sk = $data_nilai->nilai_penguji_2->sk;
        }
        if ($data_penguji->penguji_3->user_id == $matkul->user_id && $data_penguji->penguji_3->matkul_id == $matkul->id) {
            $nilai_asli = $data_nilai->nilai_penguji_3->nilai_ujian;
            $jumlah_benar = $data_nilai->nilai_penguji_3->jumlah_benar;
            $jumlah_salah = $data_nilai->nilai_penguji_3->jumlah_salah;
            $remidial = $data_nilai->nilai_penguji_3->remidial;
            $nilai_remidial = $data_nilai->nilai_penguji_3->nilai_remidial;
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
    @elseif ($remidial)
        <div class="card p-4">
            @if (session('error'))
                <p class="alert alert-danger">{{ session('error') }}</p>
            @endif
            @if (session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif
            @if ($nilai_remidial !== null)
                <div class="d-flex flex-column justify-content-center align-items-center" style="margin: 14% 0">
                    <h2 class="text-center">Nilai Anda</h2>
                    <h3>{{ $nilai_remidial }}</h3>
                    <br>
                    <h3 class="text-center">Dengan Jumlah Benar Dan Salah</h3>
                    <h4 class="text-center">Benar : {{ $jumlah_benar }}</h4>
                    <h4 class="text-center">Salah : {{ $jumlah_salah }}</h4>
                </div>
            @else
                <div class="d-flex flex-column justify-content-center align-items-center" style="margin: 18% 0">
                    <h2 class="text-center">Remidial Dimulai</h2>
                    <a href="/mahasiswa/soal/{{ $matkul->id }}" class="btn btn-primary mt-2">Mulai Remidial</a>
                </div>
            @endif
        </div>
    @elseif ($nilai_asli !== null)
        <div class="card p-4">
            <div class="d-flex flex-column justify-content-center align-items-center" style="margin: 14% 0">
                <h2 class="text-center">Nilai Anda</h2>
                <h3>{{ $nilai_asli }}</h3>
                <br>
                <h3 class="text-center">Dengan Jumlah Benar Dan Salah</h3>
                <h4 class="text-center">Benar : {{ $jumlah_benar }}</h4>
                <h4 class="text-center">Salah : {{ $jumlah_salah }}</h4>
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
                    <h2 class="text-center">Ujian Belum Dimulai</h2>
                </div>
            </div>
        @endif
    @endif
@endsection
