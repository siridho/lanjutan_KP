<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailNotaKasMasuk extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detail_nota_kas_masuks';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nonota', 'uraian', 'noBaris', 'saldo','tglNota'];

     public function detailnota(){
        return $this->belongsTo('App\NotaKasMasuk', 'nonota', 'nonota');
    }

    
}
