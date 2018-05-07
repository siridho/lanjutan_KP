<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gudang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gudangs';

    protected $primaryKey = 'kodeGudang';

    public $incrementing = false;

    /**
    * The database primary key value.
    *
    * @var string
    */
    

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['kodeGudang', 'nama', 'keterangan'];

    
}
