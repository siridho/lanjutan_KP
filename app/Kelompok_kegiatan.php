<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelompok_kegiatan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kelompok_kegiatans';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'kodeKelompokKegiatan';
    public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['kodeKelompokKegiatan', 'nama', 'satuan'];

    
}
