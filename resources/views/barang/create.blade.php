<div class="modal fade" tabindex="-1" role="dialog" id="modal_tambah_barang">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Gambar</label>
                  <input type="file" class="form-control" name="gambar" id="gambar" onchange="previewImage()">
                  <img src="" class="mt-2 mb-3 img-preview img-fluid" id="preview" style="max-height: 275px; overflow:hidden; border: 1px solid black;">
                  <div class="mt-2 alert alert-danger d-none" role="alert" id="alert-gambar"></div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Nama Barang</label>
                  <input type="text" class="form-control" name="nama_barang" id="nama_barang">
                  <div class="mt-2 alert alert-danger d-none" role="alert" id="alert-nama_barang"></div>
                </div>
                <div class="form-group">
                  <label>Jumlah Barang</label>
                  <input type="number" class="form-control" name="jumlah_barang" id="jumlah_barang">
                  <div class="mt-2 alert alert-danger d-none" role="alert" id="alert-jumlah_barang"></div>
                </div>
                <div class="form-group">
                  <label>Lama pemeliharaan (hari) </label>
                  <input type="harga" class="form-control" name="pemeliharaan" id="pemeliharaan">
                  <div class="mt-2 alert alert-danger d-none" role="alert" id="alert-pemeliharaan"></div>
                </div>
                <div class="form-group">
                  <label>Jenis Barang</label>
                  <select class="form-control" name="jenis_id" id="jenis_id">
                    @foreach ($jenis_barangs as $jenis)
                        @if (old('jenis_id') == $jenis->id)
                          <option value="{{ $jenis->id }}" selected>{{ $jenis->jenis_barang }}</option>
                        @else
                          <option value="{{ $jenis->id }}">{{ $jenis->jenis_barang }}</option>
                        @endif
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Apakah Barang Termasuk Asset</label>
                  <select class="form-control" name="jenis_id" id="jenis_id">
                          <option value="1" selected>YA</option>
                          <option value="0">Tidak</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Kondisi Barang</label>
                  <select class="form-control" name="jenis_id" id="jenis_id">
                          <option value="1" selected>Baik</option>
                          <option value="2">Rusak Ringan</option>
                          <option value="3">Rusak</option>
                  </select>
                </div>
            </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
          <button type="button" class="btn btn-primary" id="store">Tambah</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>



