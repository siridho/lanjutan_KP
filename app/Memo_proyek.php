<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memo_proyek extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'memo_proyeks';

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
    protected $fillable = ['nonota', 'id_karyawan', 'tgl', 'kodeProyek', 'status_nota', 'validator', 'waktu_valid'];

    public function karyawan(){
        return $this->belongsTo('App\User', 'id_karyawan', 'id');
    }
    public function detailnota(){
        return $this->hasMany('App\Detail_memo_proyek', 'nonota', 'nonota');
    }
    public function proyek(){
        return $this->belongsTo('App\proyek', 'kodeProyek', 'kodeProyek');
    }
}
