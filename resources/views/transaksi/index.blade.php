@extends('layouts.master')

@section('title')
    Transaksi Penjualan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Transaksi Penjualan</li>
@endsection
@push('css')
<style>
    .tampil-bayar {
        font-size: 5em;
        text-align: center;
        height: 100px;
    }

    .tampil-kembali {
        font-size: 2em;
        text-align: center;
        height: 50px;
    }


    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body">
                <div class="col-lg-5">  
                    <form class="form-produk" action="{{ route('cart.store') }}">
                        @csrf
                        {{-- <div class="form-group"> --}}

                            <label for="kode_produk" class="col-lg-2 control-label">Kode Produk</label>
                            {{-- <div class="col-lg-10"> --}}
                                <div class="input-group col-lg-10">
                                    <select class="form-control select2" style="width: 100%;" autofocus="true" name="produk_id" id="produk_id">
                                        <option selected="selected">Masukan Kode Produk</option>
                                        @foreach ($produk as $key => $item)
                                            <option value="{{ $item->id }}">{{ $item->kode_produk }} - {{ $item->nama_produk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            {{-- </div> --}}
                        {{-- </div> --}}

                        {{-- <div class="input-group"> --}}

                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="hidden" min="1"  class="form-control" name="jumlah" id="jumlah" placeholder="Masukkan jumlah..." required>
                                </div>
                            </div>
                        {{-- </div> --}}
                        {{-- <div class="form-group row"> --}}
                            {{-- <label for="jumlah" class="col-lg-2 control-label">Jumlah</label> --}}
                            <div class="col-lg-8">
                               <input type="hidden" class="form-control" name="jumlah" id="jumlah" value="1">
                            </div>
{{--                         </div> --}}

                        <button type="submit" class="btn btn-primary col-lg-12 fa fa-plus-circle">   Tambah</button>
                    </form>
                </div>

                <div class="col-lg-7">  
                    <div class="tampil-bayar bg-primary" id="rupiah">TOTAL Rp. {{ number_format( $itemCarts->sum(function ($item) { return $item->harga_jual_tunai * $item->carts->jumlah;
                        }),0,".",".") }} -,
                    {{--  {{
                        }} --}}
                    </div>
                </div>

                <div class="col-lg-8">
                    <br>
                    <div class="box-body table-responsive">
                       <table class="table table-stiped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Diskon</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($itemCarts as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $item->nama_produk }}</td>
                                        <td>Rp {{ $item->harga_jual_tunai }}</td>
                                        <td>{{ $item->carts->jumlah }}</td>
                                        <td>Rp {{ $item->diskon }}</td>
                                        <td>Rp {{ $item->harga_jual_tunai * $item->carts->jumlah }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#ubahJumlah{{ $loop->iteration }}">Ubah</button>
                                            <form action="{{ route('cart.destroy', $item->carts) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>

                                            <div class="modal fade" id="ubahJumlah{{ $loop->iteration }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ubah Jumlah {{ $item->nama_produk }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form action="{{ route('cart.update', $item->carts) }}" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                
                                                                <div class="form-group">
                                                                    <div class="group">
                                                                        <input type="number" min="1" max="{{-- {{ $item->stock }}" value="{{ $item->cart->quantity }} --}}" class="form-control" name="jumlah" placeholder="Masukkan jumlah..." required>
                                                                        <div class="input-group-append">
                                                                            <br>
                                                                        
                                                                            <button type="submit" class="btn btn-primary float-right">Ubah</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>   
                </div>
                <div class="col-lg-4">
                    <br>
                    <div class="card-body">
                    <form action="{{ route('transaksi.store') }}" method="post" name="form_transaksi" id="form_transaksi">
                        @csrf
                        <input type="hidden" name="user_id" class="form-control" id="user_id" required autofocus value="{{ $user->id }}">
                        <div class="form-group row">
                            <label for="kode_produk" class="col-lg-2 col-lg-offset-1 control-label">Tanggal</label>
                            <div class="col-lg-9    ">
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required value="{{$date}}" >
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama_pembeli" class="col-lg-2 col-lg-offset-1 control-label">Nama Pemberli</label>
                            <div class="col-lg-9    ">
                                <input type="text" name="nama_pembeli" id="nama_pembeli" class="form-control" >
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_harga" class="col-lg-2 col-lg-offset-1 control-label">Total Harga</label>
                            <div class="col-lg-9">
                                <input type="text" name="total_harga" id="total_harga" class="form-control" disabled value="{{ 
                                        $itemCarts->sum(function ($item) {
                                            return $item->harga_jual_tunai * $item->carts->jumlah;
                                        })
                                    }}">
                                <span class="help-block with-errors"></span>
                            </div>
                            <div class="col-lg-9    ">
                                <input type="text" name="total_harga" id="total_harga" class="form-control"  value="{{ 
                                       $itemCarts->sum(function ($item) {
                                            return $item->harga_jual_tunai * $item->carts->jumlah;
                                        })
                                    }}" onkeyup="kurang()" readonly>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kode_produk" class="col-lg-2 col-lg-offset-1 control-label">Diskon</label>
                            <div class="col-lg-9    ">
                                <input type="text" name="diskon" id="diskon" class="form-control"  value="{{ 
                                       $itemCarts->sum(function ($item) {
                                            return $item->diskon * $item->carts->jumlah;
                                        })
                                    }}" onkeyup="kurang()" readonly>
                                <span class="help-block with-errors"></span>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <label for="kode_produk" class="col-lg-2 col-lg-offset-1 control-label">Total Bayar</label>
                            <div class="col-lg-9    ">
                                <input type="text" name="total_bayar" id="total_bayar" class="form-control"  value="{{ 
                                        $itemCarts->sum(function ($item) {
                                            return $item->harga_jual_tunai * $item->carts->jumlah;
                                        }) - $itemCarts->sum(function ($item) {
                                            return $item->diskon * $item->carts->jumlah;
                                        })
                                    }}" onkeyup="kurang()" readonly>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kode_produk" class="col-lg-2 col-lg-offset-1 control-label">Diterima</label>
                            <div class="col-lg-9    ">
                                <input type="text" name="diterima" id="diterima" class="form-control uang" onkeyup="kurang()">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kode_produk" class="col-lg-2 col-lg-offset-1 control-label">Kembali</label>
                            <div class="col-lg-9    ">
                                <input type="text" name="kembali" id="kembali" class="form-control" readonly>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-9    ">
                                <input type="hidden" name="jenis_pembayaran" id="jenis_pembayaran" class="form-control"  value="1" readonly>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-9    ">
                                <input type="hidden" name="status" id="status" class="form-control"  value="1" readonly>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        {{-- <div class="col-lg-12">  
                            <div class="tampil-kembali bg-primary kembali" id="kembali"> 
                            </div>
                            <br>
                        </div> --}}
                        <button type="submit" class="btn btn-success float-right col-lg-12 fa fa-credit-card">  Bayar</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
{{-- @includeIf('transaksi.produk') --}}
<!-- /.row (main row) -->
@endsection

