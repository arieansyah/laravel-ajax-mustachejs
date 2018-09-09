@extends('base')

@section('title')
  Daftar Pasien
@endsection

@section('breadcrumb')
   @parent
   <li>pasien</li>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
        <label for="desa"> Desa</label>
        <input data-column="6" type="text" name="desa" id="desa">
        <label for="nama"> nama</label>
        <input data-column="2" type="text" name="nama" id="nama">
        <label for="">From</label>
          <input id="min" type="text" name="min">
        <label for="">To</label>
          <input id="max" type="text" name="max">

      </div>
      <div class="box-body">

<form method="post" id="form-pasien">
{{ csrf_field() }}
<table class="table table-striped" id="table">
<thead>
   <tr>
      <th width="20">No</th>
      <th>Kode</th>
      <th>Nama</th>
      <th>Tempat, Tanggal Lahir</th>
      <th>Jenis Kelamin</th>
      <th>Usia</th>
      <th>Desa</th>
      <th width="100">Aksi</th>
   </tr>
</thead>
<tbody></tbody>
</table>
</form>

      </div>
    </div>
  </div>
</div>

@include('admin.pasien.form')
@include('admin.pasien.detail')
@endsection

@section('script')
<script type="text/javascript">
var table, save_method;

$(function(){
  table = $('#table').DataTable({
    "processing" : true,
    "serverside" : true,
    "ajax" : {
      "url" : "{{ route('pasien.data') }}",
      "type" : "GET",
    },
    'columnDefs': [{
        'targets': 0,
        'searchable': true,
        'orderable': false
     }],
  });

  $('.textarea').wysihtml5({
    toolbar: {
      "html": false, //Button which allows you to edit the generated HTML. Default false
      "link": false, //Button to insert a link. Default true
      "image": false, //Button to insert an image. Default true,
    }
  });

   $('#desa, #nama').on( 'keyup click', function () {   // for text boxes
     var i =$(this).attr('data-column');  // getting column index
     var v =$(this).val();  // getting search input value
     table.columns(i).search(v).draw();
   });

  $('#modal-form form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
         var id = $('#id').val();
         if(save_method == "add") url = "{{ route('pasien.store') }}";
         else url = "pasien/"+id;

         $.ajax({
            url : url,
            type : "POST",
            data : $('#modal-form form').serialize(),
           success : function(data){
              $('#modal-form').modal('hide');
              table.ajax.reload();
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
   $('.modal-title').text('Tambah Pasien');
   $('#kode').attr('readonly', false);
}

function editForm(id){
   save_method = "edit";
   $('input[name=_method]').val('PATCH');
   $('#modal-form form')[0].reset();
   $.ajax({
     url : "pasien/"+id+"/edit",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-form').modal('show');
       $('.modal-title').text('Edit Pasien');

       $('#id').val(data.id_pasien);
       $('#nama').val(data.nama);
       $('#tempat').val(data.tempat);
       $('#date').val(data.tanggal_lahir);

       if (data.jenis_kelamin == 'L') {
         $("#jenis_kelamin").attr('checked', 'checked');
       }else {
         $("#jenis_kelamin").attr('checked', 'checked');
       }
       $('.wysihtml5-sandbox').contents().find('.wysihtml5-editor').html(data.alamat);
       $('#desa').val(data.desa);
     },
     error : function(){
       alert("Tidak dapat menampilkan data!");
     }
   });
}

function detailInfo(id){
  $('#modal-detail').modal('show');
  $('.modal-title').text('Detail Pasien');
  $.ajax({
    url : "pasien/"+id,
    type : "GET",
    dataType : "JSON",
    success : function(data){
      $('.kode').text(data.kode_pasien);
      $('.nama').text(data.nama);
      $('.tempat').text(data.tempat);
      $('.date').text(data.tanggal_lahir);
      $('.jenis_kelamin').text(data.jenis_kelamin);
      $('.usia').text(data.usia);
      var add = $(data.alamat).text();
      $('.alamat').text(add);
      $('.desa').text(data.desa);

      $('.riwayat_penyakit').text(data.riwayat_penyakit);


    },
    error : function(){
      alert("Tidak dapat menampilkan data!");
    }
  });
}

function deleteData(id){
  if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "pasien/"+id,
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
