@extends('layouts.master')

@section('title')
    Daftar Produk
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Produk</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="group">
                    <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success "><i class="fa fa-plus-circle"></i> Tambah Produk</button>
                    <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                    <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-info "><i class="fa fa-barcode"></i> Cetak Barcode</button>
                </div>
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-produk">
                    @csrf
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">
                                <input type="checkbox" name="select_all" id="select_all">
                            </th>
                            <th width="5%">No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Merk</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual Tunai</th>
                            <th>Harga Jual Utang</th>
                            <th>Diskon</th>
                            <th>Stok</th>
                            <th><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

@includeIf('produk.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: false,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('produk.data') }}',
            },
            columns: [
                {data: 'select_all', searchable: false, sortable: false},
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'nama_kategori'},
                {data: 'merek'},
                {data: 'harga_beli'},
                {data: 'harga_jual_tunai'},
                {data: 'harga_jual_utang'},
                {data: 'diskon'},
                {data: 'stok'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
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

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_produk]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_produk]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=kode_produk]').val(response.kode_produk);
                $('#modal-form [name=nama_produk]').val(response.nama_produk);
                $('#modal-form [name=kategori_id]').val(response.kategori_id);
                $('#modal-form [name=merek]').val(response.merek);
                $('#modal-form [name=harga_beli]').val(response.harga_beli);
                $('#modal-form [name=harga_jual_tunai]').val(response.harga_jual_tunai);
                $('#modal-form [name=harga_jual_utang]').val(response.harga_jual_utang);
                $('#modal-form [name=diskon]').val(response.diskon);
                $('#modal-form [name=stok]').val(response.stok);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    // function deleteData(url) {
    //     if (confirm('Yakin ingin menghapus data terpilih?')) {
    //         $.post(url, {
    //                 '_token': $('[name=csrf-token]').attr('content'),
    //                 '_method': 'delete'
    //             })
    //             .done((response) => {
    //                 table.ajax.reload();
    //             })
    //             .fail((errors) => {
    //                 alert('Tidak dapat menghapus data');
    //                 return;
    //             });
    //     }
    // }

    function deleteData(url) {
        swal({
            type:"warning",
            title:"Apakah anda yakin ?",
            text:"Akan Menghapus Data Produk",
            showCancelButton:true,
            cancelButtonColor:"#d33",
            confirmButtonText:"Ya",
            confirmButtonColor:"#3085d6"
        }).then(result=>{
            if(result.value){
                let access = {
                 
                    _method:"delete",
                    _token:"{{ csrf_token() }}"
                }

                $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done(res=>{
                    table.ajax.reload();
                    swal({
                        title:"Ok!",
                        text:"Data berhasil dihaps!",
                        type:"success"
                    })
                    .then(result=>{
                        table.ajax.reload();
                    });
                })
                .fail(err=>{
                     alert('Tidak dapat menghapus data');
                    return;
                });
            }
        });
    }

    function deleteSelected(url) {
        swal({
            type:"warning",
            title:"Apakah anda yakin ?",
            text:"Akan Menghapus Data Produk Terpilih",
            showCancelButton:true,
            cancelButtonColor:"#d33",
            confirmButtonText:"Ya",
            confirmButtonColor:"#3085d6"
        }).then(result=>{
            if(result.value){
                let access = {
                 
                    _method:"delete",
                    _token:"{{ csrf_token() }}"
                }

                $.post(url, $('.form-produk').serialize())
                .done(res=>{
                    table.ajax.reload();
                    swal({
                        title:"Ok!",
                        text:"Data berhasil dihaps!",
                        type:"success"
                    })
                    .then(result=>{
                        table.ajax.reload();
                    });
                })
                .fail(err=>{
                     alert('Tidak dapat menghapus data');
                    return;
                });
            }
        });
    }

    // function deleteSelected(url) {
    //     if ($('input:checked').length > 1) {
    //         if (confirm('Yakin ingin menghapus data terpilih?')) {
    //             $.post(url, $('.form-produk').serialize())
    //                 .done((response) => {
    //                     table.ajax.reload();
    //                 })
    //                 .fail((errors) => {
    //                     alert('Tidak dapat menghapus data');
    //                     return;
    //                 });
    //         }
    //     } else {
    //         alert('Pilih data yang akan dihapus');
    //         return;
    //     }
    // }

    function cetakBarcode(url) {
        if ($('input:checked').length < 1) {
            alert('Pilih data yang akan dicetak');
            return;
        } else if ($('input:checked').length < 3) {
            alert('Pilih minimal 3 data untuk dicetak');
            return;
        } else {
            $('.form-produk')
                .attr('target', '_blank')
                .attr('action', url)
                .submit();
        }
    }
</script>
@endpush