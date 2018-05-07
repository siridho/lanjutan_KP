<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use session;

class RapKegiatan extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rap_kegiatans';

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
    protected $fillable = ['nonota', 'tglNota', 'kodeKelompokKegiatan', 'minggu_mulai', 'lama', 'volume', 'totalHarga', 'noBaris', 'kode_pekerjaan', 'hargaSat'];
    // protected $fillable = ['nonota', 'tglNota', 'kodeKelompokKegiatan','tgl_mulai', 'minggu_mulai', 'lama', 'volume', 'totalHarga', 'noBaris'];
    public function rap(){
        return $this->belongsTo('App\Rap', 'nonota', 'nonota');
    }
    
    public function Kelompok_kegiatan(){
        return $this->belongsTo('App\Kelompok_kegiatan', 'kodeKelompokKegiatan', 'kodeKelompokKegiatan');
    }
    public function pekerjaan(){
        return $this->belongsTo('App\Kelompok_kegiatan','kode_pekerjaan', 'kodeKelompokKegiatan');
    }

    public function detailbiaya(){
        return $this->hasMany('App\RapBiaya', 'nonota', 'nonota');
    }

    public function subtotalkegiatan($nonota, $kode_pekerjaan){
        $tot = $this::where('nonota','=',$nonota)->where('kode_pekerjaan', '=', $kode_pekerjaan)->select(DB::raw('sum(volume * hargaSat) as total'))->first();

        return $tot->total;
    }
}
