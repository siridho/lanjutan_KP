<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class JenisBiayaProyek extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'jenis_biaya_proyeks';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'kodeJenisBiaya';
    public $incrementing = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['kodeJenisBiaya', 'nama', 'satuan'];

    public function material($id){
        //return $this->belongsTo('App\material', 'kode_material', 'kodeMaterial');
        $material=material::where('kodeMaterial','like',$id.'%')->get();
    }
    public static function getsatuan($id){
        $biaya=JenisBiayaProyek::where('kodeJenisBiaya','=',$id)->first();
        return $biaya->satuan;
    }

    public static function  grandtothargamasuk($kodebiaya, $tgl){
        $tothargamasuk= DetailTerimaBarang::select(DB::raw('sum(jumlah * harga) as total'))->where('kode_material','LIKE',$kodebiaya."%")->where('kodeProyek','=',session()->get('pilihanproyek'))->where('tglNota','<=',$tgl)->first();
        return $tothargamasuk['total'];
    }
    public static function  grandtothargakeluar($kodebiaya, $tgl){
       
        $inibanyak=MaterialProyek::where('kodeProyek','=',session()->get('pilihanproyek'))->where('kodeMaterial','LIKE',$kodebiaya."%")->get();
        $totot=0;
        foreach ($inibanyak as $ini) {
            // $totot.=$ini->kodeMaterial.' ';
            $totot+=MaterialProyek::tothargakeluar($ini->kodeMaterial,$tgl);
            //$totot++;
        }
        return $totot;

    }

    public static function grandtotsaldo($kodebiaya, $tgl){
        $inibanyak=MaterialProyek::where('kodeProyek','=',session()->get('pilihanproyek'))->where('kodeMaterial','LIKE',$kodebiaya."%")->get();
        $totot=0;
        foreach ($inibanyak as $ini) {
            // $totot.=$ini->kodeMaterial.' ';
            $totot+=MaterialProyek::hitungsaldoharga($ini->kodeMaterial,$tgl);
            //$totot++;
        }
        return $totot;
    }

    public static function totkeluar($kodebiaya,$tglaw,$tglakh){
        // return $kodebiaya." ".$tglaw.' '.$tglakh;
        if(substr($kodebiaya, 0,1)=='1'){
             $inibanyak=MaterialProyek::where('kodeProyek','=',session()->get('pilihanproyek'))->where('kodeMaterial','LIKE',$kodebiaya."%")->get();
             // return $inibanyak;
         $keluar=0;
        foreach ($inibanyak as $ini) {
            
             // $hargarata= $material_proyek->hitungratarata($ini->kodeMaterial,$tglakh);
        
            $keluar=round($keluar,3)+ round(MaterialProyek::tothargakeluarperiode($ini->kodeMaterial, $tglaw,$tglakh),3);
        }
        // return $totkuantumkeluar;
        }elseif(substr($kodebiaya, 0,1)=='2'){
            $keluar=0;
            $inibanyak=DB::table('detail_pengeluaran_kasses')->select(DB::raw("alats.satuan as satuan,alats.nama as nama,detail_pengeluaran_kasses.kodeAlat as kode"))->join('alats','alats.kodeAlat','=','detail_pengeluaran_kasses.kodeAlat')->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas',null)->where('alats.kodeAlat','like',$kodebiaya.'%')->distinct('kode')->get();
            foreach ($inibanyak as $ini) {
                // exit();
                // $keluar.= $ini->kodeAlat." ".$tglaw.' '.$tglakh."<br>";
               $keluar+=BiayaKas::tothargaperiode($ini->kode, $tglaw,$tglakh);
            }
        }else{
            $keluar=0;
            $inibanyak=BiayaKas::where('kodeBiayaKas','LIKE',$kodebiaya."%")->get();
            foreach ($inibanyak as $ini) {
                $keluar+=BiayaKas::tothargaperiode($ini->kodeBiayaKas, $tglaw,$tglakh);
            }
        }

        return $keluar;
                
    }
    

    
    public static function totkeluarsaat($kodebiaya,$tgl){
        // $tgl=date('Y-m-d',strtotime($tgl . " - 1 day"));
        if(substr($kodebiaya, 0,1)==1){
        $inibanyak=MaterialProyek::where('kodeProyek','=',session()->get('pilihanproyek'))->where('kodeMaterial','LIKE',$kodebiaya."%")->get();

         $keluar=0;
        foreach ($inibanyak as $ini) {
            // $totot.=$ini->kodeMaterial.' ';
            $keluar=round($keluar,3)+ round(MaterialProyek::tothargakeluar($ini->kodeMaterial,$tgl),3);
            //$totot++;
        }
         
        //$keluar=MaterialProyek::tothargakeluarperiode($kodebiaya, $tglawal,$tglakhir);
        }elseif(substr($kodebiaya, 0,1)=='2'){
            $keluar=0;
           $inibanyak=DB::table('detail_pengeluaran_kasses')->select(DB::raw("alats.satuan as satuan,alats.nama as nama,detail_pengeluaran_kasses.kodeAlat as kode"))->join('alats','alats.kodeAlat','=','detail_pengeluaran_kasses.kodeAlat')->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas',null)->where('alats.kodeAlat','like',$kodebiaya.'%')->distinct('kode')->get();
            foreach ($inibanyak as $ini) {

                $keluar+=BiayaKas::totharga($ini->kode, $tgl);
            }

        }else{
            $keluar=0;
           $inibanyak=DB::table('detail_pengeluaran_kasses')->select(DB::raw("biaya_kas.satuan as satuan,biaya_kas.nama as nama,detail_pengeluaran_kasses.kodeBiayaKas as kode"))->join('biaya_kas','detail_pengeluaran_kasses.kodeBiayaKas','=','biaya_kas.kodeBiayaKas')->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat',null)->where('biaya_kas.kodeBiayaKas','like',$kodebiaya.'%')->distinct('kode')->get();
            foreach ($inibanyak as $ini) {
                $keluar+=BiayaKas::totharga($ini->kode, $tgl);
            }
        }


        return $keluar;        
    }

    public static function grandtotkeluarsaat($kodebiaya,$tgl){
        $kodebiaya=substr($kodebiaya, 0,1);
        // echo $kodebiaya;exit();
        $listkode=JenisBiayaProyek::where('kodeJenisBiaya','LIKE',$kodebiaya.'%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $keluar=0;
        foreach ($listkode as $kode) {

            $keluar+=JenisBiayaProyek::totkeluarsaat($kode->kodeJenisBiaya,$tgl);
        }
        return $keluar;
    }

    public static function grandtotkeluar($kodebiaya,$tglaw,$tglakh){
        $kodebiaya=substr($kodebiaya, 0,1);
         $listkode=JenisBiayaProyek::where('kodeJenisBiaya','LIKE',$kodebiaya.'%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $keluar=0;
        foreach ($listkode as $kode) {
            $keluar+=JenisBiayaProyek::totkeluar($kode->kodeJenisBiaya,$tglaw,$tglakh);
        }
        return $keluar;
    }

    public static function totbiayakeluarsaat($tgl){
        $keluar=0;
        for ($i=1;$i<=5;$i++) {
            $listkode=JenisBiayaProyek::where('kodeJenisBiaya','LIKE',$i.'%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
            foreach ($listkode as $kode) {
                $keluar+=JenisBiayaProyek::totkeluarsaat($kode->kodeJenisBiaya,$tgl);
            }
        }
        return $keluar;
    }

    public static function totbiayakeluar($tglaw,$tglakh){
        $keluar=0;
        for ($i=1;$i<=5;$i++) {
            $listkode=JenisBiayaProyek::where('kodeJenisBiaya','LIKE',$i.'%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
            foreach ($listkode as $kode) {
                $keluar+=JenisBiayaProyek::totkeluar($kode->kodeJenisBiaya,$tglaw,$tglakh);
            }   
        }
        return $keluar;   
    }

    
}
