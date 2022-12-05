
<div class="modal fade" id="frmProduk" tabindex="-1" role="dialog" aria-labelledby="frmProduk">
  <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pilih Produk</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-produk">
                    <thead>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga Beli</th>
                        <th>Proses</th>
                    </thead>
                    <tbody>
                        @foreach ($produk as $key => $prod)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $prod->kode_produk }}</td>
                                <td>{{ $prod->nama_produk }}</td>
                                <td>{{ $prod->harga_beli }}</td>
                                <td>
                                    <a href="#" onclick="pilihProd('{{$prod->id_produk}}', '{{$prod->kode_produk}}')" class="btn btn-success btn-xs btn-flat">
                                        <i class="fa fa-check-circle"></i> Pilih
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
  </div>
</div>