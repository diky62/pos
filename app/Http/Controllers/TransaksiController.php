<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Settings;
use App\Models\Carts;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $date = Carbon\Carbon::now();
        $date = date('Y-m-d');
        $produk = Produk::where('stok', '>', 0)->get()->sortBy('name');
        $itemCarts = Produk::has('carts')->get()->sortByDesc('carts.created_at');
        $user = auth()->user();
        // $total = sum(function ($item) { return $item->harga_jual_tunai * $item->carts->jumlah;
        // dd($date);
        return view('transaksi.index', compact(['produk', 'itemCarts', 'user', 'date']));
    }

    public function data()
    {
        $produk = Produk::get();
        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="label label-success">'. $produk->kode_produk .'</span>';
            })
            ->addColumn('harga_jual_tunai', function ($produk) {
                return format_uang($produk->harga_jual_tunai);
            })
            ->addColumn('harga_jual_utang', function ($produk) {
                return format_uang($produk->harga_jual_utang);
            })
            ->addColumn('stok', function ($produk) {
                return format_uang($produk->stok);
            })
            ->addColumn('aksi', function ($produk) {
                return '
                <div class="group">
                   <button type="button" onclick="pilihProduk('. $produk->kode_produk .')" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-pencil"></i> Pilih</button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all'])
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
        
        $transaksi = new Transaksi;
         // $transaksi->fill($request["transaksi"]);
        $transaksi->fill($request->all());
        $transaksi->save();
        $transaksi_detail = new TransaksiDetail;
        $carts = Carts::get();
        $keranjang = $carts;
        // $transaksi_detail -> fill([$keranjang]);
        // $transaksi_detail->save([]);
        // $transaksi_id = $carts->transaksi_id;
        // dd($keranjang);
        foreach($keranjang as $a => $cart){
            $transaksi_detail = new TransaksiDetail;
            // $transaksi_detail->transaksi_id = $transaksi->id;
            // $transaksi_detail->fill($cart);
            // $transaksi_detail->save();
            TransaksiDetail::create( [
                        'transaksi_id' => $transaksi->id,
                        'produk_id' => $cart->produk_id,
                        'jumlah' => $cart->jumlah,
                        // 'subtotal' => $cart->item->price * $cart->quantity
                    ]);

            $produk = Produk::findOrFail($cart->produk_id);
            $produk->stok -= $cart->jumlah;
            $produk->save();
            // $transaksi_detail->save(["$cart"]);
            // 'transaksi_id' => $transaksi->id,
            //     'produk_id' => $cart->produk_id,
            //     'jumlah' => $cart->jumlah,
            // ]);
            
            $cart->delete();
            // dd($transaksi_detail);
        }
        
        
        return redirect()->route('transaksi.selesai');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    public function loadForm($diskon = 0, $total = 0, $diterima = 0)
    {
        $bayar   = $total - ($diskon / 100 * $total);
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;
        $data    = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali). ' Rupiah'),
        ];

        return response()->json($data);
    }

    public function selesai()
    {
        $setting = Settings::first();

        return view('transaksi.selesai', compact('setting'));
    }

    public function notaKecil()
    {
        $setting = Settings::first();
        $transaksi = Transaksi::latest('id')->first();
        $transaksi_id = $transaksi->id;
        // dd($transaksi_id);
        if (! $transaksi) {
            abort(404);
        }
        $detail = TransaksiDetail::with('produk')
            ->where('transaksi_id', $transaksi_id)
            ->get();
        
        return view('transaksi.nota_kecil', compact('setting', 'transaksi', 'detail'));
    }

    public function notaBesar()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('id_penjualan'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', session('id_penjualan'))
            ->get();

        $pdf = PDF::loadView('penjualan.nota_besar', compact('setting', 'penjualan', 'detail'));
        $pdf->setPaper(0,0,609,440, 'potrait');
        return $pdf->stream('Transaksi-'. date('Y-m-d-his') .'.pdf');
    }
}
