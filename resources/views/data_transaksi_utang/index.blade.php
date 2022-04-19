@extends('layouts.master')

@section('title')
    Daftar Transaksi Utang
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Transaksi Utang</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                {{-- <button onclick="addForm('{{ route('pengeluaran.store') }}')" class="btn btn-success "><i class="fa fa-plus-circle"></i> Tambah Pengeluaran</button> --}}
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered table-transaksi">
                    <thead>
                        <th width="5%">No</th>
                        <th>Nama Pembeli</th>
                        <th>Tanggal</th>
                        <th>Nama Kasir</th>
                        <th>Total Harga</th>
                        <th>Diskon</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th width="20%"><i class="fa fa-cog"></i></th>

                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('data_transaksi_utang.show')
@includeIf('data_transaksi_utang.form')
@endsection

@push('scripts')
<script>
    let table, table1;

    $(function () {
        table = $('.table-transaksi').DataTable({
            responsive: true,
            processing: false,
            serverSide: true,
            autoWidth: false,
            
            ajax: {
                url: '{{ route('data_transaksi_utang.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama_pembeli'},
                {data: 'tanggal'},
                {data: 'kasir'},
                {data: 'total_harga'},
                {data: 'diskon'},
                {data: 'total_bayar'},
                {data: 'status'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });
        table1 = $('.table-detail').DataTable({
            processing: false,
            bSort: false,
            dom: 'Brt',
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'diskon'},
                {data: 'jumlah'},
                {data: 'subtotal'},
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
        $('#modal-form .modal-title').text('Edit Transaksi Utang');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_pembeli]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_pembeli]').val(response.nama_pembeli);
                $('#modal-form [name=tanggal]').val(response.tanggal);
                $('#modal-form [name=status]').val(response.status);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function showDetail(url) {
        $('#modal-detail').modal('show');

        table1.ajax.url(url);
        table1.ajax.reload();
    }

    // function addForm(url) {
    //     $('#modal-form').modal('show');
    //     $('#modal-form .modal-title').text('Tambah Pengeluaran');

    //     $('#modal-form form')[0].reset();
    //     $('#modal-form form').attr('action', url);
    //     $('#modal-form [name=_method]').val('post');
    //     $('#modal-form [name=deskripsi]').focus();
    // }

    


    function deleteData(url) {
        swal({
            type:"warning",
            title:"Apakah anda yakin ?",
            text:"Akan Menghapus Data Transaksi Utang",
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
</script>
@endpush