<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class material extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'materials';
     protected $primaryKey = 'kodeMaterial';

    public $incrementing = false;

    /**
    * The database primary key value.
    *
    * @var string
    */

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['kodeMaterial', 'nama', 'satuan'];

    public static function getnama($kodeMaterial){
        $material=material::where('kodeMaterial','=',$kodeMaterial)->first();
        $nama=$material->nama;
        return $nama;
    }
    public static function getsatuan($kodeMaterial){
        $material=material::where('kodeMaterial','=',$kodeMaterial)->first();
        $satuan=$material->satuan;
        return $satuan;
    }
     public static function getJenisBiaya($kodematerial){
        $kode = substr($kodematerial, 0, 3);
        $kelompokUtilitas = JenisBiayaProyek::where('kodeJenisBiaya', '=', $kode)->first();
        return $kode.' - '.$kelompokUtilitas->nama;
    }
    

    
}
