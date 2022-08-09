<!-- Modal -->
<div class="modal fade" id="ubahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Update Data Pengadaan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="updatePengadaan" method="post" role="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id_pengadaan" id="id_pengadaan" class="id_pengadaan">
            <div class="modal-body">
                    <div class="card-body">
                    <div class="form-group">
                        <label for="cekNama_p">Nama Pengadaan</label>
                        <input type="text" name="cekNama_p" id="cekNama_P" class="form-control nama_pengadaan" placeholder="Masukan Nama Pengadaan">
                    </div>
                    <div class="form-group">
                        <label for="cekDeskripsi">Deskripsi</label>
                        <textarea name="cekDeskripsi" class="form-control deskripsi" id="cekDeskripsi" cols="30" rows="3" placeholder="Masukan Deskripsi Pengadaan..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cekAnggaran">
                            Anggaran : <input type="" class="labelRp" style="border:none; background-color:white; color:black" disabled>
                        </label>
                        <input type="text" name="cekAnggaran" id="cekAnggaran" class="form-control anggaran" placeholder="Masukan Anggaran" onkeyup="curency2();">
                    </div>
                    </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
      </div>
    </div>
  </div>