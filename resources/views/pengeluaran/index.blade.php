@extends('layouts.master')

@section('title')
    Daftar Pengeluaran
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Pengeluaran</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{ route('pengeluaran.store') }}')" class="btn btn-success "><i class="fa fa-plus-circle"></i> Tambah Pengeluaran</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Deskripsi Pengeluaran</th>
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th width="20%"><i class="fa fa-cog"></i></th>

                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('pengeluaran.form')
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
                url: '{{ route('pengeluaran.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'deskripsi'},
                {data: 'tanggal'},
                {data: 'nominal'},
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
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Pengeluaran');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=deskripsi]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Pengeluaran');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=deskripsi]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=deskripsi]').val(response.deskripsi);
                $('#modal-form [name=tanggal]').val(response.tanggal);
                $('#modal-form [name=nominal]').val(response.nominal);
                $('#modal-form [name=merek]').val(response.merek);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }


    function deleteData(url) {
        swal({
            type:"warning",
            title:"Apakah anda yakin ?",
            text:"Akan Menghapus Data Kategori Produk",
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