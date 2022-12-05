<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\PenjualanDetail;


class CPenjualan extends Controller
{
    public function index()
    {
        return view('penjualan.index');
    }


    public function create()
    {
        $penjualan = new Penjualan();
        $penjualan->id_member = null;
        $penjualan->total_item = 0;
        $penjualan->total_harga = 0;
        $penjualan->diskon = 0;
        $penjualan->bayar = 0;
        $penjualan->diterima = 0;
        $penjualan->id_user = auth()->id();
        $penjualan->save();

        session(['id_penjualan' => $penjualan->id_penjualan]);
        return redirect()->route('transaksi.index');
    }

    public function data()
    {
        $penjualan = Penjualan::orderBy('id_penjualan', 'desc')->get();
        return datatables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('tanggal', function($penjualan){
                return tgl_indo($penjualan->created_at, false);
            })
            ->addColumn('kode_member', function($penjualan){
                return $penjualan->member['kode_member'] ?? '';
            })
            ->addColumn('kasir', function($penjualan){
                return $penjualan->user->name ?? '';
            })
            ->addColumn('aksi', function ($penjualan) {
                return '
                    <div class="btn-group">
                        <button onclick="showDetail(`'. route('penjualan.show', $penjualan->id_penjualan) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                        <button onclick="hapus(`'. route('penjualan.destroy', $penjualan->id_penjualan) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show($id)
    {
        $detail = PenjualanDetail::with('produk')->where('id_penjualan', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('kode_produk', function($detail){
                return $detail->produk->kode_produk;
            })
            ->addColumn('nama_produk', function($detail){
                return $detail->produk->nama_produk;
            })
            ->addColumn('harga_jual', function($detail){
                return $detail->harga_jual;
            })
            ->addColumn('jumlah', function($detail){
                return $detail->jumlah;
            })
            ->addColumn('subtotal', function($detail){
                return $detail->subtotal;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        // return $request;

        // insert table PEnjualan
        $penj = Penjualan::findOrFail($request->id_penjualan);
        $penj->id_member = $request->id_member;
        $penj->total_item = $request->total_item;
        $penj->total_harga = $request->total;
        $penj->diskon = $request->diskon;
        $penj->bayar = $request->bayar;
        $penj->diterima = $request->terima;
        $penj->update();

        //update tambah stock
        $detail = PenjualanDetail::where('id_penjualan', $penj->id_penjualan)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            $produk->stok -= $item->jumlah;
            $produk->update(); 
        }

        return redirect()->route('transaksi.selesai');
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        $detail = PenjualanDetail::where('id_penjualan', $penjualan->id_penjualan)->get();
        foreach($detail as $det){
            $det->delete();
        }
        $penjualan->delete();
        
        return response(null, 204);
    }

    public function selesai()
    {
        // $setting = Setting::first();
        return view('penjualan.selesai');
    }

    public function cetaknota()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('id_penjualan'));
        if(!$penjualan){
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
                    ->where('id_penjualan', session('id_penjualan'))
                    ->get();
        return view('penjualan.nota', compact('setting', 'penjualan', 'detail'));
    }
}
