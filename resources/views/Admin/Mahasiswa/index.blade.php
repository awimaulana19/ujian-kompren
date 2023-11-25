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
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Username/Nim</th>
                                <th class="text-center">Sk Kompren</th>
                                <th class="text-center">Status Akun</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $item->nama }}</td>
                                    <td class="text-center"><span>{{ $item->username }}</span></td>
                                    <td class="text-center">
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
                                                        <div class="mb-3">
                                                            @php
                                                                $penguji = json_decode($item->penguji);
                                                            @endphp
                                                            <label for="penguji_1{{ $item->id }}"
                                                                class="form-label">Penguji 1</label>
                                                            <select name="penguji_1" id="penguji_1{{ $item->id }}"
                                                                class="form-select"
                                                                onchange="updateMatkul1{{ $item->id }}()">
                                                                <option value="">Pilih Dosen</option>
                                                                @foreach ($dosen as $row)
                                                                    <option value="{{ $row->id }}"
                                                                        {{ $row->id == $penguji->penguji_1->user_id ? 'selected' : '' }}>
                                                                        {{ $row->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <select name="matkul_1" id="matkul_1{{ $item->id }}"
                                                                class="form-select mt-2">
                                                                <option value="">Pilih Matkul</option>
                                                            </select>
                                                            <input type="hidden" id="value_matkul_1{{ $item->id }}"
                                                                value="{{ $penguji->penguji_1->matkul_id }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="penguji_2{{ $item->id }}"
                                                                class="form-label">Penguji 2</label>
                                                            <select name="penguji_2" id="penguji_2{{ $item->id }}"
                                                                class="form-select"
                                                                onchange="updateMatkul2{{ $item->id }}()">
                                                                <option value="">Pilih Dosen</option>
                                                                @foreach ($dosen as $row)
                                                                    <option value="{{ $row->id }}" {{ $row->id == $penguji->penguji_2->user_id ? 'selected' : '' }}>
                                                                        {{ $row->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                            <select name="matkul_2" id="matkul_2{{ $item->id }}"
                                                                class="form-select mt-2">
                                                                <option value="">Pilih Matkul</option>
                                                            </select>
                                                            <input type="hidden" id="value_matkul_2{{ $item->id }}"
                                                                value="{{ $penguji->penguji_2->matkul_id }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="penguji_3{{ $item->id }}"
                                                                class="form-label">Penguji 3</label>
                                                            <select name="penguji_3" id="penguji_3{{ $item->id }}"
                                                                class="form-select"
                                                                onchange="updateMatkul3{{ $item->id }}()">
                                                                <option value="">Pilih Dosen</option>
                                                                @foreach ($dosen as $row)
                                                                    <option value="{{ $row->id }}" {{ $row->id == $penguji->penguji_3->user_id ? 'selected' : '' }}>
                                                                        {{ $row->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                            <select name="matkul_3" id="matkul_3{{ $item->id }}"
                                                                class="form-select mt-2">
                                                                <option value="">Pilih Matkul</option>
                                                            </select>
                                                            <input type="hidden" id="value_matkul_3{{ $item->id }}"
                                                                value="{{ $penguji->penguji_3->matkul_id }}">
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

    @foreach ($user as $item)
        <script>
            document.addEventListener('DOMContentLoaded', async function() {
                await updateMatkul1{{ $item->id }}();
            });

            async function updateMatkul1{{ $item->id }}() {
                const penguji = document.getElementById('penguji_1{{ $item->id }}').value;
                const value_matkul = document.getElementById('value_matkul_1{{ $item->id }}').value;

                document.getElementById('matkul_1{{ $item->id }}').innerHTML =
                    '<option value="">Pilih Matkul</option>';
                document.getElementById('matkul_1{{ $item->id }}').disabled = true;

                try {
                    const response = await fetch(`/matkul-list?penguji=${penguji}`);
                    const data = await response.json();

                    data.forEach(matkul => {
                        const option = document.createElement('option');
                        if (value_matkul == matkul.id) {
                            option.selected = true;
                        }
                        option.value = matkul.id;
                        option.text = matkul.nama;
                        document.getElementById('matkul_1{{ $item->id }}').appendChild(option);
                    });

                    document.getElementById('matkul_1{{ $item->id }}').disabled = false;
                } catch (error) {
                    console.error(error);
                }
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', async function() {
                await updateMatkul2{{ $item->id }}();
            });

            async function updateMatkul2{{ $item->id }}() {
                const penguji = document.getElementById('penguji_2{{ $item->id }}').value;
                const value_matkul = document.getElementById('value_matkul_2{{ $item->id }}').value;

                document.getElementById('matkul_2{{ $item->id }}').innerHTML =
                    '<option value="">Pilih Matkul</option>';
                document.getElementById('matkul_2{{ $item->id }}').disabled = true;

                try {
                    const response = await fetch(`/matkul-list?penguji=${penguji}`);
                    const data = await response.json();

                    data.forEach(matkul => {
                        const option = document.createElement('option');
                        if (value_matkul == matkul.id) {
                            option.selected = true;
                        }
                        option.value = matkul.id;
                        option.text = matkul.nama;
                        document.getElementById('matkul_2{{ $item->id }}').appendChild(option);
                    });

                    document.getElementById('matkul_2{{ $item->id }}').disabled = false;
                } catch (error) {
                    console.error(error);
                }
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', async function() {
                await updateMatkul3{{ $item->id }}();
            });

            async function updateMatkul3{{ $item->id }}() {
                const penguji = document.getElementById('penguji_3{{ $item->id }}').value;
                const value_matkul = document.getElementById('value_matkul_3{{ $item->id }}').value;

                document.getElementById('matkul_3{{ $item->id }}').innerHTML =
                    '<option value="">Pilih Matkul</option>';
                document.getElementById('matkul_3{{ $item->id }}').disabled = true;

                try {
                    const response = await fetch(`/matkul-list?penguji=${penguji}`);
                    const data = await response.json();

                    data.forEach(matkul => {
                        const option = document.createElement('option');
                        if (value_matkul == matkul.id) {
                            option.selected = true;
                        }
                        option.value = matkul.id;
                        option.text = matkul.nama;
                        document.getElementById('matkul_3{{ $item->id }}').appendChild(option);
                    });

                    document.getElementById('matkul_3{{ $item->id }}').disabled = false;
                } catch (error) {
                    console.error(error);
                }
            }
        </script>
    @endforeach
@endsection
