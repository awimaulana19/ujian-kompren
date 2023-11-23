@extends('Admin.Layouts.app')

@section('title', 'Pengawas')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-4">
                <div class="card p-4">
                    <div class="d-flex">
                        <h5>Pengawas</h5>
                        <a href="/pengawas/tambah" class="btn btn-primary ms-auto">
                            Tambah Pengawas
                        </a>
                    </div>
                    <div class="table-responsive text-nowrap mt-3">
                        <table class="table table-hover mt-4">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-primary me-2" href="{{ url('pengawas/edit/' . $item->id) }}">
                                                <i class="bx bx-edit-alt"></i> Edit
                                            </a>
                                            <a class="btn btn-danger" href="{{ url('pengawas/' . $item->id) }}">
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
