<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Produk;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::all();
        return view('barang_masuk.index', compact('produk'));
    }

    public function data()
    {
        $barang_masuk = BarangMasuk::leftJoin('produk', 'produk.id', 'barang_masuk.produk_id')
            ->select('barang_masuk.*', 'nama_produk')
            // ->orderBy('kode_produk', 'asc')
            ->get();
        return datatables()
            ->of($barang_masuk)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($barang_masuk) {
                return tanggal_indonesia1($barang_masuk->tanggal);
            })
            ->addColumn('aksi', function ($barang_masuk) {
                return '
                <div class="group">
                    <button type="button" onclick="deleteData(`'. route('barang_masuk.destroy', $barang_masuk->id) .'`)" class="btn btn-danger "><i class="fa fa-trash"> Hapus</i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $barang_masuk = new BarangMasuk();
        // $barang_masuk = BarangMasuk::create($request->all());

        // return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['barang_masuk']=BarangMasuk::create([
            'produk_id' => $request['produk_id'],
            'tanggal' => $request['tanggal'],
            'jumlah' => $request['jumlah'],
            
        ]);
        $produk = Produk::findOrFail($request->produk_id);
        $produk->stok += $request->jumlah;
        $produk->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barang_masuk = BarangMasuk::find($id);

        return response()->json($barang_masuk);
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang_masuk = BarangMasuk::find($id);
        $detail    = BarangMasuk::where('id', $id)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->produk_id);
            if ($produk) {
                $produk->stok -= $item->jumlah;
                $produk->update();
            }
            $item->delete();
        }

        $barang_masuk->delete();

        return response(null, 204);

       
    }
}
