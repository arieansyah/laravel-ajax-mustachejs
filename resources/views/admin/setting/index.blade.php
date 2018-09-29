@extends('base')

@section('title')
  Edit Admin
@endsection

@section('breadcrumb')
   @parent
   <li>setting</li>
   <li>admin</li>
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

  <div class="form-group">
      <label for="nama" class="col-md-2 control-label">Nama</label>
      <div class="col-md-6">
         <input id="nama" type="text" class="form-control" name="name" max="10" required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

  <div class="form-group">
      <label for="email" class="col-md-2 control-label">Email</label>
      <div class="col-md-6">
         <input id="email" type="email" class="form-control" name="email" required>
         <span class="help-block with-errors"></span>
      </div>
   </div>

  <div class="form-group">
      <label for="passwordlama" class="col-md-2 control-label">Password Lama</label>
      <div class="col-md-6">
         <input id="passwordlama" type="password" class="form-control" name="passwordlama">
         <span class="help-block with-errors"></span>
      </div>
   </div>

  <div class="form-group">
      <label for="password" class="col-md-2 control-label">Password</label>
      <div class="col-md-6">
         <input id="password" type="password" class="form-control" name="password">
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="password1" class="col-md-2 control-label">Ulang Password</label>
      <div class="col-md-6">
         <input id="password1" type="password" class="form-control" data-match="#password" name="password1">
         <span class="help-block with-errors"></span>
      </div>
   </div>

  </div>
  <div class="box-footer">
    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Simpan Perubahan</button>
  </div>
</form>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(function(){

  showData();
    $('#passwordlama').keyup(function(){
      if($(this).val() != "") $('#password, #password1').attr('required', true);
      else $('#password, #password1').attr('required', false);
    });

   $('.form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){

         $.ajax({
           url : "setting/{{ Auth::user()->id }}",
           type : "POST",
           data : $('.form').serialize(),
           dataType: 'JSON',
           success : function(data){
             if(data.msg == "error"){
               alert('Password lama salah!');
               $('#passwordlama').focus().select();
             }else{
               showData();
               d = new Date();
               $('.alert').css('display', 'block').delay(2000).fadeOut();
             }
           },
           error : function(){
             alert("Tidak dapat menyimpan data!");
           }
         });
         return false;
     }
   });
});


function showData(){
  $.ajax({
    url : "setting/{{ Auth::user()->id }}/edit",
    type : "GET",
    dataType : "JSON",
    success : function(data){
      $('#nama').val(data.name);
      $('#email').val(data.email);
    },
    error : function(){
      alert("Tidak dapat menyimpan data!");
    }
  });
}

</script>
@endsection
