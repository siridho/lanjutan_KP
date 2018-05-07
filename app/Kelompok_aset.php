<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelompok_aset extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kelompok_asets';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'kodeKelompokAset';
    public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['kodeKelompokAset', 'nama', 'masapakai'];

    
}
