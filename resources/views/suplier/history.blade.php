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
            <h1>Pengajuan Masukan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Simple Tables</li>
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
                <h3 class="card-title">Daftar Pengajuan Masuk</h3>

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
                      <th>Gambar</th>
                      <th>Anggaran IDR</th>
                      <th>Anggaran Pengajuan</th>
                      <th>Proposal</th>
                      <th>Suplier</th>
                      <th>Email</th>
                      <th>Alamat</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($pengajuan as $item)
                    <tr>
                      <td>{{ $item['nama_pengadaan'] }}</td>
                      <td>
                        <img src="{{ asset(Storage::url($item['gambar'])) }}" alt="img" style="height: 100px; width:100px">
                      </td>
                      <td>{{ number_format($item['anggaran'],0, "," ,".") }}</td>
                      <td>{{ number_format($item['anggaran_pengajuan'],0, "," ,".") }} </td>
                      <td>
                        <a href="{{ asset(Storage::url($item['proposal'])) }}" target="_blank" class="btn btn-outline-primary">Lihat Detail</a>
                      </td>
                      <td>{{ $item['nama_suplier'] }}</td>
                      <td>{{ $item['email_suplier'] }}</td>
                      <td>{{ $item['alamat_suplier'] }}</td>
                      <td>
                        @if($item['status_pengajuan'] == 0)
                          Pengajuan Ditolak
                        @endif
                        @if($item['status_pengajuan'] == 1)
                          Menunggu konfirmasi
                        @endif
                        @if($item['status_pengajuan'] == 2)
                          Pengajuan Diterima, Submit Laporan Pertanggung Jawaban <hr>
                          @if($item['laporan'] == "-")
                          <form action="tambahLaporan" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="{{ $item['id_pengajuan'] }}">
                            <label for="laporan" class="btn btn-block btn-outline-info btn-flat">Pilih File Laporan</label>
                            <input type="file" name="laporan" id="laporan" class="form-control" style="display: none" accept="application/pdf">
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </form>
                          @else
                          <a href="{{ asset(Storage::url($item['laporan'])) }}" class="btn btn-warning" target="_blank"><i class="fa fa-eye"></i>Lihat Laporan</a>
                          @endif
                        @endif
                        @if($item['status_pengajuan'] == 3)
                          Pengajuan Telah Selesai
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('parsial.footer');

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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
 </script>
</body>
</html>
