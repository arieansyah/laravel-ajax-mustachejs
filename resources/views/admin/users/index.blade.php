@extends('base')

@section('title')
  Daftar Dokter
@endsection

@section('breadcrumb')
   @parent
   <li>Dokter</li>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
      </div>
      <div class="box-body">

<table class="table table-striped">
<thead>
   <tr>
      <th width="20">No</th>
      <th>Nama</th>
      <th>Email</th>
      <th width="100">Aksi</th>
   </tr>
</thead>
<tbody></tbody>
</table>

      </div>
    </div>
  </div>
</div>

@include('admin.users.form')
@endsection

@section('script')
<script type="text/javascript">
var table, save_method;
$(function(){

   table = $('.table').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "{{ url('dokter/data') }}",
       "type" : "GET"
     },
     'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false
      }],
      'order': [1, 'asc']
   });


  $('#modal-form form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
         var id = $('#id').val();
         if(save_method == "add") url = "{{ route('dokter.store')}}";
         else url = "dokter/"+id;

         $.ajax({
           url : url,
           type : 'POST',
           data : $('#modal-form form').serialize(),
           //dataType: 'JSON',
           success : function(data){
             if(data.msg=="error"){
                $('.alert').css('display', 'block').delay(2000).fadeOut();
             }else{
                $('#modal-form').modal('hide');
                table.ajax.reload();
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

function addForm(){
   save_method = "add";
   $('input[name=_method]').val('POST');
   $('#modal-form').modal('show');
   $('#modal-form form')[0].reset();
   $('.modal-title').text('Tambah Dokter');
}

function editData(id){
    save_method = "edit";
    $('input[name=_method]').val('PATCH');
    $('#modal-form form')[0].reset();
    $.ajax({
      url : "dokter/"+id+"/edit",
      type : "GET",
      dataType : "JSON",
      success : function(data){
        $('#modal-form').modal('show');
        $('.modal-title').text('Edit Dokter');

        $('#id').val(data.id);
        $('#name').val(data.name);
        $('#email').val(data.email);

      },
      error : function(){
        alert("Tidak dapat menampilkan data!");
      }
    });
}

function deleteData(id){
  if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "/dokter/"+id,
       type : "POST",
       data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
       success : function(data){
         table.ajax.reload();
       },
       error : function(){
         alert("Tidak dapat menghapus data!");
       }
     });
   }
}

</script>
@endsection
