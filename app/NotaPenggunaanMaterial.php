<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaPenggunaanMaterial extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nota_penggunaan_materials';

    /**
    * The database primary key value.
    *
    * @var string
    */
    //protected $primaryKey = 'id';
    protected $primaryKey = 'nonota';
    public $incrementing = false;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nonota', 'id_karyawan', 'kodeProyek', 'tanggalNota', 'referensi', 'status', 'validator'];

    // public function gudang(){
    //     return $this->belongsTo('App\gudang', 'kodeGudang', 'kodeGudang');
    // }
    public function proyek(){
        return $this->belongsTo('App\proyek', 'kodeProyek', 'kodeProyek');
    }
    public function karyawan(){
        return $this->belongsTo('App\User', 'id_karyawan', 'id');
    }
    public function detailnota(){
        return $this->hasMany('App\DetailPenggunaanMaterial', 'nonota', 'nonota');
    }
}
