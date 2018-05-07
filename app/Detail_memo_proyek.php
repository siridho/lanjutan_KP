<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_memo_proyek extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_memo_proyeks';

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
    protected $fillable = ['nonota', 'uraian', 'nilai', 'noBaris', 'tglNota'];

    public function detailnota(){
        return $this->belongsTo('App\Memo_proyek', 'nonota', 'nonota');
    }   
}
