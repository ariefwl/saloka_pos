<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CSupplier;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Supplier;
use App\Models\Produk;

use Illuminate\Http\Request;

class CPembelian extends Controller
{
    public function index()
    {
        $supplier = Supplier::orderBy('nama')->get();
        return view('pembelian.index', compact('supplier'));
    }

    public function create($id)
    {
        $pemb = new Pembelian();
        $pemb->id_supplier = $id;
        $pemb->total_item = 0;
        $pemb->total_harga = 0;
        $pemb->diskon = 0;
        $pemb->bayar = 0;
        $pemb->save();

        session(['id_pembelian' => $pemb->id_pembelian]);
        session(['id_supplier' => $pemb->id_supplier ]);

        return redirect()->route('pembelian_detail.index');
    }

    public function data()
    {
        $pembelian = Pembelian::orderBy('id_pembelian', 'desc')->get();
        return datatables()
            ->of($pembelian)
            ->addIndexColumn()
            ->addColumn('tanggal', function($pembelian){
                return tgl_indo($pembelian->created_at, false);
            })
            ->addColumn('supplier', function($pembelian){
                return $pembelian->supplier->nama;
            })
            ->addColumn('aksi', function ($pembelian) {
                return '
                    <div class="btn-group">
                        <button onclick="hapus(`'. route('pembelian.destroy', $pembelian->id_pembelian) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        // return $request->all();

        // insert table Pembelian
        $pemb = Pembelian::findOrFail($request->id_pembelian);
        $pemb->total_item = $request->total_item;
        $pemb->total_harga = $request->total;
        $pemb->diskon = $request->diskon;
        $pemb->bayar = $request->bayar;
        $pemb->update();

        //update tambah stock
        $detail = PembelianDetail::where('id_pembelian', $pemb->id_pembelian)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            $produk->stok += $item->jumlah;
            $produk->update(); 
        }

        return redirect()->route('pembelian.index');
    }
}
