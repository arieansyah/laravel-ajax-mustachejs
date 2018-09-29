<div class="modal" id="modal-riwayat" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">

   <form class="form-horizontal" data-toggle="validator" method="post">
   {{ csrf_field() }} {{ method_field('POST') }}

   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
      <h3 class="modal-title"></h3>
   </div>

<div class="modal-body">
   <input type="hidden" id="id" name="id" value="{{$periksa->kode_pasien}}">

   <div class="form-group">
      <label for="riwayat_penyakit" class="col-md-3 control-label">Riwayat Penyakit</label>
      <div class="col-md-9">
        <div class="box">
          <div class="box-body pad">
              <textarea name="riwayat_penyakit" id="riwayat_penyakit" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" autofocus required></textarea>
          </div>
        </div>
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
