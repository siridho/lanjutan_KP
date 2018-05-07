<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\NotaBeliMaterial;
use App\DetailBeliMaterial;
use App\material;
use App\mitraKerja;
use App\proyek;
use Excel;
use DB;
use Illuminate\Http\Request;
use App\MaterialProyek;
use Session;
use Auth;

class NotaBeliMaterialsController extends Controller
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
        $keyword = $request->get('search');
        $perPage = 25;

        $notabelimaterials = NotaBeliMaterial::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
    

        return view('nota-beli-materials.index', compact('notabelimaterials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tgl=date('Y-m-d');
        $materials=material::all();
        $mitras=mitraKerja::all();
        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $kodeproyek=session()->get('pilihanproyek');
        $jum=NotaBeliMaterial::where('nonota','like','%P'.$kodeproyek.'%')->count();
        if($jum==0){
            $kode="P".$kodeproyek."BM001";
        }else{
        $nomm=NotaBeliMaterial::where('nonota','like','%P'.$kodeproyek."%")->orderBy('nonota','DESC')->first();
        $no=substr($nomm->nonota,6);
        $kode="P".$kodeproyek.'BM';
        // $kode=substr($nomm->nonota,0,2);
        $no++;

        if($no<10)
            $kode=$kode."00".$no;
        elseif($no<100)
            $kode=$kode."0".$no;
        else
            $kode=$kode.$no;
        }
        // echo $kode;exit();
        return view('nota-beli-materials.create', compact('materials', 'mitras', 'proyeks','kode','tgl'));
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
        $harsat=$request->get('price');
        $total=$request->get('total');
        $keterangan=$request->get('keterangan');
        $grantot=$request->get('grandTot');
        $requestData = $request->all();
        $status="belum lunas";
        $status_barang="kurang";
        $arr= array();
        $kodeProyek = session()->get('pilihanproyek');
        $nonota="P".$kodeProyek.'BM'.$request->get('nonota');
        // echo $request->get('tglNota');exit();
        $tgl=date_create($request->get('tglNota'));
       //$nota=NotaBeliMaterial::create($requestData);

        $nota=new NotaBeliMaterial( array('nonota' =>$nonota ,
            'id_karyawan'=>auth::user()->id,
            'status'=>$status,
            'status_barang'=>$status_barang,
            'tglNota'=>$tgl,
            'kodeProyek'=>$kodeProyek,
            'validator'=>1,
            'kodeMitra'=> $request->get('kodeMitra'),
            'created_at'=> $request->get('created_at'),
            
            'referensi'=> $request->get('cboreferensi')
            ));
       $nota->save();


        for($i=0;$i<sizeof($qty);$i++){
            $baris=$i+1;
       
            $DetailBeliMaterial= new DetailBeliMaterial(array('nonota'=>$nonota,
                'tglNota'=>$request->get('tglNota'),
                'kode_material'=>$idbarang[$i],
                'noBaris'=>$baris,
                'keterangan'=> $keterangan[$i],
                'harga'=>$harsat[$i],
                'qty'=>$qty[$i],
                'tglNota'=>$tgl
                ));
            $DetailBeliMaterial->save();   

            // array_push($arr,$idbarang[$i]);
            // }
             
        }

        session()->put('success','Data berhasil diinputkan');


        return redirect('nota-beli-materials');
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
        $notabelimaterial = NotaBeliMaterial::where('nonota','=',$id)->first();
        $detailnota=$notabelimaterial->detailnota;
        return view('nota-beli-materials.show', compact('notabelimaterial','detailnota'));
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
        $notabelimaterial = NotaBeliMaterial::where('nonota','=',$id)->first();
        $detailnota=$notabelimaterial->detailnota;
        $mitras=mitraKerja::all();
        $materials=material::all();
        return view('nota-beli-materials.edit', compact('notabelimaterial','detailnota','mitras','materials'));
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
        $idbarang=$request->get('barang');
        $qty=$request->get('qty');
        $harsat=$request->get('price');
        $total=$request->get('total');
        $keterangan=$request->get('keterangan');
        $grantot=$request->get('grandTot');
        //$requestData = $request->all();
        $status="belum lunas";
        $status_barang="kurang";
        $arr= array();
        $kodeProyek = session()->get('pilihanproyek');
        // echo $request->get('tglNota');exit();
        $tgl=date_create($request->get('tglNota'));

        // $nonota="P".$kodeProyek.'BM'.$id;
       


        // echo "string";exit();
        
        // $requestData = $request->all();
        
        $notabelimaterial = NotaBeliMaterial::where('nonota','=',$id)->first();
        $notabelimaterial->id_karyawan=auth::user()->id;
        $notabelimaterial->status=$status;
        $notabelimaterial->status_barang=$status_barang;
        $notabelimaterial->tglNota=$tgl;
        $notabelimaterial->kodeProyek=$kodeProyek;
        $notabelimaterial->kodeMitra=$request->get('kodeMitra');
        $notabelimaterial->referensi=$request->get('cboreferensi');
        $notabelimaterial->save();

        DetailBeliMaterial::where('nonota','=',$id)->delete();
        for($i=0;$i<sizeof($qty);$i++){
            $baris=$i+1;
       
            $DetailBeliMaterial= new DetailBeliMaterial(array('nonota'=>$id,
                'tglNota'=>$request->get('tglNota'),
                'kode_material'=>$idbarang[$i],
                'noBaris'=>$baris,
                'keterangan'=> $keterangan[$i],
                'harga'=>$harsat[$i],
                'qty'=>$qty[$i],
                'tglNota'=>$tgl
                ));
            $DetailBeliMaterial->save();       
        }
        // $notabelimaterial->update($requestData);

        session()->put('success','Data berhasil diubah');

        return redirect('nota-beli-materials');
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
        NotaBeliMaterial::whereNonota($id)->delete();

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

        session()->put('success','Data berhasil dihapus');

        return redirect('nota-beli-materials');
    }

    public function getsatuan($id){
        $material=material::where('kodeMaterial','=',$id)->first();
        echo $material->satuan;
    }

    public function exportcsv(Request $request){
        $name='BE_'.date('YmdHis');
        $tglAwal=date_create($request->get('tglAwal'));
        $tglAkhir=date_create($request->get('tglAkhir'));
        NotaBeliMaterial::where('tglNota','>=',$tglAwal)->where('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->update(['status_nota'=>'valid','validator'=>auth::user()->id,'waktu_valid'=>date('Y-m-d')]);

        $beli=NotaBeliMaterial::where('tglNota','>=',$tglAwal)->orwhere('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();
        $detailBeli=DetailBeliMaterial::where('tglNota','>=',$tglAwal)->orwhere('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();

        // Excel::create($name,function($excel) use ($data){
        //     $excel->sheet('sheet', function($sheet) use ($data){
        //         $sheet->fromArray($data);
        //     });

        return Excel::create($name, function($excel) use ($beli,$detailBeli) {
             // Our first sheet
            $excel->sheet('Beli', function($sheet) use ($beli) {
                $sheet->fromArray($beli);
            });

            // Our second sheet
            $excel->sheet('Detail Beli', function($sheet1) use ($detailBeli) {
                $sheet1->fromArray($detailBeli);
            });
        })->download('xls');
    }

    public function inputulang(){
         $notabelimaterial=NotaBeliMaterial::all();
        foreach ($notabelimaterial as $notabeli) {
            DetailBeliMaterial::where('nonota','=',$notabeli->nonota)->update(['tglNota'=>$notabeli->tglNota]);
        }
    }
}
