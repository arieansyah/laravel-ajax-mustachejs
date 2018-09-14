<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pasien extends Model
{
  protected $table = 'pasiens';
  protected $primaryKey = 'id_pasien';
  protected $dates = ['tanggal_lahir'];

  public function getTanggalLahirAttribute($value){
     return Carbon::parse($value)->format('d F Y');

	}

  public function setTanggalLahirAttribute($date){
		 $this->attributes['tanggal_lahir'] = Carbon::createFromFormat('d F Y', $date)->format('Y-m-d');
	}

  public static function generateKode() {
      $number = mt_rand(10000, 99999); // better than rand()

      // call the same function if the barcode exists already
      if (Pasien::kodeNumberExists($number)) {
          return generateKode();
      }

      // otherwise, it's valid and can be used
      return $number;
  }

  public static function kodeNumberExists($number) {
      // query the database and return a boolean
      // for instance, it might look like this in Laravel
      return Pasien::where('kode_pasien', $number)->exists();
  }

  public static function age() {
    $date = Pasien::first();
    $getAge = Carbon::parse($date->tanggal_lahir);
    return $getAge->diffInYears(Carbon::now());
  }

//   public function getTanggalLahirAttribute() {
//     return $this->tanggal_lahir->diffInYears(\Carbon\Carbon::now());
// }
}
