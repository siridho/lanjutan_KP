<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'akuns';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'noAkun';
    public $incrementing = false;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['noAkun', 'namaakun', 'status'];

    
}
