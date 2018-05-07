<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class alat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alats';

    /**
    * The database primary key value.
    *
    * @var string
    */

    protected $primaryKey = 'kodeAlat';

    public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['kodeAlat', 'nama', 'kelompokUtilitas','Satuan','keterangan','masapakai'];

    public static function getKelompokUtilitas($kodeAlat){
        $kode = substr($kodeAlat, 0, 3);
        $kelompokUtilitas = JenisBiayaProyek::where('kodeJenisBiaya', '=', $kode)->first();
        return $kelompokUtilitas->nama;
    }
}
