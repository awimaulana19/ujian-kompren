@extends('Admin.Layouts.app')

@section('title', 'Peserta')
@section('content')
    <div class="col-12 mx-auto">
        <div class="card mb-4">
            <h5 class="card-header">Data Akun</h5>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input class="form-control" type="text" name="nama" value="{{ $user->nama }}"
                                    disabled>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Email</label>
                                <input class="form-control" type="text" name="username" value="{{ $user->username }}"
                                    disabled>
                            </div>
                            <div class="mb-3">
                                <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                                <input class="form-control" type="text" name="asal_sekolah"
                                    value="{{ $user->asal_sekolah }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="alamat_sekolah" class="form-label">Alamat Sekolah</label>
                                <input class="form-control" type="text" name="alamat_sekolah"
                                    value="{{ $user->alamat_sekolah }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="alamat_sekolah" class="form-label">Pengumuman</label>
                                @if ($lulus === 'lulus')
                                    <span class="bg-success form-control text-center text-white">
                                        Lulus
                                    </span>
                                @elseif ($lulus === 'tidak')
                                    <span class="bg-danger form-control text-center text-white">
                                        Tidak Lulus
                                    </span>
                                @elseif ($lulus === 'belum')
                                    <span class="bg-secondary form-control text-center text-white">
                                        Belum Tes
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bukti Pembayaran</label>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal"
                                    data-bs-target="#buktipembayaran">
                                    Lihat Bukti Pembayaran
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="buktipembayaran" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Bukti Pembayaran</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="{{ asset('storage/' . $user->bukti_pendaftaran) }}"
                                                    width="100%">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="/peserta" class="btn btn-danger me-3">Kembali</a>
                            @if ($user->is_verification != 1)
                                <a href="{{ '/peserta/verifikasi/' . $user->id }}" class="btn btn-success text-white">
                                    Verifikasi Akun
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Data Lomba</h5>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="tingkat_lomba" class="form-label">Tingkat Lomba</label>
                            <p class="form-control">
                                @if ($user->tingkatan_lomba == 'sd')
                                    SD
                                @elseif ($user->tingkatan_lomba == 'smp')
                                    SMP
                                @elseif ($user->tingkatan_lomba == 'sma')
                                    SMA
                                @endif
                            </p>
                        </div>
                        <div class="mb-3">
                            <label for="rayon" class="form-label">Rayon</label>
                            <p id="rayon1" class="form-control"></p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Surat Rekomendasi</label>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal"
                                data-bs-target="#suratrekomendasi">
                                Lihat Surat
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="suratrekomendasi" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Surat Rekomendasi</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ asset('storage/' . $user->surat_rekomendasi) }}" width="100%">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Data Pendamping</h5>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="nama_pendamping" class="form-label">Nama Pendamping</label>
                            <input class="form-control" type="text" name="nama_pendamping"
                                value="{{ $user->nama_pendamping }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="jk" class="form-label">Jenis Kelamin</label>
                            <input class="form-control" type="text" name="jk" value="{{ $user->jk_pendamping }}"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label for="nomor_pendamping" class="form-label">Nomor Pendamping</label>
                            <input class="form-control" type="text" name="nomor_pendamping"
                                value="{{ $user->nomor_pendamping }}" disabled>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Data Peserta 1</h5>
                <div class="card-body">

                    <div class="mb-3">
                        <label for="nama_peserta1" class="form-label">Nama Peserta</label>
                        <input class="form-control" type="text" name="nama_peserta1"
                            value="{{ $user->nama_peserta1 }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                        <input class="form-control" type="text" name="asal_sekolah"
                            value="{{ $user->asal_sekolah }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="jk" class="form-label">Jenis Kelamin</label>
                        <input class="form-control" type="text" name="jk" value="{{ $user->jk_peserta1 }}"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Peserta 1</label>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal"
                            data-bs-target="#peserta1">
                            Lihat Foto
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="peserta1" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Foto Peserta 1</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{ asset('storage/' . $user->foto1) }}" width="100%">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Data Peserta 2</h5>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama_peserta2" class="form-label">Nama Peserta</label>
                        <input class="form-control" type="text" name="nama_peserta2"
                            value="{{ $user->nama_peserta2 }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                        <input class="form-control" type="text" name="asal_sekolah"
                            value="{{ $user->asal_sekolah }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="jk" class="form-label">Jenis Kelamin</label>
                        <input class="form-control" type="text" name="jk" value="{{ $user->jk_peserta2 }}"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Peserta 2</label>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal"
                            data-bs-target="#peserta2">
                            Lihat Foto
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="peserta2" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Foto Peserta 2</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{ asset('storage/' . $user->foto2) }}" width="100%">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const rayon1 = document.getElementById('rayon1');
        const rayon2 = document.getElementById('rayon2');
        const provinsiSelect = document.getElementById('provinsi');
        const kabupatenSelect = document.getElementById('kabupaten');
        let dataProvinsi;

        const fetchData = async (url) => {
            try {
                const response = await fetch(url);
                const data = await response.json();
                return data;
            } catch (error) {
                console.error(error);
            }
        };

        const renderProvinsi = (provinsi) => {
            provinsi.forEach((provinsi) => {
                if (provinsi.id == '{{ $user->provinsi }}') {
                    dataProvinsi = provinsi.id;
                }
            });
        };

        const renderKabupaten = (kabupaten) => {
            kabupaten.forEach((kabupaten) => {
                if (kabupaten.id == '{{ $user->rayon }}') {
                    rayon1.innerHTML = kabupaten.nama;
                    rayon2.innerHTML = kabupaten.nama;
                }
            });
        };

        (async () => {
            const provinsiData = await fetchData('https://dev.farizdotid.com/api/daerahindonesia/provinsi');
            renderProvinsi(provinsiData.provinsi);

            const selectedProvinsi = dataProvinsi;
            const kabupatenData = await fetchData(
                `https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=${selectedProvinsi}`
            );
            renderKabupaten(kabupatenData.kota_kabupaten);
        })();
    </script>
@endsection
