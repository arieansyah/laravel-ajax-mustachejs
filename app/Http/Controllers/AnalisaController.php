<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penyakit;

class AnalisaController extends Controller
{
    public function index(){
      $penyakit = '';
      $result = '';
      return view('admin.analisis.index', compact('penyakit','result'));
    }

    public function hasilProses(Request $req){
      $penyakit = Penyakit::where('penyakit', $req->penyakit)->count();
      $total = Penyakit::all()->count();

      $sum = $penyakit / $total;
      $result = $sum * 100;

      return view('admin.analisis.index', compact('penyakit', 'result'));
    }
}
