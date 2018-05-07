<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTerimaBarang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_terima_barangs';

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
    protected $fillable = ['nonota', 'kodeProyek', 'keterangan', 'jumlah', 'kode_material', 'noBaris', 'baris_detail_beli', 'harga', 'tglNota'];

    public function material(){
        return $this->belongsTo('App\material', 'kode_material', 'kodeMaterial');
    }
    public function notaterima(){
        return $this->belongsTo('App\NotaTerimaBarang', 'nonota', 'nonota');
    }
     public function proyek(){
        return $this->belongsTo('App\proyek', 'kodeProyek', 'kodeProyek');
    }
    public static function detailKartuTerima($nonota,$id){
        return $mater=DetailTerimaBarang::where('nonota','=',$nonota)->where('kode_material','=',$id)->first();
    }

    
}
