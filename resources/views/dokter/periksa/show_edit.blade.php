@extends('base')

@section('title')
  {{$show->pasien_kode}} - {{$show->tanggal_periksa}}
@endsection

@section('breadcrumb')
   @parent
   <li>periksa</li>
   <li>edit</li>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">

 <form class="form form-horizontal" id="formgg" data-toggle="validator" method="post" enctype="multipart/form-data">
   {{ csrf_field() }} {{ method_field('PATCH') }}
   <div class="box-body">

  <div class="alert alert-info alert-dismissible" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i>
    Perubahan berhasil disimpan.
  </div>

  <input type="hidden" name="" value="{{$show->id_periksa}}">
  <div class="form-group">
     <label for="date" class="col-md-2 control-label">Tanggal Periksa</label>
     <div class="col-md-9">
       <div class="input-group">
         <div class="input-group-addon">
           <i class="fa fa-calendar"></i>
         </div>
         <input id="date" type="text" class="form-control" name="date" value="{{$show->tanggal_periksa}}" autofocus required>
       </div>
        <span class="help-block with-errors"></span>
     </div>
  </div>

  <div class="form-group">
     <label for="diagnosa" class="col-md-2 control-label">Diagnosa</label>
     <div class="col-md-9">
       <div class="box">
         <div class="box-body pad">
             <textarea name="diagnosa" id="diagnosa" class="textarea" placeholder="Place some text here" style="width: 100%; height: 80px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" autofocus required>{{$show->diagnosa}}</textarea>
         </div>
       </div>
        <span class="help-block with-errors"></span>
     </div>
  </div>

  <div class="form-group">
     <label for="obat" class="col-md-2 control-label">Obat</label>
     <div class="col-md-9">
       <div class="box">
         <div class="box-body pad">
             <textarea name="obat" id="obat" class="textarea" placeholder="Place some text here" style="width: 100%; height: 80px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" autofocus required>{{$show->obat}}</textarea>
         </div>
       </div>
        <span class="help-block with-errors"></span>
     </div>
  </div>
  <div class="form-group">
     <label for="catatan" class="col-md-2 control-label">Catatan</label>
     <div class="col-md-9">
       <div class="box">
         <div class="box-body pad">
             <textarea name="catatan" id="catatan" class="textarea" placeholder="Place some text here" style="width: 100%; height: 80px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" autofocus required>{{$show->catatan}}</textarea>
         </div>
       </div>
        <span class="help-block with-errors"></span>
     </div>
  </div>
  <div class="alert alert-info alert-dismissible" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i>
    Perubahan berhasil disimpan.
  </div>
  </div>
  <div class="box-footer">
    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Simpan Perubahan</button>
  </div>
</form>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        Penyakit
      </div>
      <div class="box-body">
        <table class="table table-striped" id="tablex">
        <thead>
           <tr>
              <th width="20">No</th>
              <th>Penyakit</th>
              <th width="100">Aksi</th>
           </tr>
        </thead>
        <tbody>
          @foreach ($penyakit as $value)
            <tr>
              <td>{{$no++}}</td>
              <td>{{$value->penyakit}}</td>
              <td><a onclick='editForm("{{$value->id_penyakit}}")' class='btn btn-success btn-sm'><i class='fa fa-edit'></i></a>
              <a onclick='deleteData("{{$value->id_penyakit}}")' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a></td>
            </tr>
          @endforeach
        </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

@include('dokter.periksa.edit_penyakit')
@endsection

@section('script')
<script type="text/javascript">
$(function(){
  $('#date').datepicker({
    format: 'd MM yyyy',
    autoclose: true,
    todayHighlight: true
  });
  $('.textarea').wysihtml5({
    toolbar: {
      "html": false, //Button which allows you to edit the generated HTML. Default false
      "link": false, //Button to insert a link. Default true
      "image": false, //Button to insert an image. Default true,
    }
  });

  $('.form').validator().on('submit', function(e){
     if(!e.isDefaultPrevented()){

        $.ajax({
          url : "edit/update",
          type : "POST",
          data : $('.form').serialize(),
          success : function(data){
              $('.alert').css('display', 'block').delay(2000).fadeOut();
          },
          error : function(){
            alert("Tidak dapat menyimpan data!");
          }
        });
        return false;
    }
  });

  $('#modal-form form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
        var id = $('#id').val();

         $.ajax({
           url : "edit/"+id+"/updatePenyakit",
           type : "POST",
           data : $('#modal-form form').serialize(),
           success : function(data){
                $('#modal-form').modal('hide');
                window.location.reload(true);
           },
           error : function(){
             alert("Tidak dapat menyimpan data!");
           }
         });
         return false;
     }
   });

});

function editForm(id){
   save_method = "edit";
   $('input[name=_method]').val('PATCH');
   $('#modal-form form')[0].reset();
   $.ajax({
     url : "edit/"+id,
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-form').modal('show');
       $('.modal-title').text('Edit Penyakit');

       $('#id').val(data.id_penyakit);
       $('#penyakit').val(data.penyakit);

     },
     error : function(){
       alert("Tidak dapat menampilkan data!");
     }
   });
}

function deleteData(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "edit/"+id+"/delete",
       type : "POST",
       data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
       success : function(data){
         window.location.reload(true);
       },
       error : function(){
         alert("Tidak dapat menghapus data!");
       }
     });
   }
}
</script>
@endsection
