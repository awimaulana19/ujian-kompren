@extends('Admin.Layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card p-3">
                <p>Jumlah Mahasiswa Yang Telah Selesai Ujian</p>
                <div class="d-flex">
                    <i class="menu-icon tf-icons bx bxs-book"></i>
                    <p class="fw-bold mb-0">{{ $jumlah_telah_ujian }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card p-3">
                <p>Jumlah Mahasiswa Telah Registrasi</p>
                <div class="d-flex">
                    <i class="menu-icon tf-icons bx bxs-book"></i>
                    <p class="fw-bold mb-0">{{ $jumlah_mahasiswa }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
