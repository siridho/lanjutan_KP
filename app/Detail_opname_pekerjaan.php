<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_opname_pekerjaan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_opname_pekerjaans';

    /**
    * The database primary key value.
    *
    * @var string
    */
    // protected $primaryKey = 'nonota';
    // public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nonota', 'tglNota', 'noBaris', 'kodeKelompokKegiatan', 'volume'];

    public function kelompokkegiatan(){
        return $this->belongsTo('App\Kelompok_kegiatan', 'kodeKelompokKegiatan', 'kodeKelompokKegiatan');
    }

    
}
