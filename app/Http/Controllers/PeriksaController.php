<?php

namespace App\Http\Controllers;

use App\Pasien;
use App\RiwayatPasien;
use App\PeriksaPasien;
use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeriksaController extends Controller
{
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
                    <a href='periksa/".$list->kode_pasien."' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>";
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
                  <a onclick='editForm(".$list->id_periksa.")' class='btn btn-success btn-sm'><i class='fa fa-edit'></i></a>
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
        $store = new PeriksaPasien;
        $store->pasien_kode = $request->id;
        $store->tanggal_periksa = $request->date;
        $store->diagnosa = $request->diagnosa;
        $store->penyakit = $request->penyakit;
        $store->obat = $request->obat;
        $store->catatan = $request->catatan;
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

    public function showHasil($kode){
      $show = PeriksaPasien::find($kode);
      echo json_encode($show);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $show = PeriksaPasien::find($id);
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
      $store->penyakit = $request->penyakit;
      $store->obat = $request->obat;
      $store->catatan = $request->catatan;
      $store->update();
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
}
