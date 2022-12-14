<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\PembelianDetail;

class CPembelianDetail extends Controller
{
    public function index()
    {   
        $id_pembelian = session('id_pembelian');
        $produk = Produk::orderBy('nama_produk')->get();
        $supplier = Supplier::find(session('id_supplier'));

        // return session('id_supplier');
        if(! $supplier){
            abort(404);
        }

        return view('pembelian_detail.index', compact('id_pembelian', 'produk', 'supplier'));
    }

    public function store(Request $request)
    {   
        $produk = Produk::where('id_produk', $request->id_produk)->first();
        if (! $produk) {
            return response()->json('Data gagal di tambahkan !', 400);
        }

        $detail = new PembelianDetail();
        $detail->id_pembelian = $request->id_pembelian;
        $detail->id_produk = $produk->id_produk;
        $detail->harga_beli = $produk->harga_beli;
        $detail->jumlah = 1;
        $detail->subtotal = $produk->harga_beli; 
        $detail->save();    

        return response()->json('Data berhasil di tambahkan !', 200);
    }

    public function data($id)
    {
        $detail = PembelianDetail::with('produk')
                  ->where('id_pembelian', $id)
                  ->get();
        // return $detail;
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['kode_produk'] = $item->produk['kode_produk'];
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_beli'] = 'Rp.'. format_uang($item->harga_beli);
            $row['jumlah'] = '<input type="number" data-id="'.$item->id_pembelian_detail.'" class="form-control input-sm qty" value="'. $item->jumlah .'" />';
            $row['subtotal'] = 'Rp.'.format_uang($item->subtotal);
            $row['aksi'] = '<div class="btn-group">
                                <button onclick="hapus(`'. route('pembelian_detail.destroy', $item->id_pembelian_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                            </div>';
            $data[] = $row;

            $total += $item->harga_beli * $item->jumlah;
            $total_item += $item->jumlah;
        }
        $data[] = [
            'kode_produk' => '
                 <div class="total hide">'.$total.'</div> 
                 <div class="total_item hide">'.$total_item.'</div>',
            'nama_produk' => '',
            'harga_beli' => '',
            'jumlah' => '',
            'subtotal' => '',
            'aksi' => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'jumlah', 'kode_produk'])
            ->make(true);
    }

    public function destroy($id)
    {
        $detail = PembelianDetail::find($id);
        $detail->delete();
        return response(null, 204);
    }

    public function update(Request $request, $id)
    {
        $detail = PembelianDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_beli * $request->jumlah;
        $detail->update();
    }

    public function loadForm($diskon, $total)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $data = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). 'Rupiah')
        ];
        return response()->json($data);
    }
}
