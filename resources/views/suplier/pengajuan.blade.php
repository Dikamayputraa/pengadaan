<!-- Modal -->
<div class="modal fade" id="pengajuanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/tambahPengajuan" method="post" role="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id_pengadaan" id="id_pengadaan" class="id_pengadaan">
            <div class="modal-body">
                    <div class="card-body">
                    <div class="form-group">
                        <label for="namaPengadaan">Nama Pengadaan</label>
                        <input type="text" name="namaPengadaan" id="namaPengadaan" class="form-control nama_pengadaan" placeholder="Masukan Nama Pengadaan" disabled>
                    </div>
                    <div class="form-group">
                        <label>
                            Anggaran : Rp.<input type="" class="labelRp" style="border:none; background-color:white; color:black" disabled>
                        </label>
                        <input type="text" name="anggaran" id="anggaran" class="form-control anggaran" placeholder="Masukan Anggaran" onkeyup="curency()">
                    </div>
                    <div class="form-group">
                        <label for="proposal">Proposal</label>
                        <input type="file" name="proposal" id="proposal" class="form-control" accept="application/pdf" placeholder="Format Pdf">
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