<!-- Modal -->
<div class="modal fade" id="pengadaanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Pengadaan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="tambahPengadaan" method="post" role="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
                    <div class="card-body">
                    <div class="form-group">
                        <label for="nama_p">Nama Pengadaan</label>
                        <input type="text" name="nama_p" id="nama_P" class="form-control" placeholder="Masukan Nama Pengadaan">
                    </div>
                    <div class="form-group">
                        <label for="email">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="deskripsi" cols="30" rows="3" placeholder="Masukan Deskripsi Pengadaan..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="gambar">Gambar</label>
                        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/png, image/jpg, image/jpeg" placeholder="Format Gambar : PNG, JPG, GIF">
                    </div>
                    <div class="form-group">
                        <label for="anggaran">
                            Anggaran : <input type="" class="labelRp" style="border:none; background-color:white; color:black" disabled>
                        </label>
                        <input type="text" name="anggaran" id="anggaran" class="form-control" placeholder="Masukan Anggaran" onkeyup="curency();">
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