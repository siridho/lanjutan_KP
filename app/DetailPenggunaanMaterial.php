<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPenggunaanMaterial extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_penggunaan_materials';

    /**
    * The database primary key value.
    *
    * @var string
    */
    //protected $primaryKey = 'id';

    public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nonota', 'kodeMaterial', 'jumlah','keterangan', 'noBaris', 'tglNota'];

    public function detailnota(){
        return $this->belongsTo('App\NotaPengeluaranKass', 'nonota', 'no');
    }

    public function material(){
        return $this->belongsTo('App\material', 'kodeMaterial', 'kodeMaterial');
    }
     public static function detailKartuGuna($nonota,$id){
        return $mater=DetailPenggunaanMaterial::where('nonota','=',$nonota)->where('kodeMaterial','=',$id)->first();
    }
    
}
