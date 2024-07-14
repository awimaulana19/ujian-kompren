@extends('Admin.Layouts.app')

@section('title', 'Soal')

@section('content')
    <style>
        h6 p:first-child {
            display: inline;
        }
    </style>

    <div class="card p-4">
        <div id="warning-message"></div>
        <form action="{{ '/mahasiswa/soal/'. $matkul->id. '/' . Auth::user()->id }}" method="POST">
            @csrf
            <div class="row">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Soal</h4>
                    <h5 id="countdown"></h5>
                </div>
                @foreach ($soal as $item)
                    <div class="soal mb-3">
                        <h6>{{ $loop->iteration }}. {!! $item->soal !!}</h6>
                        @if ($item->gambar_soal)
                            <img src="{{ asset('storage/' . $item->gambar_soal) }}" class="mb-3" width="40%"
                                style="max-height: 400px">
                        @endif
                        <div class="pilih">
                            @foreach ($item->jawaban as $pilih)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="{{ 'soal' . $item->id }}"
                                        id="{{ 'radio' . $pilih->id }}" value="{{ $pilih->id }}">
                                    <label class="form-check-label"
                                        for="{{ 'radio' . $pilih->id }}">{{ chr($loop->iteration + 64) }}.
                                        {{ $pilih->jawaban }}</label>
                                </div>
                                @if ($pilih->gambar_jawaban)
                                    <img src="{{ asset('storage/' . $pilih->gambar_jawaban) }}" width="40%"
                                        style="max-height: 400px" class="mt-2 mb-2">
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </div>
        </form>
    </div>

    <script>
        const warningMessage = document.getElementById("warning-message");
        const form = document.querySelector("form");
        var countDownDate = new Date("{{ $matkul->finish_date }} {{ $matkul->finish_time }}").getTime();

        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerHTML = (days > 0 ? days + " hari " : "") +
                hours + " jam " +
                minutes + " menit " +
                seconds + " detik ";

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "Tes Selesai";
                document.querySelector('form').submit();
            }
        }, 1000);

        let counter = 0;
        const maxCount = 3;

        document.addEventListener("visibilitychange", function() {
            if (document.visibilityState === 'hidden') {
                counter++;
                if (counter === maxCount) {
                    form.submit();
                } else if (counter < maxCount) {
                    warningMessage.classList.add('alert', 'alert-danger');
                    warningMessage.textContent =
                        'Anda telah melanggar aturan. Jika Anda melakukan pelanggaran berulang kali, jawaban akan tersubmit.';
                    setTimeout(function() {
                        warningMessage.classList.remove('alert', 'alert-danger');
                        warningMessage.textContent = '';
                    }, 7000);
                }
            }
        });

        let counter2 = 0;

        window.addEventListener('blur', function() {
            counter2++;
            if (counter2 === maxCount) {
                form.submit();
            } else if (counter2 < maxCount) {
                warningMessage.classList.add('alert', 'alert-danger');
                warningMessage.textContent =
                    'Anda telah melanggar aturan. Jika Anda melakukan pelanggaran berulang kali, jawaban akan tersubmit.';
                setTimeout(function() {
                    warningMessage.classList.remove('alert', 'alert-danger');
                    warningMessage.textContent = '';
                }, 7000);
            }
        });
    </script>
@endsection
