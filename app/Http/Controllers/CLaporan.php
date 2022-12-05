<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use PDF;

class CLaporan extends Controller
{
    public function index(Request $request)
    {   
        // return $request;
        // $tgl_awal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        // $tgl_akhir = date('Y-m-d');
        // $tgl_awal = date('Y-m-d',strtotime('2022-11-01'));
        // $tgl_akhir = date('Y-m-d',strtotime('2022-11-30'));
        // return view('laporan.index', compact('tgl_awal', 'tgl_akhir'));
        return view('laporan.index');
    }

    public function data(Request $request)
    {
        // dd($request->awal, $request->akhir);
        // $tgl_awal = date('Y-m-d',strtotime('2021-08-02'));
        // $tgl_akhir = date('Y-m-d',strtotime('2021-08-15'));
        
        if (request()->ajax()) {
            
            if(!empty($request->awal)){
                $penjualan = Penjualan::whereBetween('penjualan.created_at', [$request->awal, $request->akhir])
                ->orderBy('penjualan.id_penjualan', 'desc')
                ->get();    
            } else {
                $penjualan = Penjualan::orderBy('id_penjualan', 'desc')->get();
            }

            return datatables()
                ->of($penjualan)
                ->addIndexColumn()
                ->addColumn('tanggal', function($penjualan){
                    return tgl_indo($penjualan->created_at, false);
                })
                ->addColumn('nama', function($penjualan){
                    return $penjualan->member['nama'] ?? '';
                })
                // ->addColumn('kasir', function($penjualan){
                //     return $penjualan->user->name ?? '';
                // })
                // ->addColumn('aksi', function ($penjualan) {
                //     return '
                //         <div class="btn-group">
                //             <button onclick="showDetail(`'. route('penjualan.show', $penjualan->id_penjualan) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                //             <button onclick="hapus(`'. route('penjualan.destroy', $penjualan->id_penjualan) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                //         </div>
                //     ';
                // })
                // ->rawColumns(['aksi'])
                ->make(true);
        }
        
    }

    public function exportPdf(Request $request)
    {
        $awal = $request->awal;
        $akhir = $request->akhir;

        $pdf = PDF::loadView('laporan.report', [$awal]);
        $pdf->setPaper('a4', 'potrait');
        return $pdf->download('LaporanPenjualan.pdf');
        // return $pdf->stream();
    }
}
