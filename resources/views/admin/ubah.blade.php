<!-- Modal -->
<div class="modal fade" id="ubahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Update Data Admin</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/updateAdmin" method="post" role="form">
          {{ csrf_field() }}
            <input type="hidden" name="id_admin" id="id_admin" class="id_admin">
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="ceknama" id="ceknama" class="form-control nama">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="cekemail" id="cekemail" class="form-control email">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" name="cekalamat" id="cekalamat" class="form-control alamat">
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