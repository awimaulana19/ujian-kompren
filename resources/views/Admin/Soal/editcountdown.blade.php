<div class="modal fade" id="editCountdown" tabindex="-1" aria-labelledby="editCountdownLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editCountdownLabel">Edit Waktu Ujian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formeditcountdown" action="{{ '/countdown/edit/'.$countdown->id }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="countdown_date" class="form-label">Tanggal</label>
                        <input type="date" id="countdown_date" class="form-control" name="countdown_date" value="{{ $countdown->countdown_date }}">
                    </div>
                    <div class="mb-3">
                        <label for="countdown_time" class="form-label">Jam</label>
                        <input type="time" id="countdown_time" class="form-control" name="countdown_time" value="{{ $countdown->countdown_time }}">
                    </div>
            </div>
            <div class="modal-footer">
                <a href="{{ '/countdown/hapus/'.$countdown->id }}" class="btn btn-success">Ujian Selesai</a>
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
            </form>
        </div>
    </div>
</div>
