<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_direktorat">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Direktorat</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
          <div class="modal-body">

            <input type="hidden" id="direktorat_id">
            <div class="form-group">
                <label>Nama Direktorat</label>
                <input type="text" class="form-control" name="direktorat" id="edit_direktorat">
                <div class="mt-2 alert alert-danger d-none" role="alert" id="alert-supplier"></div>
            </div>
            <div class="form-group">
                <label>Lokasi Gedung</label>
                <textarea class="form-control" name="lokasi" id="edit_lokasi" rows="3"></textarea>
                <div class="mt-2 alert alert-danger d-none" role="alert" id="alert-alamat"></div>
            </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
          <button type="button" class="btn btn-primary" id="update">Tambah</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>



