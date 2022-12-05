@extends('partials.main')

@section('title')
    Daftar Penjualan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Penjualan</li>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table id="tblPenjualan" class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No.</th>
                            <th>Tanggal Transaksi</th>
                            <th>Kode Member</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Total Bayar</th>
                            <th>Kasir</th>
                            <th width="10%">Proses</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@includeIf('penjualan.detail')
@endsection

@push('scripts')
    <script>
        let table1, table2;
        $(function(){
            table1 = $('#tblPenjualan').DataTable({
                processing: true,
                autoWidth: true,
                ajax : {
                    url: '{{ route('penjualan.data') }}',
                },
                columns: [
                    {data: 'DT_RowIndex', searchable: false, sortable: false},
                    {data: 'tanggal'},
                    {data: 'kode_member'},
                    {data: 'total_item'},
                    {data: 'total_harga'},
                    {data: 'diskon'},
                    {data: 'bayar'},
                    {data: 'kasir'},
                    {data: 'aksi', searchable: false, sortable: false},
                ]
            });

            table2 = $('#tblDetPenj').DataTable({
                processing: true,
                bSort: false,
                dom: 'Brt',
                columns: [
                    {data: 'DT_RowIndex', searchable: false, sortable: false},
                    {data: 'kode_produk'},
                    {data: 'nama_produk'},
                    {data: 'harga_jual'},
                    {data: 'jumlah'},
                    {data: 'subtotal'},
                ]
            })
        })

        function showDetail(url) {
            $('#detPenj').modal('show');

            table2.ajax.url(url);
            table2.ajax.reload();
        }

        {{-- function edit(url){
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
        } --}}

        function hapus(url){
            if (confirm('Yakin akan menghapus data ? ')) {
                $.post(url,{
                    '_token' : $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table1.ajax.reload();
                })
                .fail((errors) => {
                    alert('Data tidak berhasil di hapus !');
                    return;
                })
            }

        }
    </script>
@endpush