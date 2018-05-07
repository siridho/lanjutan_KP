<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opname_volume_pekerjaan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'opname_volume_pekerjaans';

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
    protected $fillable = ['nonota', 'tglNota', 'kodeProyek', 'idKaryawan', 'status_nota', 'validator', 'waktu_valid'];

     public function detail(){
        return $this->hasMany('App\Detail_opname_pekerjaan', 'nonota', 'nonota');
    }
}
