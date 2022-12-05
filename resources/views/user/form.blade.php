
<div class="modal fade" id="frmUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <form class="form-horizontal" method="post" action="">
        @csrf
        @method('post')
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group row"> 
                    <label for="nama" class="col-md-3 col-md-offset-1 control-label">Nama User</label>
                    <div class="col-md-6">
                        <input type="text" name="nama" id="nama" class="form-control" required autofocus/>
                        <span class="help-block with-errors"></span>                
                    </div>
                </div>
                <div class="form-group row"> 
                    <label for="email" class="col-md-3 col-md-offset-1 control-label">Email</label>
                    <div class="col-md-6">
                        <input type="email" name="email" id="email" class="form-control" required/>
                        <span class="help-block with-errors"></span>                
                    </div>
                </div>
                <div class="form-group row"> 
                    <label for="id_level" class="col-md-3 col-md-offset-1 control-label">Level</label>
                    <div class="col-md-6">
                        <select id="id_level" name="id_level" class="form-control" required>
                            <option value=""> -- Pilih Level --</option>
                            @foreach ($level as $key => $lvl )
                                <option value="{{ $key }}">{{ $lvl }}</option>
                            @endforeach
                        </select>
                        <span class="help-block with-errors"></span>                
                    </div>
                </div>
                <div class="form-group row"> 
                    <label for="password" class="col-md-3 col-md-offset-1 control-label">Password</label>
                    <div class="col-md-6">
                        <input type="password" name="password" id="password" class="form-control" required minlength="6"/>
                        <span class="help-block with-errors"></span>                
                    </div>
                </div>
                <div class="form-group row"> 
                    <label for="password_confirmation" class="col-md-3 col-md-offset-1 control-label">Konfirmasi Password</label>
                    <div class="col-md-6">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required data-match="#password"/>
                        <span class="help-block with-errors"></span>                
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
  </div>
</div>