@extends('base')

@section('title')
  Daftar Periksa Pasien
@endsection

@section('breadcrumb')
   @parent
   <li>periksa</li>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        Daftar Pasien
      </div>
      <div class="box-body">

<form method="post" id="form-periksa">
{{ csrf_field() }}
<table class="table table-striped" id="tablex">
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

@endsection

@section('script')
<script type="text/javascript">
var table, save_method;

$(function(){

  $('#date').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true
  });
  $('.textarea').wysihtml5({
    toolbar: {
      "html": false, //Button which allows you to edit the generated HTML. Default false
      "link": false, //Button to insert a link. Default true
      "image": false, //Button to insert an image. Default true,
    }
  });
   table = $('.table').DataTable({
     "processing" : true,
     "serverside" : true,
     "ajax" : {
       "url" : "{{ route('periksa.data') }}",
       "type" : "GET"
     },
     'columnDefs': [{
         'targets': 0,
         'searchable': true,
         'orderable': false
      }],
      'order': [1, 'desc']
   });

   // $('#nama').keyup(function(){
   //     table.search($(this).val()).draw();
   //   });
   //
   // $('#desa').keyup(function(){
   //     table.search($(this).val()).draw();
   //   });

   // $('#desa').on( 'keyup click', function () {   // for text boxes
   //     var i =$(this).attr('data-column');  // getting column index
   //     var v =$(this).val();  // getting search input value
   //     table.columns(i).search(v).draw();
   // } );

  $('#modal-form form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
         var id = $('#id').val();
         if(save_method == "add") url = "{{ route('periksa.store') }}";
         else url = "periksa/"+id;

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
     url : "periksa/"+id+"/edit",
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
    url : "periksa/"+id,
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
       url : "periksa/"+id,
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
