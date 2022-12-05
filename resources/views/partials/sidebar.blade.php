<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ auth()->user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      {{-- @if ({{ auth()->user()->level }} == 1) --}}
        <ul class="sidebar-menu" data-widget="tree">
              <li>
                <a href="{{route('dashboard')}}">
                  <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                  <span class="pull-right-container">  
                  </span>
                </a>
              </li>

              <li class="header">MASTER DATA</li>
              <li>
                <a href="{{route('kategori.index')}}">
                  <i class="fa fa-dashboard"></i> <span>Kategori</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li>
                <a href="{{route('produk.index')}}">
                  <i class="fa fa-dashboard"></i> <span>Produk</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li>
                <a href="{{route('member.index')}}">
                  <i class="fa fa-dashboard"></i> <span>Member</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li>
                <a href="{{route('supplier.index')}}">
                  <i class="fa fa-dashboard"></i> <span>Supplier</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>

              <li class="header">TRANSAKSI</li>
              <li>
                <a href="{{route('pengeluaran.index')}}">
                  <i class="fa fa-dashboard"></i> <span>Pengeluaran</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li>
                <a href="{{route('pembelian.index')}}">
                  <i class="fa fa-dashboard"></i> <span>Pembelian</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li>
                <a href="{{route('penjualan.index')}}">
                  <i class="fa fa-dashboard"></i> <span>Penjualan</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li>
                <a href="{{route('transaksi.baru')}}">
                  <i class="fa fa-dashboard"></i> <span>Transaksi Baru</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li>
                <a href="{{route('transaksi.index')}}">
                  <i class="fa fa-dashboard"></i> <span>Transaksi Lama</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>

              <li class="header">LAPORAN</li>
              <li>
                <a href="{{route('laporan.index')}}">
                  <i class="fa fa-dashboard"></i> <span>Laporan Penjualan</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-dashboard"></i> <span>Laporan Pembelian</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>

              <li class="header">SYSTEM</li>
              <li>
                <a href="{{route('user.index')}}">
                  <i class="fa fa-dashboard"></i> <span>User</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-dashboard"></i> <span>Setting</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
        </ul>
      {{-- @endif --}}
        
        

    </section>
    <!-- /.sidebar -->
  </aside>