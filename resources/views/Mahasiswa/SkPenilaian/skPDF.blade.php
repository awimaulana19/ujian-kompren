<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Penilaian</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            padding: 0px 100px 100px 100px;
        }

        .header {
            display: flex;
            align-items: center;
            padding: 20px 20px 0px 20px;
        }

        .logo {
            width: 14%;
            /* Sesuaikan lebar logo */
        }

        .kampus {
            width: 86%;
            text-align: center;
            padding: 0px 20px;
        }

        .penguji {
            display: flex;
        }

        .penguji .label {
            width: 25%;
            margin-bottom: 0px;
        }

        .penguji .isi {
            width: 75%;
            margin-bottom: 0px;
        }


        .garis {
            border-bottom: 2px solid #000;
            margin: 10px 0;
        }

        .keterangan {
            margin-top: 20px;
            text-align: center;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            text-align: left;
        }

        th,
        td {
            padding: 10px;
        }

        .nilai-subcol {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            /* Baris baru jika tidak cukup lebar */
        }

        .rowttd {
            display: flex;
        }

        .col_ttd8 {
            width: 76%;
        }

        .col_ttd4 {
            width: 24%;
            margin-top: 80px;
            margin-left: auto;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">
            <!-- Ganti dengan tag img untuk logo -->
            <img width="100%" src="{{ asset('assets2/img/logo_uin.png') }}" alt="">
        </div>
        <div class="kampus">
            <h2 style="margin: 0;">KEMENTERIAN AGAMA R.I</h2>
            <h2 style="margin: 0;">UNIVERSITAS ISLAM NEGERI ALAUDDIN MAKASSAR</h2>
            <h2 style="margin: 0;">FAKULTAS SAINS DAN TEKNOLOGI</h2>
            <h2 style="margin: 0;">JURUSAN SISTEM INFORMASI</h2>
            <p style="margin: 0;">Kampus I : Jln. Sultan Alauddin No. 63 Telp. 864924 (Fax 864923) Makassar</p>
            <p style="margin: 0;">Kampus II : Jln. HM. Yasin Limpo No.36 Romang Polong - Gowa Telp. (0411) 8417879</p>
        </div>
    </div>

    <div class="garis"></div>

    <div class="keterangan">
        <h2>DAFTAR NILAI</h2>
        <h2 style="margin-bottom: 60px;">UJIAN AKHIR PROGRAM STUDI / KOMPREHENSHIP</h2>
    </div>
    <div class="penguji">
        <h3 class="label">DOSEN PENGUJI</h3>
        <h3 class="isi">: {{ $request->dosen_penguji }}</h3>
    </div>
    <div class="penguji">
        <h3 class="label">MATA KULIAH</h3>
        <h3 class="isi">: {{ $request->mata_kuliah }}</h3>
    </div>


    <table>
        <thead>
            <tr>
                <th style="text-align: center;" rowspan="2">Nama/NIM</th>
                <th style="text-align: center;" colspan="2">Nilai</th>
                <th style="text-align: center;" rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th style="text-align: center;">Huruf</th>
                <th style="text-align: center;">Angka</th>
            </tr>
        </thead>
        <tbody>
            <!-- Isi tabel sesuai kebutuhan -->
            <tr>
                <td style="text-align: center">{{ $request->nama_mahasiswa }} / {{ $request->nim_mahasiswa }}</td>
                <td style="text-align: center">{{ $nilai_huruf }}</td>
                <td style="text-align: center">{{ $request->nilai_angka }}</td>
                <td style="text-align: center">{{ $keterangan }}</td>
            </tr>
            <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>
    </table>

    <div class="row_ttd">
        <div class="col_ttd8"></div>
        <div class="col_ttd4">
            <p>Romangpolong, {{ $tanggal_sk }}</p>
            <p>Penguji,</p>
            <p style="padding-top: 60px;">{{ $request->dosen_penguji }}</p>
        </div>
    </div>

</body>

</html>
