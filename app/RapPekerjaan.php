<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RapPekerjaan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rap_pekerjaans';

    /**
    * The database primary key value.
    *
    * @var string
    */
    // protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nonota', 'kodeKelompokKegiatan', 'keterangan'];
    // protected $fillable = ['nonota', 'tglNota', 'kodeKelompokKegiatan','tgl_mulai', 'minggu_mulai', 'lama', 'volume', 'totalHarga', 'noBaris'];
    
    public function Kelompok_kegiatan(){
        return $this->belongsTo('App\Kelompok_kegiatan', 'kodeKelompokKegiatan', 'kodeKelompokKegiatan');
    }
    public function detailkegiatan(){
        return $this->hasMany('App\RapKegiatan', 'kode_pekerjaan', 'kodeKelompokKegiatan');
    }
    // public function getPekerjaan($kode){
    //     return $this::where('kode_pekerjaan','=',$kode)->get();
    // }
}
