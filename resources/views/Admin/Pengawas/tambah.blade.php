@extends('Admin.Layouts.app')

@section('title', 'Pengawas')
@section('content')
    <div class="col-12 mx-auto">
        <div class="card mb-4">
            <h5 class="card-header">Tambah Pengawas</h5>
            <div class="card-body">
                <form enctype="multipart/form-data" action="/pengawas/tambah" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text"
                                    name="nama" placeholder="Masukkan Nama">
                                @error('nama')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input class="form-control  @error('username') is-invalid @enderror" type="text"
                                    name="username" placeholder="Masukkan Username">
                                @error('username')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 form-password-toggle">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control  @error('password') is-invalid @enderror" id="password"
                                        type="password" name="password" placeholder="Masukkan Password"
                                        aria-describedby="password">
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="/pengawas" class="btn btn-danger me-3">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
