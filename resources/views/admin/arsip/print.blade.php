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
      <table>

        <tr>
          <td>Kode Pasien </td>
          <td> : </td>
          <td> {{$pasien->kode_pasien}}</td>
        </tr>

        <tr>
          <td>Nama </td>
          <td> : </td>
          <td> {{$pasien->nama}}</td>
        </tr>

        <tr>
          <td>Tempat, Tanggal Lahir </td>
          <td> : </td>
          <td> {{$pasien->tempat}}, {{$pasien->tanggal_lahir}}</td>
        </tr>

        <tr>
          <td>Jenis Kelamain </td>
          <td> : </td>
          <td> {{$pasien->jenis_kelamin}}</td>
        </tr>

        <tr>
          <td>Usia </td>
          <td> : </td>
          <td> {{$pasien->usia}}</td>
        </tr>

        <tr>
          <td>Alamat </td>
          <td> : </td>
          <td> {{strip_tags($pasien->alamat)}}</td>
        </tr>

        <tr>
          <td>Desa </td>
          <td> : </td>
          <td> {{$pasien->desa}}</td>
        </tr>
      </table>
    </li>
    <br>
    <li class="list-group-item"><strong>Riwayat Penyakit</strong></li>
    <li class="list-group-item">
      {!! $riwayat->riwayat_penyakit !!}
    </li>
    <br>
    <li class="list-group-item"><strong>Diagnosa</strong></li>
    <li class="list-group-item">
      {!! $periksa->diagnosa !!}
    </li>
    <br>
    <li class="list-group-item"><strong>Penyakit</strong></li>
    <li class="list-group-item">
      @foreach ($penyakit as $value)
        -{!! $value->penyakit !!}<br>
      @endforeach
    </li>
    <br>
    <li class="list-group-item"><strong>Obat</strong></li>
    <li class="list-group-item">
      {!! $periksa->obat !!}
    </li>
    <br>
    <li class="list-group-item"><strong>Catatan</strong></li>
    <li class="list-group-item">
      {!! $periksa->catatan !!}
    </li>
  </ul>

</body>
</html>
