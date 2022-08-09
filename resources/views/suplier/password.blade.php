<!-- Modal -->
<div class="modal fade" id="passwordSup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Ganti Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="password" method="post" role="form">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label for="passwordLama">Password Lama</label>
                        <input type="password" name="passwordLama" id="passwordLama" class="form-control" placeholder="Masukan Password Lama">
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukan Password Baru">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>
      </div>
    </div>
  </div>