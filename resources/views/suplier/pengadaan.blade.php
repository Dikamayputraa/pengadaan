<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pengadaan</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminLTE/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css')}}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('adminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('adminLTE/plugins/toastr/toastr.min.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    @include('suplier.setting');
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      @include('suplier.user')

      @include('suplier.menu');

    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Daftar Pengadaan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"> Tables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pengadaan</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>Nama Pengadaan</th>
                      <th>Deskripsi</th>
                      <th>gambar</th>
                      <th>Anggaran</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($pengadaans as $pengadaan)
                    <tr>
                      <td>{{ $pengadaan -> nama_pengadaan }}</td>
                      <td>
                        <a href="{{ $pengadaan -> deskripsi }}" target="_blank">Lihat Detail</a>
                      </td>
                      <td>
                        @if(@$pengadaan->gambar != "-")
                        <img src="{{ asset(Storage::url($pengadaan -> gambar)) }}" style="width: 100px" height="100px" alt=""><hr>
                        @else
                        <form action="uploadGambar" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <input type="hidden" name="id_pengadaan" id="id_pengadaan" value="{{ $pengadaan -> id_pengadaan }}">
                          <label for="gambar" class="btn btn-block btn-outline-info btn-flat">Gambar Pengadaan</label>
                          <input type="file" name="gambar" id="gambar" class="form-control" style="display: none">
                          <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                        @endif
                      </td>
                      <td><span class="tag tag-success">{{ number_format($pengadaan -> anggaran,0, "," ,".") }}</span></td>
                      <td>
                        <button class="btn btn-success detail" data-toggle="modal" data-target="#pengajuanModal"
                          data-id_pengadaan="{{ $pengadaan->id_pengadaan }}"
                          data-nama_pengadaan="{{ $pengadaan->nama_pengadaan }}"
                          data-anggaran="{{ $pengadaan->anggaran }}">
                          <i class="fas fa-plus"></i> Ajukan</button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

              {{-- pagination --}}
              <div class="d-flex justify-content-center">
                {{ $pengadaans -> links() }}
              </div>

            </div>
            <!-- /.card -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  {{-- @include('parsial.footer'); --}}
  @include('suplier.pengajuan');

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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

<!-- jQuery -->
<script src="{{ asset('adminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminLTE/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
 <!-- SweetAlert2 -->
<script src="{{ asset('adminLTE/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{ asset('adminLTE/plugins/toastr/toastr.min.js')}}"></script>

  <script>
    $(function() {
      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      @if(\Session::has('berhasil'))
      Toast.fire({
        icon: 'success',
        title: '{{ Session::get('berhasil') }}'
      })
      @endif

      @if(\Session::has('gagal'))
      Toast.fire({
        icon: 'error',
        title: '{{ Session::get('gagal') }}'
      })
      @endif
      
      @if (count($errors) > 0)
        Toast.fire({
          icon: 'error',
          title: '<ul>@foreach($errors->all() as $error)<li>{{$error}}</li>@endforeach</ul>'
        })
      @endif
    });
    function curency(){
        var input = document.getElementById("anggaran");
        $(".labelRp").val(formatRupiah(input.value));
    }
    // function curency2(){
    //     var input = document.getElementById('cekAnggaran');
    //     $('.labelRp').val(formatRupiah(input.value));
    // }

    function formatRupiah(angka,prefix){
      var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
      split       = number_string.split(','),
      sisa        = split[0].length % 3,
      rupiah      = split[0].substr(0, sisa),
      ribuan      = split[0].substr(sisa).match(/\d{3}/gi);

      if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');

      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $(document).on('click', '.detail', function(){
          var nama_pengadaan = $(this).data('nama_pengadaan');
          var anggaran = $(this).data('anggaran');
          var id_pengadaan = $(this).data('id_pengadaan');

          $(".nama_pengadaan").val(nama_pengadaan);
          $(".anggaran").val(anggaran);
          $(".id_pengadaan").val(id_pengadaan);
          $(".labelRp").val(formatRupiah(anggaran, ''));
        });
</script>
</body>
</html>
