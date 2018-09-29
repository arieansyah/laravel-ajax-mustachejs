<div class="modal" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">

   <form class="form-horizontal"  data-toggle="validator" method="post">
   {{ csrf_field() }} {{ method_field('POST') }}


   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
      <h3 class="modal-title"></h3>
   </div>

<div class="modal-body">

  <input type="hidden" id="id" name="id">

  <div class="alert alert-danger alert-dismissible" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i>
    Email Sudah Digunakan.
  </div>


  <div class="form-group">
    <label for="nama" class="col-md-3 control-label">Nama</label>
    <div class="col-md-6">
      <input id="name" type="text" class="form-control" name="name" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="nama" class="col-md-3 control-label">Email</label>
    <div class="col-md-6">
      <input id="email" type="email" class="form-control" name="email" required>
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="password" class="col-md-3 control-label">Password</label>
    <div class="col-md-6">
      <input id="password" type="password" class="form-control" name="password">
      <span class="help-block with-errors"></span>
    </div>
  </div>

  <div class="form-group">
    <label for="password-confirmation" class="col-md-3 control-label">Konfirmasi Password</label>
    <div class="col-md-6">
      <input id="password-confirmation" type="password" class="form-control" data-match="#password" name="password-confirmation">
      <div id="divCheckPassword"></div>
      <span class="help-block with-errors"></span>
    </div>
  </div>


</div>

   <div class="modal-footer">
      <button type="submit" class="btn btn-primary btn-save"><i class="fa fa-floppy-o"></i> Simpan </button>
      <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
   </div>

   </form>

         </div>
      </div>
   </div>
