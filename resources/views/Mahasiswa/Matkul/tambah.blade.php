<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Soal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formtambah" enctype="multipart/form-data" action="/dosen/soal" method="POST">
                    @csrf
                    <input type="hidden" name="matkul_id" value="{{ $matkul->id }}">
                    <div class="mb-3">
                        <label class="form-label mb-2">Soal</label>
                        <input type="hidden" name="soal" id="soal">
                        <div id="snow"></div>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_soal" class="form-label">Gambar</label>
                        <input type="file" id="gambar_soal" class="form-control" name="gambar_soal">
                    </div>
                    <div class="mb-3">
                        <label for="tingkat" class="form-label">Tingkatan Soal</label>
                        <select class="form-select" name="tingkat" id="tingkat">
                            <option value="">Pilih Tingkatan</option>
                            <option value="Mudah">Mudah</option>
                            <option value="Menengah">Menengah</option>
                            <option value="Sulit">Sulit</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    var snow = new Quill('#snow', {
        theme: 'snow'
    });

    document.querySelector('#formtambah').onsubmit = function() {
        var text = snow.root.innerHTML;
        document.querySelector('#soal').value = text;
    }
</script>
