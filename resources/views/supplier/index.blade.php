@extends('partials.main')

@section('title')
    Daftar Supplier
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Supplier</li>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="add('{{ route('supplier.store') }}')" class="btn btn-success xs btn-flat"><i class="fa fa-plus-circle"></i> <b>Tambah Supplier</b></button>
                </div>
                <div class="box-body table-responsive">
                    <table id="tblSupplier" class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No.</th>
                            <th>Nama Supplier</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th width="10%">Proses</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@includeIf('supplier.form')
@endsection

@push('scripts')
    <script>
        let table;
        $(function(){
            table = $('#tblSupplier').DataTable({
                processing: true,
                autoWidth: true,
                ajax : {
                    url: '{{ route('supplier.data') }}',
                },
                columns: [
                    {data: 'DT_RowIndex', searchable: false, sortable: false},
                    {data: 'nama'},
                    {data: 'telepon'},
                    {data: 'alamat'},
                    {data: 'aksi', searchable: false, sortable: false},
                ]
            });

            $('#frmSupplier').validator().on('submit', function (e) {
                if (! e.preventDefault()){
                    $.ajax({
                        url : $('#frmSupplier form').attr('action'),
                        type: 'post',
                        data: $('#frmSupplier form').serialize(),                        
                    })
                    .done((response) => {
                        $('#frmSupplier').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Data gagal di simpan !');
                        return;
                    })
                }
            });
        })

        function add(url){
            $('#frmSupplier').modal('show');
            $('#frmSupplier .modal-title').text('Tambah Supplier');

            $('#frmSupplier form')[0].reset();
            $('#frmSupplier form').attr('action', url);
            $('#frmSupplier [name=_method]').val('post');
            $('#nama').focus();
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