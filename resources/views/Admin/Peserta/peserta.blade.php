@extends('Admin.Layouts.app')

@section('title', 'Peserta')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-4">
            <div class="card p-4">
                <div class="d-flex">
                    <h5>Peserta</h5>
                </div>
                <div class="table-responsive text-nowrap mt-4">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Nilai</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>
                                        <span class="text-danger" {{ $item->is_verification == 0 ? '' : 'hidden' }}>Belum
                                            Aktif</span>
                                        <span class="text-success" {{ $item->is_verification == 1 ? '' : 'hidden' }}>Aktif
                                        </span>
                                    </td>
                                    @if ($item->nilai_tes == null)
                                        <td>Belum Tes</td>
                                    @else
                                        <td>{{ $item->nilai_tes }}</td>
                                    @endif
                                    <td class="text-center">
                                        <a class="btn btn-primary me-2" href="{{ url('peserta/lihat/' . $item->id) }}">
                                            <i class="bi bi-eye-fill me-1"></i> Lihat
                                        </a>
                                        <a class="btn btn-danger" href="{{ url('peserta/' . $item->id) }}">
                                            <i class="bx bx-trash me-1"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
