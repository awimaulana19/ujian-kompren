@extends('Admin.Layouts.app')

@section('title', 'Mata Kuliah')

@section('content')
    @php
        $data_penguji = json_decode(auth()->user()->penguji);
        $data_nilai = json_decode(auth()->user()->nilai);
        $pengujis = [$data_penguji->penguji_1, $data_penguji->penguji_2, $data_penguji->penguji_3];
        $nilai_pengujis = [$data_nilai->nilai_penguji_1, $data_nilai->nilai_penguji_2, $data_nilai->nilai_penguji_3];
        $user_id = $matkul->user_id;
        $matkul_id = $matkul->id;

        $nilai_asli = '';
        $jumlah_benar = '';
        $jumlah_salah = '';
        $remidial = '';
        $nilai_remidial = '';
        $sk = '';

        foreach ($pengujis as $index => $penguji) {
            if ($penguji->user_id == $user_id && $penguji->matkul_id == $matkul_id) {
                $nilai_asli = $nilai_pengujis[$index]->nilai_ujian;
                $jumlah_benar = $nilai_pengujis[$index]->jumlah_benar;
                $jumlah_salah = $nilai_pengujis[$index]->jumlah_salah;
                $remidial = $nilai_pengujis[$index]->remidial;
                $nilai_remidial = $nilai_pengujis[$index]->nilai_remidial;
                $sk = $nilai_pengujis[$index]->sk;
                $komputer = $penguji->komputer ?? 'Belum Ada';
                $ruangan = $penguji->ruangan ?? 'Belum Ada';
                $tanggal_ujian = $penguji->tanggal_ujian ?? 'Belum Ada';
                $jam_ujian = $penguji->jam_ujian ?? 'Belum Ada';
                break;
            }
        }
    @endphp
    <div class="card p-4">
        @if (session('error'))
            <p class="alert alert-danger">{{ session('error') }}</p>
        @endif
        @if (session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif
        <div class="d-flex justify-content-center align-items-center" style="margin: 17% 0">
            <div style="margin-right: 250px">
                <div class="row">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <h2 class="text-center">Jadwal & Tempat Ujian</h2>
                        <h4 class="text-center">Ruangan : {{ $ruangan }}</h4>
                        <h4 class="text-center">Komputer : {{ $komputer }}</h4>
                        <h4 class="text-center">Tanggal : {{ $tanggal_ujian }}</h4>
                        <h4 class="text-center">Jam : {{ $jam_ujian }}</h4>
                    </div>
                </div>
            </div>
            <div>
                @if ($sk)
                    <div class="row">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <h2 class="text-center">Download Surat Penilaian</h2>
                            <form action="/cetak/pdf" method="POST">
                                @csrf
                                <input type="hidden" name="dosen_penguji" value="{{ $matkul->user->nama }}">
                                <input type="hidden" name="mata_kuliah_id" value="{{ $matkul->id }}">
                                <input type="hidden" name="mata_kuliah" value="{{ $matkul->nama }}">
                                <input type="hidden" name="nama_mahasiswa" value="{{ auth()->user()->nama }}">
                                <input type="hidden" name="nim_mahasiswa" value="{{ auth()->user()->username }}">
                                <input type="hidden" name="nilai_angka" value="{{ $nilai_asli }}">
                                <button type="submit" class="btn btn-primary mt-2">Download</button>
                            </form>
                        </div>
                    </div>
                @elseif ($remidial)
                    <div class="row">
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
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <h2 class="text-center">Remidial Dimulai</h2>
                                <a href="/mahasiswa/soal/{{ $matkul->id }}" class="btn btn-primary mt-2">Mulai
                                    Remidial</a>
                            </div>
                        @endif
                    </div>
                @elseif ($nilai_asli !== null)
                    <div class="row">
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
                        <div class="row">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <h2 class="text-center">Ujian Dimulai</h2>
                                <a href="/mahasiswa/soal/{{ $matkul->id }}" class="btn btn-primary mt-2">Mulai Ujian</a>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="d-flex justify-content-center align-items-center">
                                <h2 class="text-center">Ujian Belum Dimulai</h2>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
