<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    protected $primaryKey = 'kodeCustomer';

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
    protected $fillable = ['kodeCustomer', 'nama', 'alamat', 'area', 'telepon', 'email', 'npwp', 'kontakNama', 'kontakTelepon'];

    
}
