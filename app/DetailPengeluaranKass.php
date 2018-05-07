<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPengeluaranKass extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_pengeluaran_kasses';

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
    protected $fillable = ['uraian', 'nonota', 'kodeBiayaKas', 'kodeAlat', 'jumlah', 'harga', 'noBaris', 'tglNota'];

    public function detailnota(){
        return $this->belongsTo('App\NotaPengeluaranKass', 'nonota', 'nonota');
    }
    public function biayakas(){
        return $this->belongsTo('App\BiayaKas', 'kodeBiayaKas', 'kodeBiayaKas');
    }
    public function alat(){
        return $this->belongsTo('App\alat', 'kodeAlat', 'kodeAlat');
    }
    
}
