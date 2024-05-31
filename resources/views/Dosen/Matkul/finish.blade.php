<div class="modal fade" id="finish" tabindex="-1" aria-labelledby="finishLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="finishLabel">Atur Ujian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formfinish" enctype="multipart/form-data" action="/dosen/finish/{{ $matkul->id }}"
                    method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="jumlah_soal" class="form-label">Jumlah Soal</label>
                        <input type="number" id="jumlah_soal" class="form-control" name="jumlah_soal" required value="{{ $matkul->jumlah_soal }}">
                    </div>
                    <div class="mb-3">
                        <label for="finish_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" id="finish_date" class="form-control" name="finish_date" required value="{{ $matkul->finish_date }}">
                    </div>
                    <div class="mb-3">
                        <label for="finish_time" class="form-label">Jam Selesai</label>
                        <input type="time" id="finish_time" class="form-control" name="finish_time" required value="{{ $matkul->finish_time }}">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                @if ($matkul->finish_time && $matkul->finish_date)
                    <a href="/dosen/end/{{ $matkul->id }}" class="btn btn-danger">Akhiri</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                @else
                    <button type="submit" class="btn btn-primary">Mulai</button>
                @endif
            </div>
            </form>
        </div>
    </div>
</div>
