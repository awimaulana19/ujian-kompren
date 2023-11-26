@extends('Admin.Layouts.app')

@section('title', 'Mata Kuliah')

@section('content')
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
                <h2 class="text-center">Ujian Belum Dimulai/Selesai</h2>
            </div>
        </div>
    @endif
@endsection
