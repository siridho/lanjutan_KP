<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal_manajemen extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'personal_manajemens';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'kodePersonalManajemen';
    public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['kodePersonalManajemen', 'nama', 'alamat', 'nomoridentitas', 'bagian', 'jabatan'];

    
}
