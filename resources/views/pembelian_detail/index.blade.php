@extends('partials.main')

@section('title')
    Transaksi Pembelian 
@endsection

@push('css')
    <style>
        .tampil-bayar{
            font-size: 5em;
            text-align: center;
            height: 100px;
        }
        .tampil-terbilang {
            padding: 10px;
            background: #f0f0f0;
        }
        .table-pembelian tbody tr:last-child{
            display: none;
        }
        @media(max-width: 768px){
            .jml-byr{
                font-size: 3em;
                height: 70px;
                padding-top: 5px;
            }
        }
    </style>
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Transaksi Pembelian</li>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <table>
                        <tr>
                            <td>Supplier</td>
                            <td>: {{ $supplier->nama }}</td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td>: {{ $supplier->telepon }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: {{ $supplier->alamat }}</td>
                        </tr>
                    </table>
                </div>
                <div class="box-body">
                        
                    <form class="form-produk">
                        @csrf
                        <div class="form-group row">
                            <label for="kode_produk" class="col-lg-2">Kode Produk</label>
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <input type="hidden" name="id_produk" id="id_produk" />
                                    <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{$id_pembelian}}" />
                                    <input type="text" class="form-control" name="kode_produk" id="kode_produk">
                                    <span class="input-group-btn">
                                        <button onclick="showProd()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <table class="table table-striped table-bordered table-pembelian">
                        <thead>
                            <th width="5%">No.</th>
                            <th>Kode Produk</th>
                            <th width="40%">Nama Produk</th>
                            <th width="20%">Harga</th>
                            <th width="10%">Jumlah</th>
                            <th width="20%">Subtotal</th>
                            <th width="10%">Proses</th>
                        </thead>
                    </table>
                    
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="tampil-bayar bg-primary"></div>
                            <div class="tampil-terbilang"><i></i></div>
                        </div>
                        <div class="col-lg-4">
                            <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="post">
                                @csrf
                                <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}" />
                                <input type="hidden" name="total" id="total" />
                                <input type="hidden" name="total_item" id="total_item" />
                                <input type="hidden" name="bayar" id="bayar" />
                                <div class="form-group row">
                                    <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="totalrp" class="form-control" readonly/>                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                                    <div class="col-lg-8">
                                        <input type="number" name="diskon" id="diskon" class="form-control" value="0"/>                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bayarrp" class="col-lg-2 control-label">Bayar</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="bayarrp" class="form-control" readonly/>                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan">SIMPAN</button>
                </div>
            </div>
        </div>
    </div>

@includeIf('pembelian_detail.produk')
@endsection

@push('scripts')
    <script>
        let tabel1, tabel2;
        $(function(){
            tabel1 = $('.table-pembelian').DataTable({
                processing: true,
                autoWidth: true,
                ajax : {
                    url: '{{ route('pembelian_detail.data', $id_pembelian) }}',
                },
                columns: [
                    {data: 'DT_RowIndex', searchable: false, sortable: false},
                    {data: 'kode_produk'},
                    {data: 'nama_produk'},
                    {data: 'harga_beli'},
                    {data: 'jumlah'},
                    {data: 'subtotal'},
                    {data: 'aksi', searchable: false, sortable: false},
                ],
                dom: 'Brt',
                bSort: false,
            })
            .on('draw.dt', function(){
                loadForm($('#diskon').val());
            });

            tabel2 = $('.table-produk').DataTable();

            $(document).on('input', '.qty', function(){
                let id = $(this).data('id');
                let jumlah = parseInt($(this).val());
                
                if (jumlah > 1000){
                    $(this).val(1000);
                    alert('Jumlah tidak boleh > 1000');
                    return;
                }
                if (jumlah < 1){
                    $(this).val(1);
                    alert('Jumlah tidak boleh < 1');
                    return;
                }

                $.post(`{{ url('/pembelian_detail/') }}/${id}`,{
                            '_token' : $('[name=csrf-token]').attr('content'),
                            '_method': 'put',
                            'jumlah' : jumlah
                        })
                        .done(response => {
                            $(this).on('mouseout', function(){
                                tabel1.ajax.reload(() => loadForm($('#diskon').val()));
                            });
                        })
                        .fail(errors => {
                            alert('error');
                            return;
                        })
            });

            $(document).on('input', '#diskon', function(){
                if($(this).val() == ""){
                    $(this).val(0).select();
                }
                loadForm($(this).val());
            })

            $('.btn-simpan').on('click', function(){
                $('.form-pembelian').submit();
            })
        })

        function showProd(){
            $('#frmProduk').modal('show');
        }

        function pilihProd(id, kode){
            $('#id_produk').val(id);
            $('#kode_produk').val(kode);
            $('#frmProduk').modal('hide');
            tambahProd();
        }

        function tambahProd(){
            $.post('{{ route('pembelian_detail.store') }}', $('.form-produk').serialize())
                    .done(response => {
                        $('#kode_produk').focus();
                        tabel1.ajax.reload(() => loadForm($('#diskon').val()));
                    })
                    .fail(response => {
                        alert('Data gagal di simpan !');
                    })
        }

        function hapus(url){
            if (confirm('Yakin akan menghapus data ? ')) {
                $.post(url,{
                    '_token' : $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    tabel1.ajax.reload(() => loadForm($('#diskon').val()));
                })
                .fail((errors) => {
                    alert('Data tidak berhasil di hapus !');
                    return;
                })
            }
        }

        function loadForm(diskon = 0){
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            $.get(`{{ url('/pembelian_detail/loadform') }}/${diskon}/${$('.total').text()}`)
                .done(response => {
                    $('#totalrp').val('Rp.'+ response.totalrp);
                    $('#bayarrp').val('Rp.'+ response.bayarrp);
                    $('#bayar').val(response.bayar);
                    $('.tampil-bayar').text('Rp.'+ response.bayarrp);
                    $('.tampil-terbilang').text('Rp.'+ response.terbilang);
                })
                .fail(errors => {
                    alert('Data tidak di temukan !');
                    return;
                })
        }
    </script>
@endpush