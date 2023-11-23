@extends('Admin.Layouts.app')

@if ($tingkat == 'mudah')
    @section('title', 'Soal Mudah')
@elseif ($tingkat == 'menengah')
    @section('title', 'Soal Menengah')
@elseif ($tingkat == 'sulit')
    @section('title', 'Soal Sulit')
@endif

@section('content')
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-4">
            <div class="card p-4">
                <div class="d-flex">
                    @if ($tingkat == 'mudah')
                        <h5>Soal Mudah</h5>
                    @elseif ($tingkat == 'menengah')
                        <h5>Soal Menengah</h5>
                    @elseif ($tingkat == 'sulit')
                        <h5>Soal Sulit</h5>
                    @endif
                    @if (!$countdown)
                        <button type="button" class="btn btn-success ms-auto" data-bs-toggle="modal"
                            data-bs-target="#countdown">
                            Buat Waktu Ujian
                        </button>
                        @include('Admin.Soal.countdown')
                    @else
                        <button type="button" class="btn btn-warning ms-auto" data-bs-toggle="modal"
                            data-bs-target="#editCountdown">
                            Edit Waktu Ujian
                        </button>
                        @include('Admin.Soal.editcountdown')
                    @endif
                    <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Tambah Soal
                    </button>
                </div>
                @include('Admin.Soal.tambah')
                <div class="table-responsive text-nowrap mt-4">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Soal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($soal as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{!! $item->soal !!}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn btn-success me-3"
                                                href="{{ url('/soal/jawaban/' . $item->id) }}"><i
                                                    class="bx bx-book-alt me-1"></i> Jawaban</a>
                                            <button class="btn btn-primary me-3" type="button" data-bs-toggle="modal"
                                                data-bs-target="#{{ 'edit' . $item->id }}"><i
                                                    class="bx bx-edit-alt me-1"></i> Edit Soal</button>
                                            @include('Admin.Soal.edit')
                                            <a class="btn btn-danger" href="{{ url('/soalmudah/hapus/' . $item->id) }}"><i
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
