@extends('Admin.Layouts.app')

@section('title', 'Data Mahasiswa Ujian')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-4">
            <div class="card p-4">
                <div class="d-flex">
                    <h5>Data Mahasiswa Ujian</h5>
                </div>
                <div class="table-responsive text-nowrap mt-4">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Username/Nim</th>
                                <th class="text-center">Sk Kompren</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswa as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $item->nama }}</td>
                                    <td class="text-center"><span>{{ $item->username }}</span></td>
                                    <td class="text-center">
                                        <a class="text-decoration-underline"
                                            href="{{ asset('storage/skKompren/' . $item->sk_kompren) }}"
                                            target="_blank">Lihat
                                            SK Kompren
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                            data-bs-target="#{{ 'jadwal' . $item->id }}">Atur Jadwal</button>
                                    </td>
                                    @php
                                        $data_penguji = json_decode($item->penguji);
                                        $pengujis = [
                                            $data_penguji->penguji_1,
                                            $data_penguji->penguji_2,
                                            $data_penguji->penguji_3,
                                        ];
                                        $user_id = auth()->user()->id;
                                        $matkul_id = $matkul_pengujian->id;

                                        $komputer = '';
                                        $ruangan = '';
                                        $tanggal_ujian = '';
                                        $jam_ujian = '';

                                        foreach ($pengujis as $penguji) {
                                            if ($penguji->user_id == $user_id && $penguji->matkul_id == $matkul_id) {
                                                $komputer = $penguji->komputer ?? '';
                                                $ruangan = $penguji->ruangan ?? '';
                                                $tanggal_ujian = $penguji->tanggal_ujian ?? '';
                                                $jam_ujian = $penguji->jam_ujian ?? '';
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="modal fade" id="{{ 'jadwal' . $item->id }}" tabindex="-1"
                                        aria-labelledby="{{ 'jadwal' . $item->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="{{ 'jadwal' . $item->id }}Label">
                                                        Atur Jadwal</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="/atur-jadwal" method="POST">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <input type="hidden" name="matkul_id"
                                                            value="{{ $matkul_pengujian->id }}">
                                                        <input type="hidden" name="user_id" value="{{ $item->id }}">
                                                        <div class="mb-3">
                                                            <label for="ruangan" class="form-label mb-2">No.
                                                                Ruangan</label>
                                                            <input type="text" class="form-control" required
                                                                name="ruangan" value="{{ $ruangan }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="komputer" class="form-label mb-2">No.
                                                                Komputer</label>
                                                            <input type="text" class="form-control" required
                                                                name="komputer" value="{{ $komputer }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tanggal_ujian" class="form-label">Tanggal
                                                                Ujian</label>
                                                            <input type="date" id="tanggal_ujian" class="form-control"
                                                                name="tanggal_ujian" required value="{{ $tanggal_ujian }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jam_ujian" class="form-label">Jam Ujian</label>
                                                            <input type="time" id="jam_ujian" class="form-control"
                                                                name="jam_ujian" required value="{{ $jam_ujian }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Atur</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 mb-4">
            <div class="card p-4">
                <div class="d-flex">
                    <h5>Jadwal Ujian</h5>
                </div>
                <div class="table-responsive text-nowrap mt-4">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">Tanggal Ujian</th>
                                <th class="text-center">Jam Ujian</th>
                                <th class="text-center">Mahasiswa Yang Ujian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswa as $item)
                                @php
                                    $data_penguji = json_decode($item->penguji);
                                    $pengujis = [
                                        $data_penguji->penguji_1,
                                        $data_penguji->penguji_2,
                                        $data_penguji->penguji_3,
                                    ];
                                    $user_id = auth()->user()->id;
                                    $matkul_id = $matkul_pengujian->id;

                                    $komputer = '';
                                    $ruangan = '';
                                    $tanggal_ujian = '';
                                    $jam_ujian = '';

                                    foreach ($pengujis as $penguji) {
                                        if ($penguji->user_id == $user_id && $penguji->matkul_id == $matkul_id) {
                                            $komputer = $penguji->komputer ?? '';
                                            $ruangan = $penguji->ruangan ?? '';
                                            $tanggal_ujian = $penguji->tanggal_ujian ?? '';
                                            $jam_ujian = $penguji->jam_ujian ?? '';
                                            break;
                                        }
                                    }
                                @endphp
                                @if ($tanggal_ujian)
                                    <tr>
                                        <td class="text-center">{{ $tanggal_ujian }}</td>
                                        <td class="text-center">{{ $jam_ujian }}</td>
                                        <td class="text-center">{{ $item->nama }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
