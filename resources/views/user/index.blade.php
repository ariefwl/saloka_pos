@extends('partials.main')

@section('title')
    Daftar User
@endsection

@section('breadcrumb')
    @parent
    <li class="active">User</li>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="add('{{ route('user.store') }}')" class="btn btn-success xs btn-flat"><i class="fa fa-plus-circle"></i> <b>Tambah User</b></button>
                </div>
                <div class="box-body table-responsive">
                    <table id="tblUser" class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No.</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th width="10%">Proses</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@includeIf('user.form')
@endsection

@push('scripts')
    <script>
        let table;
        $(function(){
            table = $('#tblUser').DataTable({
                processing: true,
                autoWidth: true,
                ajax : {
                    url: '{{ route('user.data') }}',

                },
                columns: [
                    {data: 'DT_RowIndex', searchable: false, sortable: false},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'nama_level'},
                    {data: 'aksi', searchable: false, sortable: false},
                ]
            });

            $('#frmUser').validator().on('submit', function (e) {
                if (! e.preventDefault()){
                    $.ajax({
                        url : $('#frmUser form').attr('action'),
                        type: 'post',
                        data: $('#frmUser form').serialize(),                        
                    })
                    .done((response) => {
                        $('#frmUser').modal('hide');
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
            $('#frmUser').modal('show');
            $('#frmUser .modal-title').text('Tambah User');

            $('#frmUser form')[0].reset();
            $('#frmUser form').attr('action', url);
            $('#frmUser [name=_method]').val('post');
            $('#deskripsi').focus();
            $('#password, #password_confirmation').attr('required', true);
            $('#password, #password_confirmation').attr('readonly', false);
        }

        function edit(url){
            $('#frmUser').modal('show');
            $('#frmUser .modal-title').text('Edit User');

            $('#frmUser form')[0].reset();
            $('#frmUser form').attr('action', url);
            $('#frmUser [name=_method]').val('put');
            $('#nama').focus();
            $('#password, #password_confirmation').attr('required', false);
            $('#password, #password_confirmation').attr('readonly', true);

            $.get(url)
                .done((response) => {
                    $('#nama').val(response.name);
                    $('#email').val(response.email);
                    $('#id_level').val(response.level);
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