<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class managerProyek extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'manager_proyeks';
     protected $primaryKey = 'kodeManager';

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
    protected $fillable = ['kodeManager', 'nama', 'alamat', 'identitas', 'tanggalMasuk', 'email', 'telepon'];

    
}
