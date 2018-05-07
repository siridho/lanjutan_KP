<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jenisPengeluaranKasProyek extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'jenis_pengeluaran_kas_proyeks';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'kodePengeluaran';
    public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['kodePengeluaran', 'nama', 'satuan', 'keterangan'];

    
    
}
