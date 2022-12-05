<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CKategori;
use App\Http\Controllers\CMember;
use App\Http\Controllers\CProduk;
use App\Http\Controllers\CLaporan;
use App\Http\Controllers\CSupplier;
use App\Http\Controllers\CPengeluaran;
use App\Http\Controllers\CPenjualan;
use App\Http\Controllers\CPembelian;
use App\Http\Controllers\CPembelianDetail;
use App\Http\Controllers\CPenjualanDetail;
use App\Http\Controllers\CUser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', fn () => redirect()->route('login'));

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('/kategori/data', [CKategori::class, 'data'])->name('kategori.data');
    Route::resource('/kategori', CKategori::class);

    Route::get('/produk/data', [CProduk::class, 'data'])->name('produk.data');
    Route::resource('/produk', CProduk::class);
    Route::post('/produk/hapus-terpilih', [CProduk::class, 'hapusTerpilih'])->name('produk.hapus_terpilih');
    Route::post('/produk/cetak-barcode', [CProduk::class, 'cetakBarcode'])->name('produk.cetak_barcode');

    Route::get('/member/data', [CMember::class, 'data'])->name('member.data');
    Route::resource('/member', CMember::class);
    Route::post('/member/cetak-member', [CMember::class, 'cetakMember'])->name('member.cetak_member');

    Route::get('/supplier/data', [CSupplier::class, 'data'])->name('supplier.data');
    Route::resource('/supplier', CSupplier::class);

    Route::get('/pengeluaran/data', [CPengeluaran::class, 'data'])->name('pengeluaran.data');
    Route::resource('/pengeluaran', CPengeluaran::class);

    Route::get('/pembelian/data', [CPembelian::class, 'data'])->name('pembelian.data');
    Route::get('/pembelian/{id}/create', [CPembelian::class, 'create'])->name('pembelian.create');
    Route::resource('/pembelian', CPembelian::class)->except('create');

    Route::get('/pembelian_detail/{id}/data', [CPembelianDetail::class, 'data'])->name('pembelian_detail.data');
    Route::get('/pembelian_detail/loadform/{diskon}/{total}', [CPembelianDetail::class, 'loadForm'])->name('pembelian_detail.load_form');
    Route::resource('/pembelian_detail', CPembelianDetail::class)->except('create', 'show', 'edit');

    Route::get('/penjualan/data', [CPenjualan::class, 'data'])->name('penjualan.data');
    Route::get('/penjualan', [CPenjualan::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/{id}', [CPenjualan::class, 'show'])->name('penjualan.show');
    Route::delete('/penjualan/{id}', [CPenjualan::class, 'destroy'])->name('penjualan.destroy');

    Route::get('/transaksi/baru', [CPenjualan::class, 'create'])->name('transaksi.baru');
    Route::post('/transaksi/simpan', [CPenjualan::class, 'store'])->name('transaksi.simpan');
    Route::get('/transaksi/selesai', [CPenjualan::class, 'selesai'])->name('transaksi.selesai');
    Route::get('/transaksi/cetaknota', [CPenjualan::class, 'cetakNota'])->name('transaksi.cetak_nota');

    Route::get('/transaksi/{id}/data', [CPenjualanDetail::class, 'data'])->name('transaksi.data');
    Route::get('/transaksi/loadform/{id}/{total}/{diterima}', [CPenjualanDetail::class, 'loadForm'])->name('transaksi.load_form');
    Route::resource('/transaksi', CPenjualanDetail::class)->except('show');


    Route::get('/laporan', [CLaporan::class, 'index'])->name('laporan.index');
    Route::post('/laporan', [CLaporan::class, 'refres'])->name('laporan.refresh');
    // Route::get('/laporan/data/{awal}/{akhir}', [CLaporan::class, 'data'])->name('laporan.data');
    Route::get('/laporan/data', [CLaporan::class, 'data'])->name('laporan.data');
    // Route::get('/laporan/pdf/{awal}/{akhir}', [CLaporan::class, 'exportPDF'])->name('laporan.export_pdf');
    Route::post('/laporan/pdf', [CLaporan::class, 'exportPdf'])->name('laporan.export_pdf');

    Route::get('/user/data', [CUser::class, 'data'])->name('user.data');
    Route::resource('/user', CUser::class);
});
