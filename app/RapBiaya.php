<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RapBiaya extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rap_biayas';

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
    protected $fillable = ['nonota', 'kodeJenisBiaya', 'qty', 'harsat', 'noBaris', 'noBarisKegiatan','tglNota','kodeKegiatan','kodePekerjaan'];
    public function biaya(){
        return $this->belongsTo('App\JenisBiayaProyek', 'kodeJenisBiaya', 'kodeJenisBiaya');
    }

}
