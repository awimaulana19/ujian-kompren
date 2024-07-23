<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Halaman Register Akun</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />


    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>


</head>

<body>
    <!-- Content -->
    @include('sweetalert::alert')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center text-center">
                            <h3>Pendaftaran Akun</h3>
                        </div>
                        @if (session('pesan-danger'))
                            <p class="alert alert-danger">{{ session('pesan-danger') }}</p>
                        @endif
                        <!-- /Logo -->
                        <form action="{{ url('/regis') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control" id="roles" name="roles"
                                value="mahasiswa" />
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Enter your name" autofocus />
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username/Nim</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Enter your username" autofocus />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="Enter your password" aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="sk_kompren">SK Kompren</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="file" id="sk_kompren" class="form-control" name="sk_kompren"
                                        placeholder="Masukkan Password" aria-describedby="sk_kompren" accept=".pdf" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="penguji_1" class="form-label">Penguji 1</label>
                                <select name="penguji_1" id="penguji_1" class="form-select"
                                    onchange="updateMatkul1()">
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($dosen as $row)
                                        <option value="{{ $row->id }}">
                                            {{ $row->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <select name="matkul_1" id="matkul_1" class="form-select mt-2">
                                    <option value="">Pilih Matkul</option>
                                </select>
                                <input type="hidden" id="value_matkul_1">
                            </div>
                            <div class="mb-3">
                                <label for="penguji_2" class="form-label">Penguji 2</label>
                                <select name="penguji_2" id="penguji_2" class="form-select"
                                    onchange="updateMatkul2()">
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($dosen as $row)
                                        <option value="{{ $row->id }}">
                                            {{ $row->nama }}</option>
                                    @endforeach
                                </select>
                                <select name="matkul_2" id="matkul_2" class="form-select mt-2">
                                    <option value="">Pilih Matkul</option>
                                </select>
                                <input type="hidden" id="value_matkul_2">
                            </div>
                            <div class="mb-3">
                                <label for="penguji_3" class="form-label">Penguji 3</label>
                                <select name="penguji_3" id="penguji_3" class="form-select"
                                    onchange="updateMatkul3()">
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($dosen as $row)
                                        <option value="{{ $row->id }}">
                                            {{ $row->nama }}</option>
                                    @endforeach
                                </select>
                                <select name="matkul_3" id="matkul_3" class="form-select mt-2">
                                    <option value="">Pilih Matkul</option>
                                </select>
                                <input type="hidden" id="value_matkul_3">
                            </div>
                            <div class="mt-5">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign Up</button>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ url('/login') }}" class="text-decoration-underline mt-3">Login
                                        Akun</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            await updateMatkul1();
        });

        async function updateMatkul1() {
            const penguji = document.getElementById('penguji_1').value;
            const value_matkul = document.getElementById('value_matkul_1').value;

            document.getElementById('matkul_1').innerHTML =
                '<option value="">Pilih Matkul</option>';
            document.getElementById('matkul_1').disabled = true;

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
                    document.getElementById('matkul_1').appendChild(option);
                });

                document.getElementById('matkul_1').disabled = false;
            } catch (error) {
                console.error(error);
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            await updateMatkul2();
        });

        async function updateMatkul2() {
            const penguji = document.getElementById('penguji_2').value;
            const value_matkul = document.getElementById('value_matkul_2').value;

            document.getElementById('matkul_2').innerHTML =
                '<option value="">Pilih Matkul</option>';
            document.getElementById('matkul_2').disabled = true;

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
                    document.getElementById('matkul_2').appendChild(option);
                });

                document.getElementById('matkul_2').disabled = false;
            } catch (error) {
                console.error(error);
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            await updateMatkul3();
        });

        async function updateMatkul3() {
            const penguji = document.getElementById('penguji_3').value;
            const value_matkul = document.getElementById('value_matkul_3').value;

            document.getElementById('matkul_3').innerHTML =
                '<option value="">Pilih Matkul</option>';
            document.getElementById('matkul_3').disabled = true;

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
                    document.getElementById('matkul_3').appendChild(option);
                });

                document.getElementById('matkul_3').disabled = false;
            } catch (error) {
                console.error(error);
            }
        }
    </script>

</body>

</html>
