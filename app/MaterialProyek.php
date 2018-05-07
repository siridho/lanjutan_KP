<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use session;

class MaterialProyek extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'material_proyeks';

    /**
    * The database primary key value.
    *
    * @var string
    */
    public $incrementing = false;


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['kodeProyek', 'kodeMaterial', 'stok'];

    public function material(){
        return $this->belongsTo('App\material', 'kodeMaterial', 'kodeMaterial');
    }

     public function proyek(){
        return $this->belongsTo('App\proyek', 'kodeProyek', 'kodeProyek');
    }

    public static function totkuantummasuk($kodematerial, $tgl)
    {
        $totkuantummasuk = DetailTerimaBarang::where('kodeProyek','=',session()->get('pilihanproyek'))->where('kode_material', '=', $kodematerial)->where('tglNota','<=',$tgl)->sum('jumlah');

        // $totkuantummasuk = 0;
        // foreach($detailbelimaterials as $detailbelimaterial){
        //     $totkuantummasuk += $detailbelimaterial->qty;
        // }
        return $totkuantummasuk;
    }   

    public static function tothargamasuk($kodematerial, $tgl)
    {
        $jum=DetailTerimaBarang::where('kodeProyek','=',session()->get('pilihanproyek'))->where('kode_material', '=', $kodematerial)->where('tglNota','<=',$tgl)->count();
        if($jum){
        $tothargamasuk= DetailTerimaBarang::select(DB::raw('sum(jumlah * harga) as total'))->where('kodeProyek','=',session()->get('pilihanproyek'))->where('kode_material', '=', $kodematerial)->where('tglNota','<=',$tgl)->first();
        return $tothargamasuk['total'];
        }else{
            return '0';
        }
    }

    public static function totkuantumkeluar($kodematerial, $tgl)
    {
        $totkuantumkeluar = DetailPenggunaanMaterial::join('nota_penggunaan_materials','detail_penggunaan_materials.nonota','=','nota_penggunaan_materials.nonota')->where('nota_penggunaan_materials.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeMaterial', '=', $kodematerial)->where('tglNota','<=',$tgl)->sum('jumlah');
        return $totkuantumkeluar;
    }

    public static function hitungratarata($kodematerial, $tgl){
        $jum=DetailTerimaBarang::where('kodeProyek','=',session()->get('pilihanproyek'))->where('kode_material', '=', $kodematerial)->where('tglNota','<=',$tgl)->count();
        if($jum){
         $totkuantummasuk = MaterialProyek::totkuantummasuk($kodematerial, $tgl);
        
       $tothargamasuk= MaterialProyek::tothargamasuk($kodematerial, $tgl);
        
        return round($tothargamasuk/$totkuantummasuk,4);
        }
        else
        {return '0';}   
    }

    public static function hitungsaldokuantum($kodematerial, $tgl){
         $jum=DetailTerimaBarang::where('kodeProyek','=',session()->get('pilihanproyek'))->where('kode_material', '=', $kodematerial)->where('tglNota','<=',$tgl)->count();
         if($jum){
        $kuantum=round(MaterialProyek::totkuantummasuk($kodematerial, $tgl),4)-round(MaterialProyek::totkuantumkeluar($kodematerial, $tgl),4);
        return $kuantum;
        }else{
            return '0';
        }
    }   
    public static function hitungsaldoharga($kodematerial, $tgl){
         $jum=DetailTerimaBarang::where('kodeProyek','=',session()->get('pilihanproyek'))->where('kode_material', '=', $kodematerial)->where('tglNota','<=',$tgl)->count();
         if($jum){
        $kuantum=round(MaterialProyek::hitungsaldokuantum($kodematerial, $tgl),4)*round(MaterialProyek::hitungratarata($kodematerial, $tgl),4);
        return round($kuantum,0);
        }else{
            return '0';
        }
    }

    public static function tothargakeluar($kodematerial, $tgl)
    {
        
        $totharga= MaterialProyek::totkuantumkeluar($kodematerial,$tgl)*MaterialProyek::hitungratarata($kodematerial,$tgl);
        
        return round($totharga,0);
    }

    public static function  grandtothargamasuk($tgl){
        $tothargamasuk= DetailTerimaBarang::select(DB::raw('sum(jumlah * harga) as total'))->where('kodeProyek','=',session()->get('pilihanproyek'))->where('tglNota','<=',$tgl)->first();
        return $tothargamasuk['total'];
    }

    public static function  grandtothargakeluar($tgl){
       
        $inibanyak=MaterialProyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $totot=0;
        foreach ($inibanyak as $ini) {
            // $totot.=$ini->kodeMaterial.' ';
            $totot+=MaterialProyek::tothargakeluar($ini->kodeMaterial,$tgl);
            //$totot++;
        }
        return $totot;

    }

    public static function grandtotsaldo($tgl){
        $inibanyak=MaterialProyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $totot=0;
        foreach ($inibanyak as $ini) {
            // $totot.=$ini->kodeMaterial.' ';
            $totot+=MaterialProyek::hitungsaldoharga($ini->kodeMaterial,$tgl);
            //$totot++;
        }
        return $totot;
    }

    public static function kuantumperiode($kodematerial,$tglawal,$tglakhir){
        $totkuantumkeluar = DetailPenggunaanMaterial::join('nota_penggunaan_materials','detail_penggunaan_materials.nonota','=','nota_penggunaan_materials.nonota')->where('nota_penggunaan_materials.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeMaterial', '=', $kodematerial)->where('tglNota','>=',$tglawal)->where('tglNota','<=',$tglakhir)->sum('jumlah');
        return $totkuantumkeluar;
    }

    // public static function hitungratarataperiode($kodematerial, $tglawal,$tglakhir){
    //     $jum=DetailTerimaBarang::where('kodeProyek','=',session()->get('pilihanproyek'))->where('kode_material', '=', $kodematerial)->where('tglNota','>=',$tglawal)->where('tglNota','<=',$tglakhir)->count();
    //     if($jum){
    //      $totkuantummasuk = MaterialProyek::totkuantummasukperiode($kodematerial, $tglawal,$tglakhir);
        
    //    $tothargamasuk= MaterialProyek::tothargamasukperiode($kodematerial, $tglawal,$tglakhir);
        
    //     if(!$totkuantummasuk)
    //         $totkuantummasuk=1;
    //    // return round($tothargamasuk/$totkuantummasuk,4);
    //     // return $tothargamasuk."/".$totkuantummasuk;
    //     }
    //     else
    //     {return '0';}
         
    // }

    public static function totkuantummasukperiode($kodematerial, $tglawal,$tglakhir){
        $totkuantummasuk = DetailTerimaBarang::where('kodeProyek','=',session()->get('pilihanproyek'))->where('kode_material', '=', $kodematerial)->where('tglNota','>='.$tglawal)->where('tglNota','<=',$tglakhir)->sum('jumlah');

       
        return $totkuantummasuk;
    }

    public static function tothargamasukperiode($kodematerial, $tglawal,$tglakhir){
        $jum=DetailTerimaBarang::where('kodeProyek','=',session()->get('pilihanproyek'))->where('kode_material', '=', $kodematerial)->where('tglNota','>=',$tglawal)->where('tglNota','<=',$tglakhir)->count();
        if($jum){
        $tothargamasuk= DetailTerimaBarang::select(DB::raw('sum(jumlah * harga) as total'))->where('kodeProyek','=',session()->get('pilihanproyek'))->where('kode_material', '=', $kodematerial)->where('tglNota','>=',$tglawal)->where('tglNota','<=',$tglakhir)->first();
        return $tothargamasuk['total'];
        }else{
            return '0';
        }
    }

    public static function  grandtothargakeluarperiode($tglawal,$tglakhir){
       
        $inibanyak=MaterialProyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $totot=0;
        foreach ($inibanyak as $ini) {
            // $totot.=$ini->kodeMaterial.' ';
            $totot+=MaterialProyek::tothargakeluarperiode($ini->kodeMaterial,$tglawal,$tglakhir);
            //$totot++;
        }
        return $totot;

    }


     public static function tothargakeluarperiode($kodematerial, $tglawal,$tglakhir)
    {
        
       $totharga= MaterialProyek::kuantumperiode($kodematerial,$tglawal,$tglakhir)*MaterialProyek::hitungratarata($kodematerial,$tglakhir);
        return round($totharga,0);

        // return  MaterialProyek::kuantumperiode($kodematerial,$tglawal,$tglakhir)."*(".MaterialProyek::hitungratarataperiode($kodematerial,$tglawal,$tglakhir).")";
    }

    public static function kartuStok($kodematerial){
        $keluar=DB::table('detail_penggunaan_materials')->select(DB::raw("detail_penggunaan_materials.nonota as nonota, detail_penggunaan_materials.tglNota as tglNota"))->join('nota_penggunaan_materials','detail_penggunaan_materials.nonota','=','nota_penggunaan_materials.nonota')->where('kodeMaterial','=',$kodematerial)->where('kodeProyek','=',session()->get('pilihanproyek'));
        $masuk=DB::table('detail_terima_barangs')->select(DB::raw("nonota as nonota,tglNota as tglNota"))->where('kode_material','=',$kodematerial)->where('kodeProyek','=',session()->get('pilihanproyek'));
        $kartu=$keluar->union($masuk)->orderBy('tglNota','ASC')->orderBy('nonota','DESC')->get();
        return $kartu;
    }

    public static function echodetail($nonota,$material){
        // $saldo+=$mater->jumlah;
        // $jum=DetailTerimaBarang::where('nonota','=',$nonota)->where('kode_material','=',$material)->count();
        // if($jum){
        //     $mater=DetailTerimaBarang::where('nonota','=',$material->nonota)->where('kode_material','=',$id)->first();
        //     $echo='<tr>
        //         <td>'.$mater->tglNota.'</td>
        //         <td>'.$kode.'</td>
        //         <td>'.$mater->keterangan.'</td>
        //         <td>'.$mater->jumlah.'</td>
        //         <td></td><td>'.$saldo.'</td>';

        // }else{

        // }
    }
  
}
