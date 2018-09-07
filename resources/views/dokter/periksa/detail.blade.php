@extends('base')

@section('title')
  Periksa
@endsection

@section('breadcrumb')
   @parent
   <li>periksa</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <h4>Data Pasien</h4>
          <hr>
        </div>
        <div class="box-body">
          <div class="row">
              <div class="col-md-3">
                  Kode Pasien
              </div>
              <div class="col-md-6">
                  <p>
                      : {{$periksa->kode_pasien}}
                  </p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-3">
                  Nama
              </div>
              <div class="col-md-6">
                  <p>
                      : {{$periksa->nama}}
                  </p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-3">
                  Jenis Kelamin
              </div>
              <div class="col-md-6">
                  <p>
                      : {{$periksa->jenis_kelamin}}
                  </p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-3">
                  Usia
              </div>
              <div class="col-md-6">
                  <p>
                      : {{$periksa->usia}}
                  </p>
              </div>
          </div>
          <div class="row">
              <div class="col-md-3">
                  Desa
              </div>
              <div class="col-md-6">
                  <p>
                      : {{$periksa->desa}}
                  </p>
              </div>
          </div>
        </div>
        <div class="panel-footer text-right">
          <a onclick="addForm({{$periksa->kode_pasien}})" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah Hasil Periksa Pasien</a>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <h4>
            Riwayat Penyakit Pasien
          </h4>
          <hr>
        </div>
        <div class="box-body">
          <div class="panel panel-default">
            <div class="panel-body">
                  @if ($riwayat == null)
                    <h1>Belum ada Riwayat Penyakit Pasien</h1>
                  @else
                  {!! $riwayat->riwayat_penyakit !!}
                  @endif
            </div>
          </div>
        </div>
        <div class="panel-footer">
          <div class="text-right">
            @if ($riwayat != null)
              <a onclick="editRiwayat({{$periksa->kode_pasien}})" class="btn btn-primary"><i class="fa fa-edit"></i> Edit Riwayat Penyakit</a>
            @else
              <a onclick="addRiwayat({{$periksa->kode_pasien}})" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah Riwayat Penyakit</a>
            @endif
          </div>
        </div>
        </div>
      </div>
  </div>

<hr>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3>Hasil Periksa Pasien</h3>
        </div>
        <div class="box-body">
          <table class="table table-striped" id="table">
          <thead>
             <tr>
                <th width="20">No</th>
                <th>Tanggal Periksa</th>
                <th width="100">Aksi</th>
             </tr>
          </thead>
          <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@include('dokter.periksa.form')
@include('dokter.periksa.riwayat')
@include('dokter.periksa.detailHasil')

@endsection

@section('script')
<script type="text/javascript">
var table, save_method, table1;
$(function(){

  table = $('.table').DataTable({
    "processing" : true,
    "serverside" : true,
    "ajax" : {
      "url" : "{{ route('periksa.dataPeriksa', $periksa->kode_pasien) }}",
      "type" : "GET"
    },
    'columnDefs': [{
        'targets': 0,
        'searchable': true,
        'orderable': false
     }]
  });

  $('#date').datepicker({
    todayHighlight: true,
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

   $('#modal-form form').validator().on('submit', function(e){
       if(!e.isDefaultPrevented()){
         var id = $('#id').val();
         if (save_method == "add") {
           url = "{{ route('periksa.store') }}";
         }
         else {
            url = id+"/update";
         }

          $.ajax({
            url : url,
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

    $('#modal-riwayat form').validator().on('submit', function(e){
        if(!e.isDefaultPrevented()){
          var id = $('#id').val();
          url = id+"/riwayat";
          if (save_method == "add") {
            url = id+"/riwayat";
          }
          else {
             url = id+"/updateRiwayat";
          }

           $.ajax({
             url : url,
             type : "POST",
             data : $('#modal-riwayat form').serialize(),
             success : function(data){
                  $('#modal-riwayat').modal('hide');
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

function addForm(kode){
   save_method = "add";
   $('input[name=_method]').val('POST');
   $('#modal-form').modal('show');
   $('#modal-form form')[0].reset();
   $('.modal-title').text('Tambah Keywords');
}

function addRiwayat(kode){
  save_method = "riwayat";
  $('input[name=_method]').val('POST');
  $('#modal-riwayat').modal('show');
  $('#modal-riwayat form')[0].reset();
  $('.modal-title').text('Tambah Riwayat Pasien');
}

function editRiwayat(id){
   save_method = "edit";
   $('input[name=_method]').val('PATCH');
   $('#modal-riwayat form')[0].reset();
   $.ajax({
     url : id+"/editRiwayat",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-riwayat').modal('show');
       $('.modal-title').text('Edit Riwayat Penyakit');

       $('.wysihtml5-sandbox').contents().find('.wysihtml5-editor').html(data.riwayat_penyakit);
       //$('#riwayat_penyakit').val(data.riwayat_penyakit);
     },
     error : function(){
       alert("Tidak dapat menampilkan data!");
     }
   });
}

function editForm(id){
   save_method = "edit";
   $('input[name=_method]').val('PATCH');
   $('#modal-form form')[0].reset();
   $.ajax({
     url : id,
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-form').modal('show');
       $('.modal-title').text('Edit Keywords');

       $('#idea').val(data.id_key);
       $('#nama').val(data.periksa);
       $('#respon').val(data.respon);
     },
     error : function(){
       alert("Tidak dapat menampilkan data!");
     }
   });
}

function detailInfo(id){
  $('#modal-detail').modal('show');
  $('.modal-title').text('Detail Hasil Periksa Pasien');
  $.ajax({
    url : id+"/showHasil",
    type : "GET",
    dataType : "JSON",
    success : function(data){


      $('.diagnosa').html(data.diagnosa);
      $('.penyakit').html(data.penyakit);
      $('.obat').html(data.obat);
      $('.catatan').html(data.catatan);

    },
    error : function(){
      alert("Tidak dapat menampilkan data!");
    }
  });
}
function deleteData(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : id,
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
