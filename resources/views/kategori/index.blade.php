@extends('partials.main')

@section('title')
    Daftar Kategori
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Kategori</li>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="add('{{ route('kategori.store') }}')" class="btn btn-success xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah Kategori</button>
                </div>
                <div class="box-body table-responsive">
                    <table id="tblKat" class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No.</th>
                            <th>Nama Kategori</th>
                            <th width="10%">Proses</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@includeIf('kategori.form')
@endsection

@push('scripts')
    <script>
        let table;
        $(function(){
            table = $('#tblKat').DataTable({
                processing: true,
                autoWidth: true,
                ajax : {
                    url: '{{ route('kategori.data') }}',

                },
                columns: [
                    {data: 'DT_RowIndex', searchable: false, sortable: false},
                    {data: 'nama_kategori'},
                    {data: 'aksi', searchable: false, sortable: false},
                ]
            });

            $('#frmKat').validator().on('submit', function (e) {
                if (! e.preventDefault()){
                    $.ajax({
                        url : $('#frmKat form').attr('action'),
                        type: 'post',
                        data: $('#frmKat form').serialize(),                        
                    })
                    .done((response) => {
                        $('#frmKat form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Data gagal di simpan !');
                        return;
                    })
                }
            })
        })

        function add(url){
            $('#frmKat').modal('show');
            $('#frmKat .modal-title').text('Tambah Kategori');

            $('#frmKat form')[0].reset();
            $('#frmKat form').attr('action', url);
            $('#frmKat [name=_method]').val('post');
            $('#nm_kat').focus();
        }

        function edit(url){
            $('#frmKat').modal('show');
            $('#frmKat .modal-title').text('Edit Kategori');

            $('#frmKat form')[0].reset();
            $('#frmKat form').attr('action', url);
            $('#frmKat [name=_method]').val('put');
            $('#nm_kat').focus();

            $.get(url)
                .done((response) => {
                    $('#nm_kat').val(response.nama_kategori);
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