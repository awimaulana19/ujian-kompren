@extends('Admin.Layouts.app')

@section('title', 'Soal')

@section('content')
    <div class="col-12 mx-auto">
        <div class="card mb-4">
            <h5 class="card-header">Soal</h5>
            <div class="card-body" style="margin-bottom: -30px;">
                {!! $soal->soal !!}
                <br>
                @if ($soal->gambar_soal)
                    <img src="{{ asset('storage/' . $soal->gambar_soal) }}" width="50%">
                @endif
            </div>
            <h5 class="card-header">Jawaban</h5>
            <div class="card-body">
                <form enctype="multipart/form-data" action="{{ '/soal/jawaban/' . $id }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="jawabanA" class="form-label">Jawaban A :</label>
                        <input class="form-control @error('jawabanA') is-invalid @enderror" type="text" name="jawabanA"
                            value="{{ $a->jawaban }}">
                        @error('jawabanA')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="mt-3">
                            <label for="gambar_jawabanA" class="form-label">Gambar</label>
                            <input type="hidden" name="gambarJawabanLamaA" id="gambarJawabanLamaA" value="{{ $a->gambar_jawaban }}">
                            @if ($a->gambar_jawaban)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $a->gambar_jawaban) }}" width="50%">
                                </div>
                            @endif
                            <input type="file" id="gambar_jawabanA" class="form-control" name="gambar_jawabanA">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jawabanB" class="form-label">Jawaban B :</label>
                        <input class="form-control @error('jawabanB') is-invalid @enderror" type="text" name="jawabanB"
                            value="{{ $b->jawaban }}">
                        @error('jawabanB')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="mt-3">
                            <label for="gambar_jawabanB" class="form-label">Gambar</label>
                            <input type="hidden" name="gambarJawabanLamaB" id="gambarJawabanLamaB" value="{{ $b->gambar_jawaban }}">
                            @if ($b->gambar_jawaban)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $b->gambar_jawaban) }}" width="50%">
                                </div>
                            @endif
                            <input type="file" id="gambar_jawabanB" class="form-control" name="gambar_jawabanB">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jawabanC" class="form-label">Jawaban C :</label>
                        <input class="form-control @error('jawabanC') is-invalid @enderror" type="text" name="jawabanC"
                            value="{{ $c->jawaban }}">
                        @error('jawabanC')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="mt-3">
                            <label for="gambar_jawabanC" class="form-label">Gambar</label>
                            <input type="hidden" name="gambarJawabanLamaC" id="gambarJawabanLamaC" value="{{ $c->gambar_jawaban }}">
                            @if ($c->gambar_jawaban)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $c->gambar_jawaban) }}" width="50%">
                                </div>
                            @endif
                            <input type="file" id="gambar_jawabanC" class="form-control" name="gambar_jawabanC">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jawabanD" class="form-label">Jawaban D :</label>
                        <input class="form-control @error('jawabanD') is-invalid @enderror" type="text" name="jawabanD"
                            value="{{ $d->jawaban }}">
                        @error('jawabanD')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="mt-3">
                            <label for="gambar_jawabanD" class="form-label">Gambar</label>
                            <input type="hidden" name="gambarJawabanLamaD" id="gambarJawabanLamaD" value="{{ $d->gambar_jawaban }}">
                            @if ($d->gambar_jawaban)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $d->gambar_jawaban) }}" width="50%">
                                </div>
                            @endif
                            <input type="file" id="gambar_jawabanD" class="form-control" name="gambar_jawabanD">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jawabanE" class="form-label">Jawaban E :</label>
                        <input class="form-control @error('jawabanE') is-invalid @enderror" type="text" name="jawabanE"
                            value="{{ $e->jawaban }}">
                        @error('jawabanE')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="mt-3">
                            <label for="gambar_jawabanE" class="form-label">Gambar</label>
                            <input type="hidden" name="gambarJawabanLamaE" id="gambarJawabanLamaE" value="{{ $e->gambar_jawaban }}">
                            @if ($e->gambar_jawaban)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $e->gambar_jawaban) }}" width="50%">
                                </div>
                            @endif
                            <input type="file" id="gambar_jawabanE" class="form-control" name="gambar_jawabanE">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label me-3">Jawaban Benar :</label>
                        <div class="form-check form-check-inline ml-auto">
                            <input class="form-check-input" type="radio" name="benar" id="radio1"
                                value="A" {{ $a->is_correct == true ? 'checked' : '' }}>
                            <label class="form-check-label" for="radio1">A</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="benar" id="radio2"
                                value="B" {{ $b->is_correct == true ? 'checked' : '' }}>
                            <label class="form-check-label" for="radio2">B</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="benar" id="radio3"
                                value="C" {{ $c->is_correct == true ? 'checked' : '' }}>
                            <label class="form-check-label" for="radio3">C</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="benar" id="radio4"
                                value="D" {{ $d->is_correct == true ? 'checked' : '' }}>
                            <label class="form-check-label" for="radio4">D</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="benar" id="radio5"
                                value="E" {{ $e->is_correct == true ? 'checked' : '' }}>
                            <label class="form-check-label" for="radio5">E</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <a href="/dosen/matkul/{{ $matkul->id }}" class="btn btn-danger">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
