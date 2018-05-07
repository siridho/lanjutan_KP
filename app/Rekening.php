<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rekenings';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'kodeRekening';
    public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['kodeRekening', 'norek', 'namabank'];

    
}
