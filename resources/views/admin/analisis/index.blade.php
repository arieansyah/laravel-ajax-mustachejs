@extends('base')

@section('title')
  Analisa Penyakit
@endsection

@section('breadcrumb')
   @parent
   <li>analisa penyakit</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">

   <form class="form form-horizontal" id="formgg" data-toggle="validator" method="post" enctype="multipart/form-data">
     {{ csrf_field() }} {{ method_field('POST') }}
     <div class="box-body">

      <div class="form-group">
          <label for="penyakit" class="col-md-2 control-label">Penyakit</label>
          <div class="col-md-6">
             <input id="penyakit" type="text" class="form-control" name="penyakit" max="10" required>
             <span class="help-block with-errors"></span>
          </div>
       </div>

    </div>
    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Proses</button>
    </div>
  </form>

      </div>

      <div class="box">
        <div class="box-header">
          <h3>Hasil</h3>
        </div>
        <div class="box-body">
          <h1 class="text-center">{{$result}}%</h1>
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

});
</script>
@endsection
