<div class="modal fade" id="{{ 'edit'.$item->id }}" tabindex="-1" aria-labelledby="{{ 'edit'.$item->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ 'edit'.$item->id }}Label">Edit Soal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="{{ 'formedit'.$item->id }}" enctype="multipart/form-data" action="{{ '/dosen/soal/edit/'.$item->id }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label mb-2">Soal</label>
                        <input type="hidden" name="soal" id="{{ 'soaledit'.$item->id }}">
                        <div id="{{ 'snowedit'.$item->id }}">
                            {!! $item->soal !!}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_soal" class="form-label">Gambar</label>
                        <input type="hidden" name="gambarSoalLama" id="gambarSoalLama" value="{{ $item->gambar_soal }}">
                        @if ($item->gambar_soal)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $item->gambar_soal) }}" width="50%">
                            </div>
                        @endif
                        <input type="file" id="gambar_soal" class="form-control" name="gambar_soal">
                    </div>
                    <div class="mb-3">
                        <label for="tingkat" class="form-label">Tingkatan Soal</label>
                        <select class="form-select" name="tingkat" id="tingkat">
                            <option value="">Pilih Tingkatan</option>
                            <option value="Mudah" {{ $item->tingkat === 'Mudah' ? 'selected' : '' }}>Mudah</option>
                            <option value="Menengah" {{ $item->tingkat === 'Menengah' ? 'selected' : '' }}>Menengah</option>
                            <option value="Sulit" {{ $item->tingkat === 'Sulit' ? 'selected' : '' }}>Sulit</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    var {{ 'snowedit'.$item->id }} = new Quill('{{ '#snowedit'.$item->id }}', {
        theme: 'snow'
    });
    
    document.querySelector('{{ '#formedit'.$item->id }}').onsubmit = function() {
        var {{ 'text'.$item->id }} = {{ 'snowedit'.$item->id }}.root.innerHTML;
        document.querySelector('{{ '#soaledit'.$item->id }}').value = {{ 'text'.$item->id }};
    }
</script>
