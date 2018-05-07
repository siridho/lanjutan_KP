<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mitraKerja extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mitra_kerjas';

    protected $primaryKey = 'kodeMitra';

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
    protected $fillable = ['kodeMitra', 'nama', 'alamat', 'telepon', 'email', 'npwp', 'kontakNama', 'kontakTelepon'];

    
}
