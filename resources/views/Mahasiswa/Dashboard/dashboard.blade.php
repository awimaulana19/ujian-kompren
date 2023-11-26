@extends('Admin.Layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-3 p-4">
                <h5>Selamat Datang Peserta Ujian Kompren</h5>
                <div class="row">
                    <div class="col-md-1 col-4">
                        <p class="mb-1">Nama</p>
                    </div>
                    <div class="col-md-11 col-8">
                        <p class="mb-1">: {{ auth()->user()->nama }}</p>
                    </div>
                    <div class="col-md-1 col-4">
                        <p class="mb-1">NIM</p>
                    </div>
                    <div class="col-md-11 col-8">
                        <p class="mb-1">: {{ auth()->user()->username }}</p>
                    </div>
                </div>
            </div>
        </div>
        @php
            $penguji = json_decode(auth()->user()->penguji, true);

            $data_lengkap_penguji = [];

            foreach ($penguji as $key => $value) {
                $data_user = app(\App\Models\User::class)::find($value['user_id']);

                $matkul_user = app(\App\Models\Matkul::class)::find($value['matkul_id']);

                $data_lengkap_penguji[$key] = [
                    'user_id' => $value['user_id'],
                    'nama' => $data_user->nama,
                    'matkul_id' => $value['matkul_id'],
                    'matkul_nama' => $matkul_user->nama,
                ];
            }

            $penguji = $data_lengkap_penguji;
        @endphp
        @foreach ($penguji as $item)
            <div class="col-md-4 mb-3 text-center">
                <a href="/mahasiswa/matkul/{{ $item['matkul_id'] }}" class="card p-3">
                    <i class="menu-icon tf-icons bx bxs-book fs-1 mx-auto"></i>
                    <div data-i18n="Analytics">{{ $item['matkul_nama'] }}</div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
