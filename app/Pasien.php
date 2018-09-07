<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
  protected $table = 'pasiens';
  protected $primaryKey = 'id_pasien';

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
