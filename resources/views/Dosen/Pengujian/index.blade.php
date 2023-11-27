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
                                <th class="text-center">Status</th>
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
                                    @php
                                        $data_penguji = json_decode($item->penguji);

                                        if ($data_penguji->penguji_1->user_id == auth()->user()->id && $data_penguji->penguji_1->matkul_id == $matkul_pengujian->id) {
                                            $dapat_ujian = $data_penguji->penguji_1->dapat_ujian;
                                        }
                                        if ($data_penguji->penguji_2->user_id == auth()->user()->id && $data_penguji->penguji_2->matkul_id == $matkul_pengujian->id) {
                                            $dapat_ujian = $data_penguji->penguji_2->dapat_ujian;
                                        }
                                        if ($data_penguji->penguji_3->user_id == auth()->user()->id && $data_penguji->penguji_3->matkul_id == $matkul_pengujian->id) {
                                            $dapat_ujian = $data_penguji->penguji_3->dapat_ujian;
                                        }
                                    @endphp
                                    @if ($dapat_ujian)
                                        <td class="text-center">
                                            <a href="/dosen/dapat-ujian/{{ $matkul_pengujian->id }}/{{ $item->id }}" class="btn btn-sm btn-success">
                                                Dapat Ujian 
                                            </a>
                                        </td>
                                    @else
                                        <td class="text-center">
                                            <a href="/dosen/dapat-ujian/{{ $matkul_pengujian->id }}/{{ $item->id }}" class="btn btn-sm btn-danger">
                                                Belum Dapat Ujian
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
