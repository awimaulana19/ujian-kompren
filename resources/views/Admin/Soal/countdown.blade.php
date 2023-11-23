<div class="modal fade" id="countdown" tabindex="-1" aria-labelledby="countdownLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="countdownLabel">Buat Waktu Ujian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formcountdown" enctype="multipart/form-data"
                    @if ($tingkat == 'sd') action="/countdownsd" @elseif ($tingkat == 'smp') action="/countdownsmp" @elseif ($tingkat == 'sma') action="/countdownsma" @endif
                    method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="countdown_date" class="form-label">Tanggal</label>
                        <input type="date" id="countdown_date" class="form-control" name="countdown_date">
                    </div>
                    <div class="mb-3">
                        <label for="countdown_time" class="form-label">Jam</label>
                        <input type="time" id="countdown_time" class="form-control" name="countdown_time">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Buat</button>
            </div>
            </form>
        </div>
    </div>
</div>
