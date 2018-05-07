<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaTerimaBarang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nota_terima_barangs';

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
    protected $fillable = ['nonota', 'id_karyawan','nonota_beli', 'kodeMitra', 'status', 'kodeProyek', 'validator','tglNota','referensi'];

    public function mitra(){
        return $this->belongsTo('App\mitraKerja', 'kodeMitra', 'kodeMitra');
    }
    // public function gudang(){
    //     return $this->belongsTo('App\gudang', 'kodeGudang', 'kodeGudang');
    // }
    public function nota_beli(){
        return $this->belongsTo('App\NotaBeliMaterial', 'nonota_beli', 'nonota');
    }
    public function karyawan(){
        return $this->belongsTo('App\User', 'id_karyawan', 'id');
    }
    public function detailterima(){
        return $this->hasMany('App\DetailTerimaBarang', 'nonota', 'nonota');
    }
    public function proyek(){
        return $this->belongsTo('App\proyek', 'kodeProyek', 'kodeProyek');
    }
    
}
