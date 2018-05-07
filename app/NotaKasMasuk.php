<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaKasMasuk extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nota_kas_masuks';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nonota', 'id_karyawan', 'tglNota', 'kodeProyek', 'validator', 'referensi','status_nota','waktu_valid'];

    public function karyawan(){
        return $this->belongsTo('App\User', 'id_karyawan', 'id');
    }
    public function detailnota(){
        return $this->hasMany('App\DetailNotaKasMasuk', 'nonota', 'nonota');
    }
    public function proyek(){
        return $this->belongsTo('App\proyek', 'kodeProyek', 'kodeProyek');
    }

    
}
