@extends('base')

@section('title')
  Arsip Pasien
@endsection

@section('breadcrumb')
   @parent
   <li>arsip</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Tanggal</h3>
        </div>
        <form>

          <div class="panel-body">
            <div class="input-group input-daterange">
              <input type="text" class="form-control" id="min">
              <div class="input-group-addon">to</div>
              <input type="text" class="form-control" id="max">
            </div>
          </div>
          <div class="panel-footer text-right">
            <input type="button" onClick="this.form.reset()" value="Reset">
          </div>
        </form>
      </div>
    </div>

    <div class="col-xs-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Nama</h3>
        </div>
        <form>

          <div class="panel-body">
            <input data-column="2" type="text" name="namax" id="namax">
          </div>
          <div class="panel-footer text-right">
            <input type="button" onClick="this.form.reset()" value="Reset">
          </div>
        </form>
      </div>
    </div>

    <div class="col-xs-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Desa</h3>
        </div>
        <form>

          <div class="panel-body">
            <input data-column="6" type="text" name="desax" id="desax">
          </div>
          <div class="panel-footer text-right">
            <input type="button" onClick="this.form.reset()" value="Reset">
          </div>
        </form>
      </div>
    </div>

  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-body">
          <table class="table table-striped" id="table">
          <thead>
             <tr>
                <th width="20">No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Tanggal Periksa</th>
                <th>Jenis Kelamin</th>
                <th>Desa</th>
                <th width="100">Aksi</th>
             </tr>
          </thead>
          <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@include('admin.arsip.detail')
@endsection

@section('script')
<script type="text/javascript">
var table, save_method;

$(function(){
  table = $('#table').DataTable({
    "processing" : true,
    "serverside" : true,
    "ajax" : {
      "url" : "{{ route('arsip.data') }}",
      "type" : "GET",
    },
    initComplete: function() {
		var api = this.api();

		api.columns('.filtersearch').indexes().flatten().each(function(i) {
			var column = api.column(i);
			var select = $('<select></select>')
				.appendTo($(column.footer()).empty())
				.on('change', function() {
					var val = $.fn.dataTable.util.escapeRegex(
							$(this).val()
					);

					column
						.search(val ? '^' + val + '$': '', true, false)
						.draw();
				} );

			select.append('<option selected value="">' + $(column.header()).text() + '</option>');

			column.data().unique().sort().each(function(d, j) {
				select.append('<option value="' + d + '">' + d + '</option>');
			} );
		} );
	},
    'columnDefs': [{
        'targets': 0,
        'searchable': true,
        'orderable': false
     }],
  });

  $('#desax, #namax').on( 'keyup click', function () {   // for text boxes
    var i = $(this).attr('data-column');  // getting column index
    var v = $(this).val();  // getting search input value
    table.columns(i).search(v).draw();
  });

  $('#min').change(function() {  table.draw(); });
	$('#max').change(function() {  table.draw(); });

  $('.input-daterange').datepicker({
    clearBtn: true,
    todayHighlight: true
	});

	$('.input-daterange').on('change', function() {
		$('.datepicker').hide();
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
         if(save_method == "add") url = "{{ route('arsip.store') }}";
         else url = "arsip/"+id;

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

$.fn.dataTableExt.afnFiltering.push(
	function( oSettings, aData, iDataIndex ) {
		if ($('#min').val() == '' && $('#max').val() == '') {
			return true;
		}

		if ($('#min').val() != '' || $('#max').val() != '') {
			var iMin_temp = $('#min').val();

			if (iMin_temp == '') {
			  iMin_temp = '01/01/1900';
			}

			var iMax_temp = $('#max').val();

			if (iMax_temp == '') {
			  iMax_temp = '31/12/2999'
			}

			var arr_min = iMin_temp.split("/");
			var arr_max = iMax_temp.split("/");

			// aData[column with dates]
			var arr_date = aData[3].split("/");
  			var iMin = new Date(arr_min[2], arr_min[0], arr_min[1], 0, 0, 0, 0)
			var iMax = new Date(arr_max[2], arr_max[0], arr_max[1], 0, 0, 0, 0)
			var iDate = new Date(arr_date[2], arr_date[0], arr_date[1], 0, 0, 0, 0)

			if ( iMin == "" && iMax == "" )
			{
				return true;
			}
			else if ( iMin == "" && iDate < iMax )
			{
				return true;
			}
			else if ( iMin <= iDate && "" == iMax )
			{
				return true;
			}
			else if ( iMin <= iDate && iDate <= iMax )
			{
				return true;
			}
			return false;
		}
	}
);

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
     url : "arsip/"+id+"/edit",
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
  $('.modal-title').text('Detail Arsip');
  $.ajax({
    url : "arsip/"+id,
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

      $('.riwayat_penyakit').html(data.riwayat_penyakit);


    },
    error : function(){
      alert("Tidak dapat menampilkan data!");
    }
  });
}

function deleteData(id){
  if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "arsip/"+id,
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
