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
    <input type="hidden" id="idea" name="idea" >
   <input type="hidden" id="id" name="id" value="{{$periksa->kode_pasien}}">
   <div class="form-group">
      <label for="date" class="col-md-3 control-label">Tanggal Periksa</label>
      <div class="col-md-6">
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input id="date" type="text" class="form-control" name="date" autofocus required>
        </div>
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="diagnosa" class="col-md-3 control-label">Diagnosa</label>
      <div class="col-md-9">
        <div class="box">
          <div class="box-body pad">
              <textarea name="diagnosa" id="diagnosa" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" autofocus required></textarea>
          </div>
        </div>
         <span class="help-block with-errors"></span>
      </div>
   </div>
   <div id="render"></div>
   <script type="x-tmpl-mustache" id="add_item">
     <div class="form-group">
        <label for="penyakit" class="col-md-3 control-label">Penyakit</label>
        <div class="col-md-6">
          <div class="input-group">
            <input id="penyakit" type="text" class="form-control" name="penyakit">
            <div class="input-group-addon">
              <button type="button" name="button" id="AddItem"><i class="fa fa-plus-circle"></i></button>
            </div>
          </div>
           <span class="help-block with-errors"></span>
        </div>
     </div>
     {% #item %}
     <div class="form-group" id="data_{% _id %}">
        <label for="penyakit" class="col-md-3 control-label"> - </label>
        <div class="col-md-6">
          <div class="input-group">
            <input type="text" class="form-control" value="{% penyakit %}" disabled>
            <div class="input-group-addon">
              <button type="button" id="edit_{% _id %}" class="btn-edit-item" data-id="{% _id %}"><i class="fa fa-edit"></i></button>
              <button type="button" id="delete_{% _id %}" class="btn-delete-item" data-id="{% _id %}"><i class="fa fa-trash"></i></button>
            </div>
          </div>
        </div>
     </div>
     <div class="form hidden" id="form_{% _id %}">
       <div class="form-group" id="data_{% _id %}">
       <label for="penyakit" class="col-md-3 control-label"> - </label>
         <div class="col-md-6">
           <div class="input-group">
             <input id="penyakit_{% _id %}" type="text" class="form-control" name="penyakit" value="{% penyakit %}" >
             <div class="input-group-addon">
             <button type="button" id="save_{% _id %}" class="btn-save-item" data-id="{% _id %}"><i class="fa fa-floppy-o"></i></button>
             <button type="button" id="cancel_{% _id %}" class="btn-cancel-item" data-id="{% _id %}"><i class="fa fa-ban"></i></button>
             </div>
           </div>
         </div>
       </div>
     </div>
   	  {% /item %}
   </script>
   <input type="hidden" name="save_json" id="save_json" value="[]">
   <div class="form-group">
      <label for="obat" class="col-md-3 control-label">Obat</label>
      <div class="col-md-9">
        <div class="box">
          <div class="box-body pad">
              <textarea name="obat" id="obat" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" autofocus required></textarea>
          </div>
        </div>
         <span class="help-block with-errors"></span>
      </div>
   </div>
   <div class="form-group">
      <label for="catatan" class="col-md-3 control-label">Catatan</label>
      <div class="col-md-9">
        <div class="box">
          <div class="box-body pad">
              <textarea name="catatan" id="catatan" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" autofocus required></textarea>
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
