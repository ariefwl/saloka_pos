@extends('partials.main')

@section('title')
    Laporan Penjualan 
    {{-- {{ tgl_indo($tgl_awal) }} s/d {{ tgl_indo($tgl_akhir) }} --}}
@endsection

@push('css')
  <!-- Datepicker -->
  <link rel="stylesheet" href="{{ asset('template') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">    
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Laporan</li>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="d-flex justify-content-center">
                        <div class="form-inline">
                            <div class="form-group md-3">
                                <label class="col-md-2 col-form-label">Periode :</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control datepicker" autocomplete="off" name="tgl_awal" id="tgl_awal">
                                </div>
                            </div>
                            <div class="form-group md-6">
                                <label class="col-md-2 col-form-label"> s/d </label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control datepicker" autocomplete="off" name="tgl_akhir" id="tgl_akhir">
                                </div>
                            </div>
                                <button id="filter" class="btn btn-success btn-md btn-flat inline">Filter</button>
                                <button id="cetakpdf" class="btn btn-info btn-md btn-flat">Export PDF</button
                                {{-- <a href="{{ route('laporan.export_pdf') }}" target="_blank" class="btn btn-info btn-md btn-flat">Export PDF</a> --}}
                                {{-- <input type="text" class="form-control" placeholder=".col-xs-5"> --}}
                        </div>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table id="tblLapJual" class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No.</th>
                            <th>Tgl. Transaksi</th>
                            <th>Customer</th>
                            <th>Qty</th>
                            <th>SubTotal</th>
                            <th>Diskon</th>
                            <th>Total</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

{{-- @includeIf('laporan.form') --}}
@endsection

@push('scripts')
<!-- Datepicker -->
<script src="{{ asset('template') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function(){
        loadJual();
    })
</script>
<script>

    $('.datepicker').datepicker({
        autoClose: true,
        format: 'yyyy-mm-dd',
    })

    function loadJual(awal, akhir){
       var table = $('#tblLapJual').DataTable({
            responsive: true,
            processing: true,
            autoWidth: true,
            serverSide: false,
            ajax : {
                url: '{{ route('laporan.data') }}',
                data:{
                    awal : awal,
                    akhir : akhir
                }
            },
            paging: false,
            searching: false,
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'nama'},
                {data: 'total_item'},
                {data: 'total_harga'},
                {data: 'diskon'},
                {data: 'bayar'},
            ],
            dom: 'Brt',
            bSort: false,
            bPaginate: false,
        });   
    }

    $(document).on('click', '#filter', function(){
        let awal = $('#tgl_awal').val()
        let akhir = $('#tgl_akhir').val()
        $('#tblLapJual').DataTable().destroy()
        loadJual(awal, akhir)
    })

    $(document).on('click', '#cetakpdf', function(){
        let awal = $('#tgl_awal').val()
        let akhir = $('#tgl_akhir').val()
        $.ajax({
            'type': 'post',                        
            'url' : '{{ route('laporan.export_pdf') }}',
            'data': {
                    awal: awal,
                    akhir: akhir
                },
            'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        })
    })
</script>
@endpush