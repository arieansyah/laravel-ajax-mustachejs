<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PeriksaPasien;
use App\Pasien;
use PDF;
use DataTables;

class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.arsip.index');
    }

    public function listData(){
      $pasien = PeriksaPasien::leftJoin('pasiens', 'pasiens.kode_pasien', '=', 'periksa_pasiens.pasien_kode')->get();
      $no = 0;
      $data = array();
      foreach($pasien as $list){
        $no ++;
        $row = array();
        $row[] = $no;
        $row[] = $list->kode_pasien;
        $row[] = $list->nama;
        $row[] = $list->tanggal_periksa;
        $row[] = $list->jenis_kelamin;
        $row[] = $list->desa;
        $row[] = "<div class='btn-group'>
                  <a onclick='detailInfo(".$list->kode_pasien.")' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>
                  <a target='_blank' href='arsip/".$list->kode_pasien."/print' class='btn btn-danger btn-sm'><i class='fa fa-print'></i></a>";
        $data[] = $row;
      }

      return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function printPasien($id){
      $arsip = Pasien::leftJoin('riwayat_pasiens', 'riwayat_pasiens.pasien_kode', '=', 'pasiens.kode_pasien')->where('kode_pasien', $id)->first();
  		$dompdf = PDF::loadView('admin.arsip.print', compact('arsip'));
      $dompdf->setPaper('a4', 'potrait');
  		return $dompdf->stream($arsip->kode_pasien.'_'.$arsip->nama.'.pdf');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $find = Pasien::leftJoin('riwayat_pasiens', 'riwayat_pasiens.pasien_kode', '=', 'pasiens.kode_pasien')->where('kode_pasien', $id)->first();
      echo json_encode($find);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
