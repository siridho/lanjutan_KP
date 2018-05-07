<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>Menu</h3>
    <ul class="nav side-menu">
      <li>
        <a href="{{url('/')}}"><i class="fa fa-briefcase"></i> Pilih Proyek </a>
      </li>
       @if((session()->get('pilihanproyek')))
  	  <li><a><i class="fa fa-database "></i> Tabel Acuan <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
           <!-- <li><a>Klien<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="{{ url('mitra-kerjas') }}">Mitra Kerja</a></li>
              <li><a href="{{url('customers')}}">Pelanggan</a></li>
              <li><a href="{{url('proyeks')}}">Proyek</a></li>
            </ul>
          </li> -->
          <li><a href="{{url('jenis-biaya-proyeks')}}">Jenis Biaya Proyek</a></li>
          <li><a href="{{url('materials')}}">Material</a></li>
          <li><a href="{{url('alats')}}">Alat</a></li>
          <li><a href="{{url('biaya-kas')}}">Biaya Kas</a></li>
          <li><a href="{{url('users')}}">EDP User</a></li>
          <li><a href="{{url('personal_manajemens')}}">Personal Manajemen</a></li>
          <li><a href="{{url('akuns')}}">Akun</a></li>
          <li><a href="{{url('rekenings')}}">Rekening Kas & Bank</a></li>
          <li><a href="{{url('kelompok_asets')}}">Kelompok Aset</a></li>
          <li><a href="{{url('mitra-kerjas')}}">Mitra Usaha / Pemasok</a></li>
          <li><a href="{{url('proyeks')}}">Proyek</a></li>
          <li><a href="{{url('kelompok_kegiatans')}}">Kelompok Kegiatan</a></li>
        </ul>
      </li>
      <li><a><i class="fa fa-inbox"></i> Pelaksanaan Proyek<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{url('nota-beli-materials')}}">Transaksi Pembelian Material</a></li>
          <li><a href="{{url('nota-terima-barangs')}}">Transaksi Penerimaan Material</a></li>
          <li><a href="{{url('nota-penggunaan-materials')}}">Transaksi Penggunaan Material</a></li>
          <li><a href="{{url('nota-kas-masuk')}}">Transaksi Penerimaan Kas</a></li>
          <li><a href="{{url('nota-pengeluaran-kass')}}">Transaksi Pengeluaran Kas</a></li>
          <li><a href="{{url('penetralan-kasbon')}}">Transaksi Penetralan Kasbon</a></li>
          <li><a href="{{url('memo_proyeks')}}">Memo Biaya Proyek</a></li>
          <li><a href="{{url('opname_volume_pekerjaans')}}">Opname Volume Pekerjaan</a></li>
        </ul>
      </li>
      <li><a><i class="fa fa-list-ul"></i> Perencanaan Teknik<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="{{url('raps')}}">Rencana Anggaran Pelaksanaan</a></li>
          <li><a href="{{url('rekap-rvm')}}">Rekapitulasi Rencana Volume Mingguan</a></li>
          <li><a href="{{url('rekap-rbm')}}">Rekapitulasi Rencana Biaya Mingguan</a></li>
        </ul>
      </li>
      <li><a><i class="fa fa-folder"></i> Laporan Proyek <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a><i class="fa fa-cubes"></i> Laporan Inventori <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{url('rekapitulasi-material')}}">Rekapitulasi Material Proyek</a></li>
              <li><a href="{{url('rangkuman-material')}}">Rangkuman Material Proyek</a></li>
              <li><a href="{{url('transaksi-material')}}">Transaksi Material Proyek</a></li>
              <li><a href="{{url('kartu-stok-material')}}">Kartu Stok Material</a></li>
              <li><a href="{{url('rekapitulasi-penggunaan-material')}}">Progres Biaya Proyek : Penggunaan Material</a></li>
            </ul>
          </li>
          <li><a><i class="fa fa-dollar"></i> Laporan Kas <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{url('rekapitulasi-biaya')}}">Rekapitulasi Kas Proyek</a></li>
              <li><a href="{{url('buku-kas')}}">Buku Kas</a></li>
              <li><a href="{{url('transaksi-kas')}}">Transaksi Kas Proyek</a></li>
              <li><a href="{{url('rekapitulasi-progres-biaya')}}">Rekapitulasi Progres Biaya</a></li>
            </ul>
          </li>
        </ul>
      </li>
      
      <li>
        <a><i class="fa fa-download"></i> Impor Data <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
           <li><a href="{{url('imporLapangan')}}"></i> Impor Lapangan</a></li>
            <li><a href="{{url('imporPusat')}}"></i> Impor Pusat</a></li>
        </ul>
      </li>
      <li>
        <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Keluar </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
      </li>
      @endif
    </ul>
  </div>
</div>
