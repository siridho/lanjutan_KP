<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use session;

class BiayaKas extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'biaya_kas';

    protected $primaryKey = 'kodeBiayaKas';

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
    protected $fillable = ['kodeBiayaKas', 'nama', 'satuan', 'keterangan'];

     public static function detail(){
        return $this->hasMany('App\DetailPengeluaranKass', 'kodeBiayaKas', 'kodeBiayaKas');
    }

    public static function getJenisBiaya($biayakas){
        $kode = substr($biayakas, 0, 3);
        $kelompokUtilitas = JenisBiayaProyek::where('kodeJenisBiaya', '=', $kode)->first();
        return $kode.' - '.$kelompokUtilitas->nama;
    }


    public static function totkuantum($kodebiayass, $tgl)
    {
        // return substr($kodebiayass, 0,1);
        if(substr($kodebiayass, 0,1)<=2){
        $totkuantumkeluar = DetailPengeluaranKass::join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat', '=', $kodebiayass)->where('detail_pengeluaran_kasses.tglNota','<=',$tgl)->sum('jumlah');
        }else{
            $totkuantumkeluar = DetailPengeluaranKass::join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas', '=', $kodebiayass)->where('detail_pengeluaran_kasses.tglNota','<=',$tgl)->sum('jumlah');
        }
        return $totkuantumkeluar;
    }
    
    public static function totharga($kodebiaya, $tgl)
    {
        if(substr($kodebiaya, 0,1)<=2){
            $jum=DetailPengeluaranKass::join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat', '=', $kodebiaya)->where('detail_pengeluaran_kasses.tglNota','<=',$tgl)->count();
            if($jum){
            $tothargamasuk= DetailPengeluaranKass::select(DB::raw('sum(jumlah * harga) as total'))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat', '=', $kodebiaya)->where('detail_pengeluaran_kasses.tglNota','<=',$tgl)->first();
            return $tothargamasuk['total'];
            }else{
                return '0';
            }
        }else{
             $jum=DetailPengeluaranKass::join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas', '=', $kodebiaya)->where('detail_pengeluaran_kasses.tglNota','<=',$tgl)->count();
            if($jum){
            $tothargamasuk= DetailPengeluaranKass::select(DB::raw('sum(jumlah * harga) as total'))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas', '=', $kodebiaya)->where('detail_pengeluaran_kasses.tglNota','<=',$tgl)->first();
            return $tothargamasuk['total'];
            }else{
                return '0';
            }
        }
    }

    public static function tothargaperiode($kodebiaya, $tglaw,$tglakh)
    {
        if(substr($kodebiaya, 0,1)==2){
           
            $tothargamasuk= DetailPengeluaranKass::select(DB::raw('sum(jumlah * harga) as total'))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat', '=', $kodebiaya)->where('detail_pengeluaran_kasses.tglNota','>=',$tglaw)->where('detail_pengeluaran_kasses.tglNota','<=',$tglakh)->first();
            return $tothargamasuk['total'];
          
        }else{
             
            $tothargamasuk= DetailPengeluaranKass::select(DB::raw('sum(jumlah * harga) as total'))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas', '=', $kodebiaya)->where('detail_pengeluaran_kasses.tglNota','>=',$tglaw)->where('detail_pengeluaran_kasses.tglNota','<=',$tglakh)->first();
            return $tothargamasuk['total'];
           
        }
    }



    public static function hitungratarata($kodebiaya, $tgl){
        if(substr($kodebiaya, 0,1)<=2){
        $jum=DetailPengeluaranKass::join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat', '=', $kodebiaya)->where('detail_pengeluaran_kasses.tglNota','<=',$tgl)->count();
        }else{
         $jum=DetailPengeluaranKass::join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas', '=', $kodebiaya)->where('detail_pengeluaran_kasses.tglNota','<=',$tgl)->count();
        }
        if($jum){
         $totkuantum = BiayaKas::totkuantum($kodebiaya, $tgl);
        
       $totharga= BiayaKas::totharga($kodebiaya, $tgl);
        
        return round($totharga/$totkuantum,4);
        }
        else
        {return '0';}   
    }

    
    public static function grandtotharga($jenis,$tgl){

        if(!$jenis){
            
            $totot= DetailPengeluaranKass::select(DB::raw('sum(jumlah * harga) as total'))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('detail_pengeluaran_kasses.tglNota','<=',$tgl)->groupBy('nota_pengeluaran_kasses.kodeProyek')->first();
        }else{
            if($jenis==2){
                 $totot= DetailPengeluaranKass::select(DB::raw('sum(jumlah * harga) as total'))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('detail_pengeluaran_kasses.tglNota','<=',$tgl)->where('kodeAlat','like','2%')->groupBy('nota_pengeluaran_kasses.kodeProyek')->first();
            }else{
                $totot= DetailPengeluaranKass::select(DB::raw('sum(jumlah * harga) as total'))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('detail_pengeluaran_kasses.tglNota','<=',$tgl)->where('kodeBiayaKas','like',$jenis.'%')->groupBy('nota_pengeluaran_kasses.kodeProyek')->first();
            }
        }
        return $totot['total'];

    }

    public static function grantotmasuk($tglaw){
        
        $jum=DetailNotaKasMasuk::join('nota_kas_masuks','detail_nota_kas_masuks.nonota','=','nota_kas_masuks.nonota')->where('nota_kas_masuks.tglNota','<',$tglaw)->where('nota_kas_masuks.kodeProyek','=',session()->get('pilihanproyek'))->count();
        if($jum){
            return DetailNotaKasMasuk::join('nota_kas_masuks','detail_nota_kas_masuks.nonota','=','nota_kas_masuks.nonota')->where('nota_kas_masuks.tglNota','<',$tglaw)->where('nota_kas_masuks.kodeProyek','=',session()->get('pilihanproyek'))->sum('saldo');
        }else{
            return '0';
        }

    }
    public static function grantotkeluar($tglaw){
        $jum=DetailPengeluaranKass::select(DB::raw('sum(jumlah * harga) as total'))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('detail_pengeluaran_kasses.tglNota','<',$tglaw)->groupBy('nota_pengeluaran_kasses.kodeProyek')->count();
        if($jum){
         $totot= DetailPengeluaranKass::select(DB::raw('sum(jumlah * harga) as total'))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('detail_pengeluaran_kasses.tglNota','<',$tglaw)->groupBy('nota_pengeluaran_kasses.kodeProyek')->first();
         return $totot['total'];
        }
        else{
            return '0';
        }

    }

    public static function getsaldoawal($tglaw){
        return round(BiayaKas::grantotmasuk($tglaw),4)-round(BiayaKas::grantotkeluar($tglaw),4);
    }

    public static function grantotmasukkas($tglaw,$tglakh){
        
        $jum=DetailNotaKasMasuk::join('nota_kas_masuks','detail_nota_kas_masuks.nonota','=','nota_kas_masuks.nonota')->where('nota_kas_masuks.tglNota','>=',$tglaw)->where('nota_kas_masuks.tglNota','<=',$tglakh)->where('nota_kas_masuks.kodeProyek','=',session()->get('pilihanproyek'))->count();
        if($jum){
            $masuk= DetailNotaKasMasuk::join('nota_kas_masuks','detail_nota_kas_masuks.nonota','=','nota_kas_masuks.nonota')->where('nota_kas_masuks.tglNota','>=',$tglaw)->where('nota_kas_masuks.tglNota','<=',$tglakh)->where('nota_kas_masuks.kodeProyek','=',session()->get('pilihanproyek'))->groupBy('nota_kas_masuks.kodeProyek')->sum('saldo');
            $masuk=round($masuk,4)+round(BiayaKas::getsaldoawal($tglaw),4);
            return $masuk;
        }else{
            return '0';
        }

    }
    public static function grantotkeluarkas($tglaw,$tglakh){
        $jum=DetailPengeluaranKass::select(DB::raw('sum(jumlah * harga) as total'))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('detail_pengeluaran_kasses.tglNota','>=',$tglaw)->where('detail_pengeluaran_kasses.tglNota','<=',$tglakh)->groupBy('nota_pengeluaran_kasses.kodeProyek')->count();
        if($jum){
         $totot= DetailPengeluaranKass::select(DB::raw('sum(jumlah * harga) as total'))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('detail_pengeluaran_kasses.tglNota','>=',$tglaw)->where('detail_pengeluaran_kasses.tglNota','<=',$tglakh)->groupBy('nota_pengeluaran_kasses.kodeProyek')->first();
         return $totot['total'];
        }
        else{
            return '0';
        }

    }

    public static function getsaldoakhir($tglaw,$tglakh){

        return round(BiayaKas::grantotmasukkas($tglaw,$tglakh),4)-round(BiayaKas::grantotkeluarkas($tglaw,$tglakh),4);
    }
    
    public static function getnama($kodeBiayaKas){
        if(substr($kodeBiayaKas, 0, 1) == 2){
            $biayakas=alat::where('kodeAlat','=',$kodeBiayaKas)->first();
        }
        else if(substr($kodeBiayaKas, 0, 1)>2){
            $biayakas=BiayaKas::where('kodeBiayaKas','=',$kodeBiayaKas)->first();
        }else{
            return '';
        }

        // dd($biayakas);
        // print_r($biayakas);
        $nama=$biayakas->nama;

        return $nama;
    }

    public static function tothargasaat($kodebiaya, $tgl, $nonota,$baris){
        if(substr($kodebiaya, 0,1)<=2){
     
        $tothargamasuk= DetailPengeluaranKass::select(DB::raw('jumlah * harga as total'))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat', '=', $kodebiaya)->where('detail_pengeluaran_kasses.tglNota','=',$tgl)->where('detail_pengeluaran_kasses.nonota','=',$nonota)->where('detail_pengeluaran_kasses.noBaris','=',$baris)->first();
            return $tothargamasuk['total'];
           
        }else{
           
            $tothargamasuk= DetailPengeluaranKass::select(DB::raw('jumlah * harga as total'))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas', '=', $kodebiaya)->where('detail_pengeluaran_kasses.tglNota','=',$tgl)->where('detail_pengeluaran_kasses.nonota','=',$nonota)->where('detail_pengeluaran_kasses.noBaris','=',$baris)->first();
            return $tothargamasuk['total'];
           
        }
    } 

}
