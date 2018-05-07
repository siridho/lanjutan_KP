<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rap extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'raps';

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
    protected $fillable = ['nonota', 'tglNota', 'kodeProyek', 'id_karyawan', 'status', 'validator', 'waktu_valid'];

    public function proyek(){
        return $this->belongsTo('App\proyek', 'kodeProyek', 'kodeProyek');
    }
    // public function detailkegiatan(){
    //     return $this->hasMany('App\RapKegiatan', 'nonota', 'nonota');
    // }
    // public function detailbiaya(){
    //     return $this->hasMany('App\RapBiaya', 'nonota', 'nonota');
    // }
    public function detailpekerjaan($id){
        // return $this->hasMany('App\RapPekerjaan', 'nonota', 'nonota');
        return RapPekerjaan::whereNonota($id)->orderBy('kodeKelompokKegiatan')->get();
    }
    public function karyawan(){
        return $this->belongsTo('App\User', 'id_karyawan', 'id');
    }
}
