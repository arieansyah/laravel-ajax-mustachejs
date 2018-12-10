<?php

namespace App\Http\Controllers;

use App\Pasien;
use App\RiwayatPasien;
use App\PeriksaPasien;
use App\Penyakit;
use DataTables;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeriksaController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dokter.periksa.index');
    }

    public function listData()
    {
        $pasien = Pasien::orderBy('id_pasien', 'desc')->get();
        $no = 0;
        $data = array();
        foreach($pasien as $list){
          $no ++;
          $row = array();
          $row[] = $no;
          $row[] = $list->kode_pasien;
          $row[] = $list->nama;
          $row[] = $list->tempat.", ".$list->tanggal_lahir;
          $row[] = $list->jenis_kelamin;
          $row[] = Pasien::age();
          $row[] = $list->desa;
          $row[] = "<div class='btn-group'>
                    <a href='periksa/".$list->kode_pasien."' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>
                    <a target='_blank' href='periksa/".$list->kode_pasien."/print' class='btn btn-danger btn-sm'><i class='fa fa-print'></i></a>";
          $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function listDataPeriksa($kode){
      $pasien = PeriksaPasien::where('pasien_kode', $kode)->orderBy('id_periksa', 'desc')->get();
      $no = 0;
      $data = array();
      foreach($pasien as $list){
        $no ++;
        $row = array();
        $row[] = $no;
        $row[] = $list->tanggal_periksa;
        $row[] = "<div class='btn-group'>
                  <a href='".$list->id_periksa."/show/edit' class='btn btn-success btn-sm'><i class='fa fa-edit'></i></a>
                  <a onclick='detailInfo(".$list->id_periksa.")' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>
                  <a onclick='deleteData(".$list->id_periksa.")' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a>";
        $data[] = $row;
      }

      return DataTables::of($data)->escapeColumns([])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $get = PeriksaPasien::max('id_periksa');
        $max = $get + 1;
        $store = new PeriksaPasien;
        $store->pasien_kode = $request->id;
        $store->tanggal_periksa = $request->date;
        $store->diagnosa = $request->diagnosa;
        $store->obat = $request->obat;
        $store->catatan = $request->catatan;

        $save_json = json_decode($request->save_json);
        foreach ($save_json as $key => $data) {
          $penyakit = new Penyakit;
          $penyakit->periksa_id = $max;
          $penyakit->penyakit = strtolower($data->penyakit);
          $penyakit->save();
        }

        $store->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $periksa = Pasien::where('kode_pasien', $id)->first();
        $riwayat = RiwayatPasien::where('pasien_kode', $id)->first();
        return view('dokter.periksa.detail', compact('periksa', 'riwayat'));
    }

    public function showEdit($id){
      $show = PeriksaPasien::where('id_periksa', $id)->first();
      $penyakit = Penyakit::where('periksa_id', $id)->get();
      $no = 1;
      return view('dokter.periksa.show_edit', compact('show', 'penyakit', 'no'));
    }

    public function showHasil($kode){
      $show = PeriksaPasien::find($kode);
      $penyakit = Penyakit::where('periksa_id', $kode)->get();

      $data       = array();
      $get = array();
      foreach ($penyakit as $list) {
        $get[] = "- ".$list->penyakit."<br>";
        //$data[] = $get;
      }
      //$data[] = array("");

      $output = array(
        "tampil" => $show,
        "get" => $get,
      );
      // $row = array();
      // $row[] = $show

      // $diagnosa = $show->diagnosa;
      // $data[] = array("$diagnosa")
      // $output = array("data" => $data);
      //response()->json($output);
      echo json_encode($output);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $show = PeriksaPasien::leftJoin('penyakits', 'penyakits.periksa_id', '=', 'periksa_pasiens.id_periksa')
      ->where('id_periksa', $id)->first();
      echo json_encode($show);
    }

    public function editPenyakit($id,$id_penyakit)
    {
      $show = Penyakit::find($id_penyakit);
      echo json_encode($show);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $store = PeriksaPasien::find($id);
      $store->tanggal_periksa = $request->date;
      $store->diagnosa = $request->diagnosa;
      $store->obat = $request->obat;
      $store->catatan = $request->catatan;
      $store->update();
    }

    public function updatePenyakit(Request $req, $id, $id_penyakit){
      $store = Penyakit::find($id_penyakit);
      $store->penyakit = $req->penyakit;
      $store->update();
    }

    public function printPasien($id){
      $pasien = Pasien::where('kode_pasien', $id)->first();
      $riwayat = RiwayatPasien::where('pasien_kode', $id)->first();
      $periksa = PeriksaPasien::where('pasien_kode', $id)->first();
      $penyakit = Penyakit::leftJoin('periksa_pasiens', 'periksa_pasiens.id_periksa', '=', 'penyakits.periksa_id')->where('pasien_kode', $id)->get();
      $dompdf = PDF::loadView('dokter.periksa.print', compact('pasien', 'riwayat', 'periksa', 'penyakit'));
      $dompdf->setPaper('a4', 'potrait');
      return $dompdf->stream($pasien->kode_pasien.'_'.$pasien->nama.'.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = PeriksaPasien::find($id);
        $hapus->delete();
    }

    public function delete($id, $id_penyakit)
    {
        $hapus = Penyakit::find($id_penyakit);
        $hapus->delete();
    }
}
