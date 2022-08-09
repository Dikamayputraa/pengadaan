      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="/">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>

          @if($token == 'kosong')
          <li><a class="nav-link scrollto" href="/login">Masuk</a></li>
          <li><a class="getstarted scrollto" href="/registrasi">Daftar</a></li>
          @else
          <li><a class="nav-link scrollto" href="/listSuplier">Pengajuan</a></li>
          <li><a class="nav-link scrollto" href="/logout">Keluar</a></li>
          @endif
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->