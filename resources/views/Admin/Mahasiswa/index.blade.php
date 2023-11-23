@extends('Admin.Layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-4">
            <div class="card p-4">
                <div class="d-flex">
                    <h5>Data Mahasiswa</h5>
                </div>
                <div class="table-responsive text-nowrap mt-4">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th class="text-center">Username/Nim</th>
                                <th>Sk Kompren</th>
                                <th class="text-center">Status Akun</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td class="text-center"><span>{{ $item->username }}</span></td>
                                    <td>
                                        <a class="text-decoration-underline"
                                            href="{{ asset('storage/skKompren/' . $item->sk_kompren) }}"
                                            target="_blank">Lihat
                                            SK Kompren
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-danger" {{ $item->is_verification == 0 ? '' : 'hidden' }}>Belum
                                            Aktif</span>
                                        <span class="text-success" {{ $item->is_verification == 1 ? '' : 'hidden' }}>Aktif
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal{{ $item->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <a href="/admin/mahasiswa/delete/{{ $item->id }}" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    </td>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Verifikasi Akun
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/admin/mahasiswa/update/{{ $item->id }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">Username</label>
                                                            <input type="text" value="{{ $item->username }}" disabled
                                                                class="form-control" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="is_verification" class="form-label">Status
                                                                Akun</label>
                                                            <select name="is_verification" id="is_verification"
                                                                class="form-select">
                                                                <option value="1"
                                                                    {{ $item->is_verification == '1' ? 'selected' : '' }}>
                                                                    Aktifkan</option>
                                                                <option value="0"
                                                                    {{ $item->is_verification == '0' ? 'selected' : '' }}>
                                                                    Nonaktifkan</option>
                                                            </select>
                                                        </div>
                                                        <div class="d-flex justify-content-end gap-2">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Verifikasi</button>
                                                        </div>
                                                    </form>
                                                </div>
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
    </div>
@endsection
