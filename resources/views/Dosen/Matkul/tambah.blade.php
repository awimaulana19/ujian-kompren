<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Soal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formtambah" enctype="multipart/form-data" action="/dosen/soal" method="POST">
                <div class="modal-body">
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
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="m-0">Jawaban</h6>
                        <div class="d-flex gap-2">
                            <button type="button" id="bersihkan-jawaban-btn" class="btn btn-danger">Bersihkan</button>
                            <button type="button" id="add-jawaban-btn" class="btn btn-secondary">Tambah</button>
                        </div>
                    </div>
                    <div id="jawaban-container">
                        <div class="mb-3 jawaban-item">
                            <label for="jawabanA" class="form-label">Jawaban A :</label>
                            <input class="form-control" type="text" name="jawaban[]">
                            <div class="mt-3">
                                <label for="gambar_jawabanA" class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="gambar_jawaban[]">
                            </div>
                        </div>
                        <div class="mb-3 jawaban-item">
                            <label for="jawabanB" class="form-label">Jawaban B :</label>
                            <input class="form-control" type="text" name="jawaban[]">
                            <div class="mt-3">
                                <label for="gambar_jawabanB" class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="gambar_jawaban[]">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label me-3">Jawaban Benar :</label>
                        <div id="jawaban-benar-container">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="benar" id="radioA"
                                    value="A">
                                <label class="form-check-label" for="radioA">A</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="benar" id="radioB"
                                    value="B">
                                <label class="form-check-label" for="radioB">B</label>
                            </div>
                        </div>
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
    document.getElementById('add-jawaban-btn').addEventListener('click', function() {
        let jawabanContainer = document.getElementById('jawaban-container');
        let jawabanBenarContainer = document.getElementById('jawaban-benar-container');

        let jawabanCount = jawabanContainer.querySelectorAll('.jawaban-item').length;
        let jawabanLabel = String.fromCharCode(65 + jawabanCount);

        let newJawabanItem = document.createElement('div');
        newJawabanItem.classList.add('mb-3', 'jawaban-item');
        newJawabanItem.innerHTML = `
            <label class="form-label">Jawaban ${jawabanLabel} :</label>
            <input class="form-control" type="text" name="jawaban[]">
            <div class="mt-3">
                <label class="form-label">Gambar</label>
                <input type="file" class="form-control" name="gambar_jawaban[]">
            </div>
        `;
        jawabanContainer.appendChild(newJawabanItem);

        let newRadio = document.createElement('div');
        newRadio.classList.add('form-check', 'form-check-inline');
        newRadio.innerHTML = `
            <input class="form-check-input" type="radio" name="benar" id="radio${jawabanLabel}" value="${jawabanLabel}">
            <label class="form-check-label" for="radio${jawabanLabel}">${jawabanLabel}</label>
        `;
        jawabanBenarContainer.appendChild(newRadio);
    });

    document.getElementById('bersihkan-jawaban-btn').addEventListener('click', function() {
        let jawabanContainer = document.getElementById('jawaban-container');
        let jawabanBenarContainer = document.getElementById('jawaban-benar-container');

        while (jawabanContainer.children.length > 2) {
            jawabanContainer.removeChild(jawabanContainer.lastChild);
        }

        while (jawabanBenarContainer.children.length > 2) {
            jawabanBenarContainer.removeChild(jawabanBenarContainer.lastChild);
        }
    });
</script>

<script>
    var snow = new Quill('#snow', {
        theme: 'snow'
    });

    document.querySelector('#formtambah').onsubmit = function() {
        var text = snow.root.innerHTML;
        document.querySelector('#soal').value = text;
    }
</script>
