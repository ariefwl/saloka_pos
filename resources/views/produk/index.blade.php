@extends('partials.main')

@section('title')
    Daftar Produk
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Produk</li>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="btn-group">
                        <button onclick="add('{{ route('produk.store') }}')" class="btn btn-success xs btn-flat"><i class="fa fa-plus-circle"></i>   <b>Tambah Produk</b></button>
                        <button onclick="hapusterpilih('{{ route('produk.hapus_terpilih') }}')" class="btn btn-danger xs btn-flat"><i class="fa fa-trash"></i>  <b>Hapus Produk</b></button>
                        <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-warning xs btn-flat"><i class="fa fa-barcode"></i>  <b>Cetak Barcode</b></button>
                    </div>
                </div>
                <div class="box-body table-responsive">
                        <table id="tblProd" class="table table-striped table-bordered">
                            <thead>
                                <th><input type="checkbox" name="semua" id="semua"/> </th>
                                <th width="5%">No.</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Merk</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Diskon</th>
                                <th>Stock</th>
                                <th width="10%">Proses</th>
                            </thead>
                        </table>
                </div>
            </div>
        </div>
    </div>

@includeIf('produk.form')
@endsection

@push('scripts')
    <script>
        let table;
        $(function(){
            table = $('#tblProd').DataTable({
                processing: true,
                autoWidth: true,
                ajax : {
                    url: '{{ route('produk.data') }}',

                },
                columns: [
                    {data: 'semua', sortable: false},
                    {data: 'DT_RowIndex', searchable: false, sortable: false},
                    {data: 'kode_produk'},
                    {data: 'nama_produk'},
                    {data: 'nama_kategori'},
                    {data: 'merk'},
                    {data: 'harga_beli'},
                    {data: 'harga_jual'},
                    {data: 'diskon'},
                    {data: 'stok'},
                    {data: 'aksi', searchable: false, sortable: false},
                ]
            });

            $('#frmProd').validator().on('submit', function (e) {
                if (! e.preventDefault()){
                    $.ajax({
                        url : $('#frmProd form').attr('action'),
                        type: 'post',
                        data: $('#frmProd form').serialize(),                        
                    })
                    .done((response) => {
                        $('#frmProd form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Data gagal di simpan !');
                        return;
                    })
                }
            })

            $('#semua').on('click', function(){
                $(':checkbox').prop('checked', this.checked);
            })
        })

        function add(url){
            $('#frmProd').modal('show');
            $('#frmProd .modal-title').text('Tambah Produk');

            $('#frmProd form')[0].reset();
            $('#frmProd form').attr('action', url);
            $('#frmProd [name=_method]').val('post');
            $('#nama_produk').focus();
        }

        function edit(url){
            $('#frmProd').modal('show');
            $('#frmProd .modal-title').text('Edit Produk');

            $('#frmProd form')[0].reset();
            $('#frmProd form').attr('action', url);
            $('#frmProd [name=_method]').val('put');
            $('#nama_produk').focus();

            $.get(url)
                .done((response) => {
                    $('#nama_produk').val(response.nama_produk);
                    $('#id_kategori').val(response.id_kategori);
                    $('#merk').val(response.merk);
                    $('#harga_beli').val(response.harga_beli);
                    $('#harga_jual').val(response.harga_jual);
                    $('#diskon').val(response.diskon);
                    $('#stok').val(response.stok);
                })
                .fail((errors) => {
                    alert('Tidak ada data !');
                })
        }

        function hapus(url){
            if (confirm('Yakin akan menghapus data ? ')) {
                $.post(url,{
                    '_token' : $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Data tidak berhasil di hapus !');
                    return;
                })
            }
        }

        function hapusterpilih(url)
        {
            if($('input:checked').length > 1){
                if(confirm('Yakin akan menghapus data ?')){
                    $.post(url, $('.form-produk').serialize())
                        .done((response) => {
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            alert('Data tidak bisa di hapus !');
                            return;
                        })
                }
            } else {
                alert('Pilih data yang akan di hapus !');
                return;
            }
        }

        function cetakBarcode(url)
        {
            if($('input:checked').length < 1){
                alert('Pilih data yang akan di cetak !');
                return;
            } else if($('input:checked').length < 2) {
                alert('Pilih minimal 3 data yang akan di cetak !');
                return; 
            } else {
                $('.form-produk')
                    .attr('action', url)
                    .attr('target', '_blank')
                    .submit();
            }
        }
    </script>
@endpush