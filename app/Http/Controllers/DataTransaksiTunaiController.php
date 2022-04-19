<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Settings;
use App\Models\Carts;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;

class DataTransaksiTunaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('data_transaksi_tunai.index');
    }

    public function data()
    {

        $transaksi = Transaksi::with('user')->orderBy('id', 'desc')->where('jenis_pembayaran', 1)->get();

        return datatables()
            ->of($transaksi)
            ->addIndexColumn()
           
            ->addColumn('total_harga', function ($transaksi) {
                return format_uang($transaksi->total_harga);
            })
            ->addColumn('diskon', function ($transaksi) {
                return format_uang($transaksi->diskon);
            })
            ->addColumn('total_bayar', function ($transaksi) {
                return format_uang($transaksi->total_bayar);
            })
            ->addColumn('tanggal', function ($transaksi) {
                return tanggal_indonesia($transaksi->tanggal, false);
            })
            ->editColumn('kasir', function ($transaksi) {
                return $transaksi->user->name ?? '';
            })
            ->addColumn('aksi', function ($transaksi) {
                return '
                <div class="group">
                    <button onclick="showDetail(`'. route('data_transaksi_tunai.show', $transaksi->id) .'`)" class="btn btn-info "><i class="fa fa-eye">  Lihat</i></button>
                    <button onclick="deleteData(`'. route('data_transaksi_tunai.destroy', $transaksi->id) .'`)" class="btn btn-danger"><i class="fa fa-trash">  Hapus</i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'nama_pembeli', 'kasir'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = TransaksiDetail::with('produk')->where('transaksi_id', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('kode_produk', function ($detail) {
                return '<span class="label label-success">'. $detail->produk->kode_produk .'</span>';
            })
            ->addColumn('nama_produk', function ($detail) {
                return $detail->produk->nama_produk;
            })
            ->addColumn('harga_jual', function ($detail) {
                return 'Rp. '. format_uang($detail->produk->harga_jual_utang);
            })
            ->addColumn('diskon', function ($detail) {
                return 'Rp. '. format_uang($detail->produk->diskon);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. '. format_uang((($detail->produk->harga_jual_utang)-($detail->produk->diskon))*($detail->jumlah));
            })
            ->rawColumns(['kode_produk'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);
        $detail    = TransaksiDetail::where('transaksi_id', $transaksi->id)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->produk_id);
            if ($produk) {
                $produk->stok += $item->jumlah;
                $produk->update();
            }

            $item->delete();
        }

        $transaksi->delete();

        return response(null, 204);
    }
}
