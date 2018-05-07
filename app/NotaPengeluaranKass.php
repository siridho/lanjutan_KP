<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaPengeluaranKass extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nota_pengeluaran_kasses';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'no';
    public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nonota', 'id_karyawan', 'referensi', 'validator', 'kodeProyek', 'tglNota','status_nota','waktu_valid'];

    public function mitra(){    
        return $this->belongsTo('App\mitraKerja', 'kodeMitra', 'kodeMitra');
    }
    public function karyawan(){
        return $this->belongsTo('App\User', 'id_karyawan', 'id');
    }
    public function detailnota(){
        return $this->hasMany('App\DetailPengeluaranKass', 'nonota', 'nonota');
    }
    public function proyek(){
        return $this->belongsTo('App\proyek', 'kodeProyek', 'kodeProyek');
    }

    
}
