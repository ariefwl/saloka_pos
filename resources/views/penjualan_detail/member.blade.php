
<div class="modal fade" id="frmMember" tabindex="-1" role="dialog" aria-labelledby="frmMember">
  <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pilih Member</h4>
            </div>
            <div class="modal-body">
                <table id="tblMember" class="table table-striped table-bordered">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Proses</th>
                    </thead>
                    <tbody>
                        @foreach ($member as $key => $mmbr)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $mmbr->nama }}</td>
                                <td>{{ $mmbr->alamat }}</td>
                                <td>{{ $mmbr->telepon }}</td>
                                <td>
                                    <a href="#" onclick="pilihMember('{{$mmbr->id_member}}', '{{$mmbr->kode_member}}')" class="btn btn-success btn-xs btn-flat">
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