<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\NotaBeliMaterial;
use App\DetailBeliMaterial;
use App\NotaTerimaBarang;
use App\DetailTerimaBarang;
use App\NotaPenggunaanMaterial;
use App\DetailPenggunaanMaterial;
use App\gudang;
use App\proyek;
use App\material;
use App\MaterialProyek;
use Excel;
use Illuminate\Http\Request;
use Session;
use Auth;

class NotaPenggunaanMaterialsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $notapenggunaanmaterials = NotaPenggunaanMaterial::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
        

        return view('nota-penggunaan-materials.index', compact('notapenggunaanmaterials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tgl=date('Y-m-d');
        $materialproyeks=MaterialProyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();

        $jummaterial=MaterialProyek::where('kodeProyek','=',session()->get('pilihanproyek'))->where('stok','!=','0')->count();
        

        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $kodeproyek=session()->get('pilihanproyek');
        $jum=NotaPenggunaanMaterial::where('nonota','like','%P'.$kodeproyek.'%')->count();
        if($jum==0){
            $kode="P".$kodeproyek."PM001";
        }else{
        $nomm=NotaPenggunaanMaterial::where('nonota','like','%P'.$kodeproyek."%")->orderBy('nonota','DESC')->first();
        $no=substr($nomm->nonota,6);
        $kode="P".$kodeproyek."PM";
        // $kode=substr($nomm->nonota,0,2);
        $no++;

        if($no<10)
            $kode=$kode."00".$no;
        elseif($no<100)
            $kode=$kode."0".$no;
        else
            $kode=$kode.$no;
        }
        return view('nota-penggunaan-materials.create',compact('materialproyeks', 'kode', 'proyeks', 'tgl', 'jummaterial'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $idbarang=$request->get('barang');
        $qty=$request->get('qty');
        $nonota=$request->get('nonota');
        $keterangan=$request->get('keterangan');
        $tglNota=date_create($request->get('tglNota'));
        $cboreferensi=$request->get('cboreferensi');
        $cboProyek=session()->get('pilihanproyek');
        // $cboGudang=$request->get('cboGudang');
        $requestData = $request->all();
        $status = "menunggu";
        $nonota="P".$cboProyek."PM".$request->get('nonota'); 
        
        // NotaPenggunaanMaterial::create($requestData);

        $nota=new NotaPenggunaanMaterial( array('nonota' =>$nonota ,
            'id_karyawan'=>auth::user()->id,
            // 'kodeGudang'=>$cboGudang,
            'kodeProyek'=>$cboProyek,
            'tanggalNota'=>$tglNota,
            'referensi'=>$cboreferensi,
            // 'keterangan'=>$keterangan,
            'status_nota'=>$status,
            'validator'=>1,
            'created_at'=> $request->get('created_at')
            ));
        $nota->save();

        for($i=0;$i<sizeof($qty);$i++){
            $baris=$i+1;
            $DetailPenggunaanMaterial= new DetailPenggunaanMaterial(array('nonota'=>$nonota,
                'kodeMaterial'=>$idbarang[$i],
                'keterangan'=>$keterangan[$i],
                'jumlah'=>$qty[$i],
                'tglNota'=>$tglNota,
                'noBaris'=>$baris
                ));
            $DetailPenggunaanMaterial->save();
            $barangg = MaterialProyek::where('kodeMaterial', '=', $idbarang[$i])->where('kodeProyek','=',$cboProyek)->first();
            
            $stok=round($barangg->stok,3) -round($qty[$i],3);
            MaterialProyek::where('kodeMaterial', '=', $idbarang[$i])->where('kodeProyek','=',$cboProyek)->update(['stok'=>$stok]);
        }

      session()->put('success','Data berhasil diinputkan');

        return redirect('nota-penggunaan-materials');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $notapenggunaanmaterial = NotaPenggunaanMaterial::where('nonota', '=', $id)->first();
        $detailnota=$notapenggunaanmaterial->detailnota;
        return view('nota-penggunaan-materials.show', compact('notapenggunaanmaterial', 'detailnota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $tgl=date('Y-m-d');
        $materialproyeks=MaterialProyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();

        $jummaterial=MaterialProyek::where('kodeProyek','=',session()->get('pilihanproyek'))->where('stok','!=','0')->count();
        

        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $kodeproyek=session()->get('pilihanproyek');
        $notapenggunaanmaterial = NotaPenggunaanMaterial::where('nonota','=',$id)->first();
        $detailnota=$notapenggunaanmaterial->detailnota;

        return view('nota-penggunaan-materials.edit', compact('notapenggunaanmaterial','detailnota','proyeks','materialproyeks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        // $requestData = $request->all();

        $idbarang=$request->get('barang');
        $qty=$request->get('qty');
        $nonota=$request->get('nonota');
        $keterangan=$request->get('keterangan');
        $tglNota=date_create($request->get('tglNota'));
        $cboreferensi=$request->get('cboreferensi');
        $cboProyek=session()->get('pilihanproyek');
        // $cboGudang=$request->get('cboGudang');
        $requestData = $request->all();
        $status = "menunggu";
        
        
        $notapenggunaanmaterial = NotaPenggunaanMaterial::whereNonota($id)->first();
        $notapenggunaanmaterial->update(['id_karyawan'=>auth::user()->id,
            // 'kodeGudang'=>$cboGudang,
            'kodeProyek'=>$cboProyek,
            'tanggalNota'=>$tglNota,
            'referensi'=>$cboreferensi,
            // 'keterangan'=>$keterangan,
            'status_nota'=>$status,
            'validator'=>1
            ]);

        DetailPenggunaanMaterial::whereNonota($id)->delete();

        for($i=0;$i<sizeof($qty);$i++){
            $baris=$i+1;
            $DetailPenggunaanMaterial= new DetailPenggunaanMaterial(array('nonota'=>$id,
                'kodeMaterial'=>$idbarang[$i],
                'keterangan'=>$keterangan[$i],
                'jumlah'=>$qty[$i],
                'tglNota'=>$tglNota,
                'noBaris'=>$baris
                ));
            $DetailPenggunaanMaterial->save();
            $jummasuk=MaterialProyek::totkuantummasuk($idbarang[$i],date('Y-m-d'));
            $jumkeluar=MaterialProyek::totkuantumkeluar($idbarang[$i],date('Y-m-d'));
            $stok=round($jummasuk,3)-round($jumkeluar,3);
            MaterialProyek::where('kodeMaterial', '=', $idbarang[$i])->where('kodeProyek','=',$cboProyek)->update(['stok'=>$stok]);
        }

       session()->put('success','Data berhasil diubah');
        return redirect('nota-penggunaan-materials');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        NotaPenggunaanMaterial::whereNonota($id)->delete();
        
        $materials=MaterialProyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        foreach ($materials as $item) {   
            $jummasuk=MaterialProyek::totkuantummasuk($item->kodeMaterial,date('Y-m-d'));
            $jumkeluar=MaterialProyek::totkuantumkeluar($item->kodeMaterial,date('Y-m-d'));
            $stok=round($jummasuk,3)-round($jumkeluar,3);
            MaterialProyek::where('kodeMaterial', '=', $item->kodeMaterial)->where('kodeProyek','=',session()->get('pilihanproyek'))->update(['stok'=>$stok]);
        }

       session()->put('success','Data berhasil dihapus');

        return redirect('nota-penggunaan-materials');
    }

    public function setjumlah($id){
        $materialproyeks=MaterialProyek::where('kodeProyek','=',session()->get('pilihanproyek'))->where('kodeMaterial','=',$id)->first();
        echo $materialproyeks->stok;
    }

    public function exportcsv(Request $request){
        $name='PM_'.date('YmdHis');
        $tglAwal=date_create($request->get('tglAwal'));
        $tglAkhir=date_create($request->get('tglAkhir'));

        NotaPenggunaanMaterial::where('tglNota','>=',$tglAwal)->where('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->update(['status_nota'=>'valid','validator'=>auth::user()->id,'waktu_valid'=>date('Y-m-d')]);

        $pm=NotaPenggunaanMaterial::where('tanggalNota','>=',$tglAwal)->orWhere('tanggalNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();
        $detailpm=DetailPenggunaanMaterial::where('tglNota','>=',$tglAwal)->orWhere('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();

        // Excel::create($name,function($excel) use ($data){
        //     $excel->sheet('sheet', function($sheet) use ($data){
        //         $sheet->fromArray($data);
        //     });

        return Excel::create($name, function($excel) use ($pm,$detailpm) {
             // Our first sheet
            $excel->sheet('Penggunaan Material', function($sheet) use ($pm) {
                $sheet->fromArray($pm);
            });

            // Our second sheet
            $excel->sheet('Detail Penggunaan Material', function($sheet1) use ($detailpm) {
                $sheet1->fromArray($detailpm);
            });
        })->download('xls');
    }

    public function itungstok(){
        
        $kodeProyek=session()->get('pilihanproyek');
        $materials=MaterialProyek::where('kodeProyek','=',$kodeProyek)->get();
        // print_r($detailnota);
        $ii=1;
        foreach ($materials as $item) {   
           
           $jummasuk=MaterialProyek::totkuantummasuk($item->kodeMaterial,date('Y-m-d'));
            $jumkeluar=MaterialProyek::totkuantumkeluar($item->kodeMaterial,date('Y-m-d'));
            $stok=round($jummasuk,3)-round($jumkeluar,3);
            MaterialProyek::where('kodeMaterial', '=', $item->kodeMaterial)->where('kodeProyek','=',session()->get('pilihanproyek'))->update(['stok'=>$stok]);
          
        }
    }

    public function inputulang(){
        $detailterima=DetailTerimaBarang::distinct('kode_material')->get();
        // print_r($detailterima);exit();
        // $i=0;
        // foreach ($detailterima as $det) {

        //     $sumharga=DetailTerimaBarang::where('kode_material','=',$det->kode_material)->sum('harga');
        //     $sumjum=DetailTerimaBarang::where('kode_material','=',$det->kode_material)->sum('jumlah');
        //     $harga=round($sumharga/$sumjum,4);
        //      if(!$i)
        //         echo $harga.'*'.$sumjum."=". round($harga*$sumjum);

        //     $i++;
        //     DetailPenggunaanMaterial::where('kodeMaterial','=',$det->kode_material)->update(['harga'=>$harga]);
        // }
        $notapenggunaan=NotaPenggunaanMaterial::all();
        foreach ($notapenggunaan as $nota) {
           DetailPenggunaanMaterial::where('nonota','=',$nota->nonota)->update(['tglNota'=>$nota->tanggalNota]);
        }
    }


}
