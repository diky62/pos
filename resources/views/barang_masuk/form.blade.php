<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="produk_id" class="col-lg-2 col-lg-offset-1 control-label">Nama Barang</label>
                        <div class="col-lg-6">
                            <select name="produk_id" id="produk_id" class="form-control" required>
                                <option value="">Pilih Barang...</option>
                                @foreach($produk as $produk)
                                    <option value="{{ $produk->id }}">{{ $produk->nama_produk }}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tanggal" class="col-lg-2 col-lg-offset-1 control-label">Tanggal</label>
                        <div class="col-lg-6">
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jumlah" class="col-lg-2 col-lg-offset-1 control-label">Jumlah</label>
                        <div class="col-lg-6">
                            <input type="number" name="jumlah" id="jumlah" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>