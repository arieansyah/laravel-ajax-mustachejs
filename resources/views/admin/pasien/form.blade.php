<div class="modal" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">

   <form class="form-horizontal" data-toggle="validator" method="post">
   {{ csrf_field() }} {{ method_field('POST') }}

   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
      <h3 class="modal-title"></h3>
   </div>

<div class="modal-body">
   <input type="hidden" id="id" name="id">
   <div class="form-group">
      <label for="nama" class="col-md-3 control-label">Nama Pasien</label>
      <div class="col-md-6">
         <input id="nama" type="text" class="form-control" name="nama" autofocus required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="nama" class="col-md-3 control-label">Tempat</label>
      <div class="col-md-3">
         <input id="tempat" type="text" class="form-control" name="tempat" autofocus required>
       </div>
       <label for="nama" class="col-md-2 control-label">Tanggal Lahir</label>
       <div class="col-md-3">
         <div class="input-group">
           <div class="input-group-addon">
             <i class="fa fa-calendar"></i>
           </div>
           <input id="date" type="text" class="form-control" name="date" autofocus required>
         </div>
       </div>
      <span class="help-block with-errors"></span>
   </div>

   <div class="form-group">
      <label for="jenis_kelamin" class="col-md-3 control-label">Jenis Kelamin</label>
      <div class="col-md-2">
        <input type="radio" name="jenis_kelamin" id="jenis_kelamin" value="L"> Laki - Laki<br>
      </div>
      <div class="col-md-2">
        <input type="radio" name="jenis_kelamin" id="jenis_kelamin" value="P"> Perempuan<br>
      </div>
         <span class="help-block with-errors"></span>
   </div>

   <div class="form-group">
      <label for="alamat" class="col-md-3 control-label">Alamat</label>
      <div class="col-md-9">
        <div class="box">
          <div class="box-body pad">
              <textarea name="alamat" id="alamat" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" autofocus required></textarea>
          </div>
        </div>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="desa" class="col-md-3 control-label">Desa</label>
      <div class="col-md-6">
         <input id="desa" type="text" class="form-control" name="desa" autofocus required>
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
