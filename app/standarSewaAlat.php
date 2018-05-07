<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class standarSewaAlat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'standar_sewa_alats';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';
    // public $incrementing = false;
  

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['kode_alat', 'kode_mitra', 'harga_satuan', 'jangka_bayar'];

    public function mitra(){
        return $this->belongsTo('App\mitraKerja', 'kode_mitra', 'kodeMitra');
    }
    public function material(){
        return $this->belongsTo('App\alat', 'kode_alat', 'kodeAlat');
    }
    
}
