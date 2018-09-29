<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PeriksaPasien extends Model
{
  protected $table = 'periksa_pasiens';
  protected $primaryKey = 'id_periksa';
  protected $dates = ['tanggal_periksa'];

  public function getTanggalPeriksaAttribute($value){
     return Carbon::parse($value)->format('d F Y');
	}

  public function setTanggalPeriksaAttribute($date){
		 $this->attributes['tanggal_periksa'] = Carbon::createFromFormat('d F Y', $date)->format('Y-m-d');
	}

}
