@extends('Admin.Layouts.app')

@section('title', 'Data Mahasiswa Selesai')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>

    <div class="row">
        <div class="col-lg-12 col-md-12 mb-4">
            <div class="card p-4">
                <div class="d-flex">
                    <h5>Data Mahasiswa Selesai</h5>
                </div>
                <div class="table-responsive text-nowrap mt-4">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Username/Nim</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $iteration = 1;
                            @endphp
                            @foreach ($mahasiswa as $item)
                                @php
                                    $data_penguji = json_decode($item->penguji);
                                    $data_nilai = json_decode($item->nilai);

                                    if (
                                        $data_penguji->penguji_1->user_id == auth()->user()->id &&
                                        $data_penguji->penguji_1->matkul_id == $matkul_penilaian->id
                                    ) {
                                        $jumlah_benar = $data_nilai->nilai_penguji_1->jumlah_benar;
                                        $jumlah_salah = $data_nilai->nilai_penguji_1->jumlah_salah;
                                        $nilai_asli = $data_nilai->nilai_penguji_1->nilai_ujian;
                                        $remidial = $data_nilai->nilai_penguji_1->remidial;
                                        $nilai_remidial = $data_nilai->nilai_penguji_1->nilai_remidial;
                                        $sk = $data_nilai->nilai_penguji_1->sk;
                                        $nilai_praktik = $data_nilai->nilai_penguji_1->nilai_praktik ?? '';
                                    }
                                    if (
                                        $data_penguji->penguji_2->user_id == auth()->user()->id &&
                                        $data_penguji->penguji_2->matkul_id == $matkul_penilaian->id
                                    ) {
                                        $jumlah_benar = $data_nilai->nilai_penguji_2->jumlah_benar;
                                        $jumlah_salah = $data_nilai->nilai_penguji_2->jumlah_salah;
                                        $nilai_asli = $data_nilai->nilai_penguji_2->nilai_ujian;
                                        $remidial = $data_nilai->nilai_penguji_2->remidial;
                                        $nilai_remidial = $data_nilai->nilai_penguji_2->nilai_remidial;
                                        $sk = $data_nilai->nilai_penguji_2->sk;
                                        $nilai_praktik = $data_nilai->nilai_penguji_2->nilai_praktik ?? '';
                                    }
                                    if (
                                        $data_penguji->penguji_3->user_id == auth()->user()->id &&
                                        $data_penguji->penguji_3->matkul_id == $matkul_penilaian->id
                                    ) {
                                        $jumlah_benar = $data_nilai->nilai_penguji_3->jumlah_benar;
                                        $jumlah_salah = $data_nilai->nilai_penguji_3->jumlah_salah;
                                        $nilai_asli = $data_nilai->nilai_penguji_3->nilai_ujian;
                                        $remidial = $data_nilai->nilai_penguji_3->remidial;
                                        $nilai_remidial = $data_nilai->nilai_penguji_3->nilai_remidial;
                                        $sk = $data_nilai->nilai_penguji_3->sk;
                                        $nilai_praktik = $data_nilai->nilai_penguji_3->nilai_praktik ?? '';
                                    }
                                @endphp
                                @if (($jumlah_benar != 0 && $jumlah_salah != 0) || $remidial)
                                    <tr>
                                        <td class="text-center">{{ $iteration }}</td>
                                        <td class="text-center">{{ $item->nama }}</td>
                                        <td class="text-center"><span>{{ $item->username }}</span></td>
                                        @if ($jumlah_benar == 0 && $jumlah_salah == 0)
                                            <td class="text-center">
                                                Belum Mengerjakan
                                            </td>
                                        @elseif ($remidial)
                                            <td class="text-center text-danger">
                                                Remidial
                                            </td>
                                        @else
                                            <td class="text-center text-success">
                                                Telah Mengerjakan
                                            </td>
                                        @endif
                                        @if ($jumlah_benar == 0 && $jumlah_salah == 0)
                                            <td class="text-center">
                                                Tidak Ada Action
                                            </td>
                                        @else
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-info me-1" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#{{ 'lihat' . $item->id }}">Lihat
                                                    Nilai</button>
                                                @if ($remidial)
                                                    <a class="btn btn-sm btn-danger me-1"
                                                        href="/dosen/remidial/{{ $matkul_penilaian->id }}/{{ $item->id }}">Remidial
                                                        Lagi</a>
                                                @else
                                                    <a class="btn btn-sm btn-danger me-1"
                                                        href="/dosen/remidial/{{ $matkul_penilaian->id }}/{{ $item->id }}">Remidial</a>
                                                @endif
                                                @if ($sk)
                                                    <a class="btn btn-sm btn-warning"
                                                        href="/dosen/batal-kirim/{{ $matkul_penilaian->id }}/{{ $item->id }}">Batal
                                                        Kirim</a>
                                                @else
                                                    <button class="btn btn-sm btn-success" type="button"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#{{ 'kirim' . $item->id }}">Kirim Nilai</button>
                                                @endif
                                            </td>
                                            {{-- modal --}}
                                            <div class="modal fade" id="{{ 'lihat' . $item->id }}" tabindex="-1"
                                                aria-labelledby="{{ 'lihat' . $item->id }}Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5"
                                                                id="{{ 'lihat' . $item->id }}Label">
                                                                Lihat Nilai</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form>
                                                                <div class="mb-3">
                                                                    <label class="form-label mb-2">Nilai Akhir</label>
                                                                    <input class="form-control" type="text"
                                                                        value="{{ $nilai_asli }}" disabled>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label mb-2">Nilai Remidial</label>
                                                                    @if ($remidial)
                                                                        <input class="form-control" type="text"
                                                                            value="{{ $nilai_remidial }}" disabled>
                                                                    @else
                                                                        <input class="form-control" type="text"
                                                                            value="Belum/Tidak Remidial" disabled>
                                                                    @endif
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label mb-2">Jumlah Benar (Pengerjaan
                                                                        Terakhir)</label>
                                                                    <input class="form-control" type="text"
                                                                        value="{{ $jumlah_benar }}" disabled>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label mb-2">Jumlah Salah (Pengerjaan
                                                                        Terakhir)</label>
                                                                    <input class="form-control" type="text"
                                                                        value="{{ $jumlah_salah }}" disabled>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- modal --}}
                                            {{-- modal --}}
                                            <div class="modal fade" id="{{ 'kirim' . $item->id }}" tabindex="-1"
                                                aria-labelledby="{{ 'kirim' . $item->id }}Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5"
                                                                id="{{ 'kirim' . $item->id }}Label">
                                                                Kirim Nilai</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="/kirim-nilai/pdf" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="dosen_penguji"
                                                                    value="{{ auth()->user()->nama }}">
                                                                <input type="hidden" name="mata_kuliah_id"
                                                                    value="{{ $matkul_penilaian->id }}">
                                                                <input type="hidden" name="mata_kuliah"
                                                                    value="{{ $matkul_penilaian->nama }}">
                                                                <input type="hidden" name="nama_mahasiswa"
                                                                    value="{{ $item->nama }}">
                                                                <input type="hidden" name="nim_mahasiswa"
                                                                    value="{{ $item->username }}">
                                                                @if ($remidial)
                                                                    <div class="mb-3">
                                                                        <label class="form-label mb-2">Nilai Ujian
                                                                            (Konversi
                                                                            Remidial)</label>
                                                                        <input class="form-control" required type="number"
                                                                            name="nilai_angka"
                                                                            value="{{ $nilai_remidial }}">
                                                                    </div>
                                                                @else
                                                                    <div class="mb-3">
                                                                        <label class="form-label mb-2">Nilai Ujian</label>
                                                                        <input class="form-control" required type="number"
                                                                            name="nilai_angka"
                                                                            value="{{ $nilai_asli }}">
                                                                    </div>
                                                                @endif
                                                                <div class="mb-3">
                                                                    <label class="form-label mb-2">Nilai Praktik</label>
                                                                    <input class="form-control" required type="number"
                                                                        name="nilai_praktik"
                                                                        value="{{ $nilai_praktik }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label mb-2">Keterangan Surat</label>
                                                                    <textarea class="form-control" name="keterangan" cols="30" rows="5"></textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label mb-2">TTD Digital</label>
                                                                    <br>
                                                                    <canvas id="signature-pad{{ $item->id }}"
                                                                        width="300px" height="150"
                                                                        style="border:1px solid #e0dfdf; border-radius:5px;"></canvas>
                                                                    <br>
                                                                    <button type="button" class="btn btn-success"
                                                                        id="save{{ $item->id }}">Simpan</button>
                                                                    <button type="button" class="btn btn-danger"
                                                                        id="clear{{ $item->id }}">Bersihkan</button>
                                                                </div>
                                                                <input type="hidden" name="signature"
                                                                    id="signature{{ $item->id }}">
                                                                <script>
                                                                    var canvas{{ $item->id }} = document.getElementById('signature-pad{{ $item->id }}');
                                                                    var signaturePad{{ $item->id }} = new SignaturePad(canvas{{ $item->id }});

                                                                    document.getElementById('save{{ $item->id }}').addEventListener('click', function() {
                                                                        var data{{ $item->id }} = signaturePad{{ $item->id }}.toDataURL('image/png');
                                                                        document.getElementById('signature{{ $item->id }}').value = data{{ $item->id }};
                                                                        alert('Tanda tangan berhasil disimpan.');
                                                                    });

                                                                    document.getElementById('clear{{ $item->id }}').addEventListener('click', function() {
                                                                        signaturePad{{ $item->id }}.clear();
                                                                        document.getElementById('signature{{ $item->id }}').value = '';
                                                                    });
                                                                </script>
                                                                @php
                                                                    \Carbon\Carbon::setLocale('id');
                                                                @endphp
                                                                <input type="hidden" name="tanggal_sk"
                                                                    value="{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary"
                                                                onclick="reloadPageAfterDelay()">Kirim</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- modal --}}
                                        @endif
                                    </tr>
                                    @php
                                        $iteration = $iteration + 1;
                                    @endphp
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function reloadPageAfterDelay() {
            setTimeout(function() {
                location.reload();
            }, 15000);
        }
    </script>
@endsection
