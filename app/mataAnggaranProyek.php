<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mataAnggaranProyek extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mata_anggaran_proyeks';

    protected $primaryKey = 'kodeKelompokAnggaran';

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
    protected $fillable = ['kodeKelompokAnggaran', 'nama'];

    
    
}
