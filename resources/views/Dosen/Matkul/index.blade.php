@extends('Admin.Layouts.app')

@section('title', 'Soal')

@section('content')
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <style>
        tr .soal-td p:first-child {
            display: inline;
        }
    </style>
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-4">
            <div class="card p-4">
                <div class="d-flex">
                    <h5>Soal {{ $matkul->nama }}</h5>
                    @if ($matkul->finish_time && $matkul->finish_date)
                        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                            data-bs-target="#finish">
                            Atur Ujian
                        </button>
                    @else
                        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                            data-bs-target="#finish">
                            Mulai Ujian
                        </button>
                    @endif
                    <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Tambah Soal
                    </button>
                </div>
                @include('Dosen.Matkul.finish')
                @include('Dosen.Matkul.tambah')
                @if ($errors->any())
                    @foreach ($errors->all() as $err)
                        <p class="alert alert-danger mt-2">{{ $err }}</p>
                    @endforeach
                @endif
                <div class="table-responsive text-nowrap mt-4">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Soal</th>
                                <th class="text-center">Tingkatan Soal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($matkul->soal as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center soal-td">{!! $item->soal !!}</td>
                                    <td class="text-center">{{ $item->tingkat }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn btn-primary me-3"
                                                href="{{ url('/soal/jawaban/' . $item->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i> Edit Soal</a>
                                            <a class="btn btn-danger" href="{{ url('/dosen/soal/hapus/' . $item->id) }}"><i
                                                    class="bx bx-trash me-1"></i> Hapus Soal</a>
                                        </div>
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
