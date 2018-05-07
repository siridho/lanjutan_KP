<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailBeliMaterial extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_beli_materials';

    /**
    * The database primary key value.
    *
    * @var string
    */
    // protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nonota', 'kode_material', 'keterangan', 'qty', 'harga', 'noBaris', 'tglNota'];

    public function material(){
        return $this->belongsTo('App\material', 'kode_material', 'kodeMaterial');
    }
}
