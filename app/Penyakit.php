<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    protected $table = 'penyakits';
    protected $primaryKey = 'id_penyakit';
}
