<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaBeliMaterial extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nota_beli_materials';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'nonota';
    public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nonota', 'id_karyawan', 'kodeMitra', 'status', 'kodeProyek', 'validator', 'tglNota', 'referensi', 'status_barang','status_nota','waktu_valid','validator'];

    public function mitra(){
        return $this->belongsTo('App\mitraKerja', 'kodeMitra', 'kodeMitra');
    }
    public function karyawan(){
        return $this->belongsTo('App\User', 'id_karyawan', 'id');
    }
    public function detailnota(){
        return $this->hasMany('App\DetailBeliMaterial', 'nonota', 'nonota');
    }
    public function notaterima(){
        return $this->hasMany('App\NotaTerimaBarang', 'nonota_beli', 'nonota');
    }
    public function proyek(){
        return $this->belongsTo('App\proyek', 'kodeProyek', 'kodeProyek');
    }
    
}
