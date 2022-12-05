@extends('partials.main')

@section('title')
    Daftar Member
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Member</li>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="add('{{ route('member.store') }}')" class="btn btn-success xs btn-flat"><i class="fa fa-plus-circle"></i> <b>Tambah Member</b></button>
                    <button onclick="cetakMember('{{ route('member.cetak_member') }}')" class="btn btn-info xs btn-flat"><i class="fa fa-id-card"></i><b> Cetak</b></button>
                </div>
                <div class="box-body table-responsive">
                    <table id="tblMember" class="table table-striped table-bordered">
                        <thead>
                            <th><input type="checkbox" name="semua" id="semua"/> </th>
                            <th width="5%">No.</th>
                            <th>Kode</th>
                            <th>Nama Member</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th width="10%">Proses</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@includeIf('member.form')
@endsection

@push('scripts')
    <script>
        let table;
        $(function(){
            table = $('#tblMember').DataTable({
                processing: true,
                autoWidth: true,
                ajax : {
                    url: '{{ route('member.data') }}',

                },
                columns: [
                    {data: 'semua', searchable: false, sortable: false},
                    {data: 'DT_RowIndex', searchable: false, sortable: false},
                    {data: 'kode_member'},
                    {data: 'nama'},
                    {data: 'telepon'},
                    {data: 'alamat'},
                    {data: 'aksi', searchable: false, sortable: false},
                ]
            });

            $('#frmMember').validator().on('submit', function (e) {
                if (! e.preventDefault()){
                    $.ajax({
                        url : $('#frmMember form').attr('action'),
                        type: 'post',
                        data: $('#frmMember form').serialize(),                        
                    })
                    .done((response) => {
                        $('#frmMember').modal('hide');
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
            $('#frmMember').modal('show');
            $('#frmMember .modal-title').text('Tambah Member');

            $('#frmMember form')[0].reset();
            $('#frmMember form').attr('action', url);
            $('#frmMember [name=_method]').val('post');
            $('#nama').focus();
        }

        function edit(url){
            $('#frmMember').modal('show');
            $('#frmMember .modal-title').text('Edit Member');

            $('#frmMember form')[0].reset();
            $('#frmMember form').attr('action', url);
            $('#frmMember [name=_method]').val('put');
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

        function cetakMember(url)
        {
            if($('input:checked').length < 1){
                alert('Pilih data yang akan di cetak !');
                return;
            } else {
                $('.form-member')
                    .attr('action', url)
                    .attr('target', '_blank')
                    .submit();
            }
        }
    </script>
@endpush