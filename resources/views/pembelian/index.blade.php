@extends('partials.main')

@section('title')
    Daftar Pembelian
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Pembelian</li>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="add()" class="btn btn-success xs btn-flat"><i class="fa fa-plus-circle"></i> <b>Tambah Transaksi</b></button>
                </div>
                <div class="box-body table-responsive">
                    <table id="tblPembelian" class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No.</th>
                            <th>Tanggal Transaksi</th>
                            <th>Nama Supplier</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Total Bayar</th>
                            <th width="10%">Proses</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@includeIf('pembelian.supplier')
@endsection

@push('scripts')
    <script>
        let table;
        $(function(){
            table = $('#tblPembelian').DataTable({
                processing: true,
                autoWidth: true,
                ajax : {
                    url: '{{ route('pembelian.data') }}',
                },
                columns: [
                    {data: 'DT_RowIndex', searchable: false, sortable: false},
                    {data: 'tanggal'},
                    {data: 'supplier'},
                    {data: 'total_item'},
                    {data: 'total_harga'},
                    {data: 'diskon'},
                    {data: 'bayar'},
                    {data: 'aksi', searchable: false, sortable: false},
                ]
            });
        })

        function add(){
            $('#frmSupplier').modal('show');
        }

        function edit(url){
            $('#frmSupplier').modal('show');
            $('#frmSupplier .modal-title').text('Edit Supplier');

            $('#frmSupplier form')[0].reset();
            $('#frmSupplier form').attr('action', url);
            $('#frmSupplier [name=_method]').val('put');
            $('#nama').focus();

            $.get(url)
                .done((response) => {
                    $('#nama').val(response.nama);
                    $('#alamat').val(response.alamat);
                    $('#telepon').val(response.telepon);
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
    </script>
@endpush