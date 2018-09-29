<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
use App\PeriksaPasien;
use DataTables;
use Carbon\Carbon;

class PasienController extends Controller
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
        return view('admin.pasien.index');
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
          $row[] = $list->tanggal_lahir;
          $row[] = $list->jenis_kelamin;
          $row[] = Pasien::age();
          $row[] = $list->desa;
          $row[] = "<div class='btn-group'>
                    <a onclick='detailInfo(".$list->kode_pasien.")' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>
                   <a onclick='editForm(".$list->id_pasien.")' class='btn btn-success btn-sm'><i class='fa fa-pencil'></i></a>
                  <a onclick='deleteData(".$list->id_pasien.")' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a></div>";
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
        $age = Carbon::parse($request->date);
        $usia = $age->diffInYears(Carbon::now());

        $pasien = new Pasien;
        $pasien->kode_pasien = Pasien::generateKode();
        $pasien->nama = $request->nama;
        $pasien->tempat = $request->tempat;
        $pasien->tanggal_lahir = $request->date;
        $pasien->usia = $usia;
        $pasien->jenis_kelamin = $request->jenis_kelamin;
        $pasien->alamat = $request->alamat;
        $pasien->desa = $request->desa;
        $pasien->save();
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
        $find = Pasien::find($id);
        echo json_encode($find);
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
      $age = Carbon::parse($request->date);
      $usia = $age->diffInYears(Carbon::now());
      
      $pasien = Pasien::find($id);
      $pasien->nama = $request->nama;
      $pasien->tempat = $request->tempat;
      $pasien->tanggal_lahir = $request->date;
      $pasien->jenis_kelamin = $request->jenis_kelamin;
      $pasien->usia = $usia;
      $pasien->alamat = $request->alamat;
      $pasien->desa = $request->desa;
      $pasien->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $find = Pasien::find($id);
        $find->delete();
    }
}
