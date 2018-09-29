<!DOCTYPE html>
<html>
<head>
  {{-- <title>{{$arsip}}</title> --}}
  {{-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ url('public/bootstrap/css/bootstrap.min.css') }}">
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> --}}
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<body>
  <div class="text-center">
    <img src="img/logo100.png" alt="">
    <h1>PUSKESMAS MULYOHARJO PEMALANG</h1>
  </div>

  <ul class="list-group">
    <li class="list-group-item"><strong>Data Pasien</strong></li>
    <li class="list-group-item">
      Kode Pasien : {{$arsip->kode_pasien}}<br>
      Nama : {{$arsip->nama}}<br>
      Tempat, Tanggal Lahir : {{$arsip->tempat}}, {{$arsip->tanggal_lahir}}<br>
      Jenis Kelamin : {{$arsip->jenis_kelamin}}<br>
      Usia : {{$arsip->usia}}<br>
      Alamat : {!!$arsip->alamat!!}<br>
      Desa : {{$arsip->desa}}
    </li>
    <br>
    <li class="list-group-item"><strong>Riwayat Penyakit</strong></li>
    <li class="list-group-item">
      {!! $arsip->riwayat_penyakit !!}
    </li>
  </ul>

</body>
</html>
