@extends('partials.main')

@section('title')
    Daftar Pengeluaran
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Pengeluaran</li>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="add('{{ route('pengeluaran.store') }}')" class="btn btn-success xs btn-flat"><i class="fa fa-plus-circle"></i> <b>Tambah Pengeluaran</b></button>
                </div>
                <div class="box-body table-responsive">
                    <table id="tblPengeluaran" class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No.</th>
                            <th>Tanggal Transaksi</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                            <th width="10%">Proses</th>
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
        $(function(){
            table = $('#tblPengeluaran').DataTable({
                processing: true,
                autoWidth: true,
                ajax : {
                    url: '{{ route('pengeluaran.data') }}',

                },
                columns: [
                    {data: 'DT_RowIndex', searchable: false, sortable: false},
                    {data: 'created_at'},
                    {data: 'deskripsi'},
                    {data: 'nominal'},
                    {data: 'aksi', searchable: false, sortable: false},
                ]
            });

            $('#frmPengeluaran').validator().on('submit', function (e) {
                if (! e.preventDefault()){
                    $.ajax({
                        url : $('#frmPengeluaran form').attr('action'),
                        type: 'post',
                        data: $('#frmPengeluaran form').serialize(),                        
                    })
                    .done((response) => {
                        $('#frmPengeluaran').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Data gagal di simpan !');
                        return;
                    })
                }
            });

            $('#semua').on('click', function(){
                $(':checkbox').prop('checked', this.checked);
            });
        })

        function add(url){
            $('#frmPengeluaran').modal('show');
            $('#frmPengeluaran .modal-title').text('Tambah Pengeluaran');

            $('#frmPengeluaran form')[0].reset();
            $('#frmPengeluaran form').attr('action', url);
            $('#frmPengeluaran [name=_method]').val('post');
            $('#deskripsi').focus();
        }

        function edit(url){
            $('#frmPengeluaran').modal('show');
            $('#frmPengeluaran .modal-title').text('Edit Pengeluaran');

            $('#frmPengeluaran form')[0].reset();
            $('#frmPengeluaran form').attr('action', url);
            $('#frmPengeluaran [name=_method]').val('put');
            $('#deskripsi').focus();

            $.get(url)
                .done((response) => {
                    $('#deskripsi').val(response.deskripsi);
                    $('#nominal').val(response.nominal);
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