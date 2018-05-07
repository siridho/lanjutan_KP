<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proyek extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'proyeks';
     protected $primaryKey = 'kodeProyek';

    public $incrementing = false;

    /**
    * The database primary key value.
    *
    * @var string
    */

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['kodeProyek', 'kodeCustomer', 'kodeManager', 'uraian', 'jenis', 'volume', 'waktu', 'tanggalMulai'];


    public function customer(){
        return $this->belongsTo('App\customer', 'kodeCustomer', 'kodeCustomer');
    }
    public function manager(){
        return $this->belongsTo('App\managerProyek', 'kodeManager', 'kodeManager');
    }
    
}