@push('scripts')


<script>
    $(function () {
    //Initialize Select2 Elements
        $('.select2').select2()

    });
    let table;

    $(function () {
        table = $('.table').DataTable();

        $('#modal-produk').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-produk form').attr('action'), $('#modal-produk form').serialize())
                    .done((response) => {
                        $('#modal-produk').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            }
        });

        $('[name=select_all]').on('click', function () {
            $(':checkbox').prop('checked', this.checked);
        });
    });

    var total_bayar = document.getElementById('total_bayar').value;
    var diterima = document.getElementById('diterima').value;
    var kembali = parseInt(diterima) - parseInt(total_bayar);
    var hasil = document.getElementById("hasil-output");
    hasil.innerHTML = parseInt(kembali);

    function kurang() {
      var total_bayar = document.getElementById('total_bayar').value;
      var diterima = document.getElementById('diterima').value;
      var kembali = parseInt(diterima) - parseInt(total_bayar);
      if (!isNaN(kembali)) {
         document.getElementById('kembali').value = kembali;
         document.getElementById('kembali').innerHTML = kembali;
      }
    };


    function tampilProduk() {
        $('#modal-produk').modal('show');
    }

    function hideProduk() {
        $('#modal-produk').modal('hide');
    }

    function pilihProduk(id, kode) {
        // $('#id_produk').val(id);
        $('#kode_produk').val(kode);
        hideProduk();
        tambahProduk();
    }

    var rupiah = document.getElementById("rupiah");
    rupiah.addEventListener("keyup", function(e) {
      // tambahkan 'Rp.' pada saat form di ketik
      // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
      rupiah.value = formatRupiah(this.value, "Rp. ");
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
      }

      rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
      return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    }

</script>
@endpush

