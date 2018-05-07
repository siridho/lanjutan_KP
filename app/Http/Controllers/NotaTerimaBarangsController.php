<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\NotaBeliMaterial;
use App\DetailBeliMaterial;
use App\NotaTerimaBarang;
use App\DetailTerimaBarang;
use App\material;
use App\proyek;
use App\gudang;
use App\mitraKerja;
use Excel;
use Illuminate\Http\Request;
use Session;
use App\MaterialProyek;
use DB;
use auth;

class NotaTerimaBarangsController extends Controller
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
     
        $notaterimabarangs  = NotaTerimaBarang::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
        

        return view('nota-terima-barangs.index', compact('notaterimabarangs'));
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
        // $gudangs=gudang::all();
        $notabeli=NotaBeliMaterial::where('status_nota','!=','valid')->get();

        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $kodeproyek=session()->get('pilihanproyek');
        $jum=NotaTerimaBarang::where('nonota','like','%P'.$kodeproyek.'%')->count();
        if($jum==0){
            $kode="P".$kodeproyek."TB001";
        }else{
        $nomm=NotaTerimaBarang::where('nonota','like','%P'.$kodeproyek."%")->orderBy('nonota','DESC')->first();
        $no=substr($nomm->nonota,6);
        $kode="P".$kodeproyek.'TB';
        // $kode=substr($nomm->nonota,0,2);
        $no++;

        if($no<10)
            $kode=$kode."00".$no;
        elseif($no<100)
            $kode=$kode."0".$no;
        else
            $kode=$kode.$no;
        }
        return view('nota-terima-barangs.create', compact('materials', 'mitras','notabeli','proyeks','kode','tgl'));
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
        
        $requestData = $request->all();
        
        // NotaPengeluaranKass::create($requestData);

        $keterangan=$request->get('keterangan');
        $qty=$request->get('qty');
        $kode=$request->get('kode');
        $kodemitra=$request->get('price');
        $barang=$request->get('barang');
        $barisbeli=$request->get('barisbeli');
        // $grantot=$request->get('grandTot');
        // $requestData = $request->all();
        // $kodeProyek=$request->get('kodeMitra');
        // echo $kodeProyek;
        // exit();
        $status="menunggu";
        
        // $barangg = MaterialGudang::where('kodeMaterial', '=', $barang[0])->where('kodeGudang','=',$request->get('kodeGudang'))->count();
        // echo $barangg;
        // exit();
        $kodeProyek = session()->get('pilihanproyek');
        $nonota="P".$kodeproyek.'TB'.$request->get('nonota');
        // echo $kodeProyek;exit();

        $nota=new NotaTerimaBarang( array('nonota' =>$nonota ,
            'id_karyawan'=>auth::user()->id,
            'status'=>$status,
            'kodeProyek'=>$kodeProyek,
            // 'nonota_beli'=>$request->get('cboreferensi')
            'tglNota'=>date_create($request->get('tglNota')),
            'validator'=>auth::user()->id,
            'kodeMitra'=>$request->get('kodeMitra'),
            'referensi'=>$request->get('referensi'),
            'nonota_beli'=> $request->get('notabeli')
            ));
       $nota->save();


        for($i=0;$i<sizeof($qty);$i++){
            $baris=$i+1;
            $bb=DetailBeliMaterial::where('nonota','=',$request->get('notabeli'))->where('kode_material','=',$barang[$i])->where('noBaris','=',$barisbeli[$i])->first();
            $DetailTerimaBarang= new DetailTerimaBarang(array('nonota'=>$nonota,
                'kodeProyek'=>$kodeProyek,
                'kode_material'=>$barang[$i],
                'jumlah'=>$qty[$i],
                'noBaris'=>$baris,
                'baris_detail_beli'=>$barisbeli[$i],
                'keterangan'=>$keterangan[$i],
                'harga'=>$bb->harga,
                'tglNota'=>date_create($request->get('tglNota'))
                ));
            $DetailTerimaBarang->save();   

            //ambil data barang
            $barangg = MaterialProyek::where('kodeMaterial', '=', $barang[$i])->where('kodeProyek','=',$kodeProyek)->count();



            if($barangg==0){
                $materialproyek=new MaterialProyek(array('kodeProyek' => $kodeProyek, 
                    'kodeMaterial' => $barang[$i],
                    'stok'=>$qty[$i]
                    ));
                $materialproyek->save();
            }else{
                $detbar = MaterialProyek::where('kodeMaterial', '=', $barang[$i])->where('kodeProyek','=',$kodeProyek)->first();
                $jummasuk=MaterialProyek::totkuantummasuk($barang[$i],date('Y-m-d'));
                $jumkeluar=MaterialProyek::totkuantumkeluar($barang[$i],date('Y-m-d'));
                $stokbaru=round($jummasuk,3)-round($jumkeluar,3);
                MaterialProyek::where('kodeMaterial', '=', $barang[$i])->where('kodeProyek','=',$kodeProyek)->update(['stok'=>$stokbaru]);
            }
            
            $detailbeli=DetailBeliMaterial::where('nonota','=',$request->get('notabeli'))->where('kode_material','=',$barang[$i])->first();
            $notterima=NotaTerimaBarang::where('nonota_beli','=',$request->get('notabeli'))->get();
            $jumitu=0;$i3=0;
            foreach ($notterima as $terima) {
                $i3++;

                $detailnota=DetailTerimaBarang::where('nonota','=',$terima->nonota)->where('kode_material','=',$barang[$i])->first();
                // if($i3==2)
                // echo $terima->nonota." ".$barang[$i];exit();
                 // if($detailnota)   
                $jumitu+=$detailnota->jumlah;
            }

            if($jumitu>=$detailbeli->qty){
                $status="lengkap";
                $semnotaterima=NotaTerimaBarang::where('nonota_beli','=',$request->get('notabeli'))->update(['status'=>$status]);
                NotaBeliMaterial::where('nonota','=',$request->get('notabeli'))->update(['status_barang'=>$status]);
            }            
            // //cek harga beli, kalo beda dgn harga jual hitung average
            // if($barangg->hargabeli != $harsat[$i]){
            //     $hargaaverage = (($barangg->stokriil * $barangg->hargabeli)+($qty[$i] * $harsat[$i])) / ($barangg->stokriil + $qty[$i]);
            //     $barangg->hargabeli = $hargaaverage;
            // }

            // //update stok di tabel barang
            // $stokriil = $barangg->stokriil;
            // $stokriil += $qty[$i];

            // $barangg->stokriil = $stokriil;
            // $barangg->save(); 
        }

        session()->put('success','Data berhasil diinputkan');

        return redirect('nota-terima-barangs/'.$request->get('nonota'));
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
        $notaterimabarang = NotaTerimaBarang::where('nonota','=',$id)->first();
        $detailnota=$notaterimabarang->detailterima;
       
        // print_r($detailnota);
        // exit();

        return view('nota-terima-barangs.show', compact('notaterimabarang', 'detailnota'));
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
        $notaterimabarang = NotaTerimaBarang::where('nonota','=',$id)->first();

        $detailnota=$notaterimabarang->detailterima;

        $materials=material::all();
        $mitras=mitraKerja::all();
        // $gudangs=gudang::all();
        $notabeli=NotaBeliMaterial::all();

        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();

        return view('nota-terima-barangs.edit', compact('notaterimabarang', 'detailnota','mitras','materials','notabeli','proyeks'));
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
     
        $keterangan=$request->get('keterangan');
        $qty=$request->get('qty');
        $kode=$request->get('kode');
        $kodemitra=$request->get('price');
        $barang=$request->get('barang');
        $barisbeli=$request->get('barisbeli');
        
        $status="menunggu";
        
        $kodeProyek = session()->get('pilihanproyek');
        
        $requestData = $request->all();
        
        $notapengeluarankass = NotaTerimaBarang::where('nonota','=',$id)->update([ 'id_karyawan'=>auth::user()->id,
            'status'=>$status,
            'kodeProyek'=>$kodeProyek,
            // 'nonota_beli'=>$request->get('cboreferensi')
            'tglNota'=>date_create($request->get('tglNota')),
            'validator'=>auth::user()->id,
            'kodeMitra'=>$request->get('kodeMitra'),
            'referensi'=>$request->get('referensi'),
            'nonota_beli'=> $request->get('notabeli')
            ]);
        // $notapengeluarankass->update($requestData);

        DetailTerimaBarang::where('nonota','=',$id)->delete();

        for($i=0;$i<sizeof($qty);$i++){
            $baris=$i+1;
            $bb=DetailBeliMaterial::where('nonota','=',$request->get('notabeli'))->where('kode_material','=',$barang[$i])->where('noBaris','=',$barisbeli[$i])->first();
            // echo $request->get('notabeli').' '.$barang[$i].' '.$barisbeli[$i];
            // print_r($bb); exit();

            $DetailTerimaBarang= new DetailTerimaBarang(array('nonota'=>$id,
                'kodeProyek'=>$kodeProyek,
                'kode_material'=>$barang[$i],
                'jumlah'=>$qty[$i],
                'noBaris'=>$baris,
                'baris_detail_beli'=>$barisbeli[$i],
                'keterangan'=>$keterangan[$i],
                'harga'=>$bb->harga,
                'tglNota'=>date_create($request->get('tglNota'))
                ));
            $DetailTerimaBarang->save();   

            //ambil data barang
            $barangg = MaterialProyek::where('kodeMaterial', '=', $barang[$i])->where('kodeProyek','=',$kodeProyek)->count();



            if($barangg==0){
                $materialproyek=new MaterialProyek(array('kodeProyek' => $kodeProyek, 
                    'kodeMaterial' => $barang[$i],
                    'stok'=>$qty[$i]
                    ));
                $materialproyek->save();
            }else{
                $detbar = MaterialProyek::where('kodeMaterial', '=', $barang[$i])->where('kodeProyek','=',$kodeProyek)->first();
                $jummasuk=MaterialProyek::totkuantummasuk($barang[$i],date('Y-m-d'));
                $jumkeluar=MaterialProyek::totkuantumkeluar($barang[$i],date('Y-m-d'));
                $stokbaru=round($jummasuk,3)-round($jumkeluar,3);
                MaterialProyek::where('kodeMaterial', '=', $barang[$i])->where('kodeProyek','=',$kodeProyek)->update(['stok'=>$stokbaru]);
            }
            
            $detailbeli=DetailBeliMaterial::where('nonota','=',$request->get('notabeli'))->where('kode_material','=',$barang[$i])->first();
            $notterima=NotaTerimaBarang::where('nonota_beli','=',$request->get('notabeli'))->get();
            $jumitu=0;$i3=0;
            foreach ($notterima as $terima) {
                $i3++;

                $detailnota=DetailTerimaBarang::where('nonota','=',$terima->nonota)->where('kode_material','=',$barang[$i])->first();
                // if($i3==2)
                // echo $terima->nonota." ".$barang[$i];exit();
                 // if($detailnota)   
                $jumitu+=$detailnota->jumlah;
            }

            if($jumitu>=$detailbeli->qty){
                $status="lengkap";
                $semnotaterima=NotaTerimaBarang::where('nonota_beli','=',$request->get('notabeli'))->update(['status'=>$status]);
                NotaBeliMaterial::where('nonota','=',$request->get('notabeli'))->update(['status_barang'=>$status]);
            }            
            // //cek harga beli, kalo beda dgn harga jual hitung average
            // if($barangg->hargabeli != $harsat[$i]){
            //     $hargaaverage = (($barangg->stokriil * $barangg->hargabeli)+($qty[$i] * $harsat[$i])) / ($barangg->stokriil + $qty[$i]);
            //     $barangg->hargabeli = $hargaaverage;
            // }

            // //update stok di tabel barang
            // $stokriil = $barangg->stokriil;
            // $stokriil += $qty[$i];

            // $barangg->stokriil = $stokriil;
            // $barangg->save(); 
        }

      session()->put('success','Data berhasil diubah');

        return redirect('nota-terima-barangs');
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
        NotaTerimaBarang::whereNonota($id)->delete();

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
        return redirect('nota-terima-barangs');
    }

    public function loaddetail($id){
        $notabeli=NotaBeliMaterial::find($id);

        $barangs=DetailBeliMaterial::where('nonota','=',$id)->get();
        // print_r($barangs);
        // exit();

        // print_r($barangs);
        // exit();
        $data='';
        $no=1;
        $jjj=0;
        $sisa=0;
        foreach ($barangs as $item) {
            $jjj++;
            // echo $item->kode_material.' ';

        // $mmm=DetailTerimaBarang::where('kode_material','=',$item->kode_material)->count();
        // print_r($mmm);
        // exit();

            

            $jumitu=0;
            $noterima=NotaTerimaBarang::where('nonota_beli','=',$id)->get();
            // $aaa=$noterima->detailterima;
            // print_r($noterima);
            // exit();
            foreach ($noterima as $ii) {
                
                $detter=DetailTerimaBarang::where('nonota','=',$ii->nonota)->where('kode_material','=',$item->kode_material)->where('baris_detail_beli','=',$item->noBaris)->sum('jumlah');
                $jum=DetailTerimaBarang::where('nonota','=',$ii->nonota)->where('kode_material','=',$item->kode_material)->where('baris_detail_beli','=',$item->noBaris)->count();
                 // echo $ii->nonota.' ';
                $noo=0;
                // foreach ($detter as $dett) {
                    // $jumitu+=$dett->jumlah;


                    $jumitu=$detter;
                // }
                    
            }
              //echo $id.' '. $jumitu;
             //exit();
            // $notaterima
            $sisa=$item->qty;
            $sisa=$sisa-$jumitu;
            // echo $detter.' ';
            if($sisa>0){
                $data.="<tr id='no".$no."'>
                <td width='40%'>
                    <select id='barang".$no."' name='barang[]' class='form-control'>
                     <option value='". $item->kode_material ."' selected> (". $item->kode_material .") ".$item->material->nama."</option>
                    </select>
                </td>
                <td width='20%'><input type='hidden' name='barisbeli[]' value='".$item->noBaris."'><input type='number' name='qty[]' class='qty form-control' step='any' id='qty".$no."' min='0' value='1' ></td>
                <td width='5%'>".$item->material->satuan."</td>
                <td width='30%'><textarea name='keterangan[]' rows='2' style='resize:none;' class='keterangan form-control' id='keterangan".$no."'>".$item->keterangan."</textarea></td>
                <td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='".$no."'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>
                </tr>";
            }
            
            $no++;
        }

        echo $data;
    }


    public function loadmitra($id){
        $notabeli=NotaBeliMaterial::find($id);

        echo "<option value='".$notabeli->kodeMitra."'>".$notabeli->mitra->nama."</option>";        
    }

    public function loadtgl($id){
        $notabeli=NotaBeliMaterial::find($id);
        echo $notabeli->tglNota;
        //echo "<option value='".$notabeli->kodeMitra."'>".$notabeli->mitra->nama."</option>";        
    }

    function exportcsv(Request $request){
        $detaill=array();
        $detailtb=array();
        $detail=array();
        $name='TB_'.date('YmdHis');
        $tglAwal=date_create($request->get('tglAwal'));
        $tglAkhir=date_create($request->get('tglAkhir'));
        NotaTerimaBarang::where('tglNota','>=',$tglAwal)->where('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->update(['status_nota'=>'valid','validator'=>auth::user()->id,'waktu_valid'=>date('Y-m-d')]);

        $tb=NotaTerimaBarang::where('tglNota','>=',$tglAwal)->orWhere('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();
        $detailtb=DetailTerimaBarang::where('tglNota','>=',$tglAwal)->orWhere('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();
        // $nota=NotaTerimaBarang::where('tglNota','>=',$tglAwal)->orWhere('tglNota','<=',$tglAkhir)->get();   
        // $tb=NotaTerimaBarang::where('tglNota','>=',$tglAwal)->orWhere('tglNota','<=',$tglAkhir)->get()->toArray();
        // foreach ($nota as $item) {
        //     $detail=$item->detailterima->toArray();
        //     array_push($detailtb, $detail);
        // }
        // $detailtb=$detaill->toArray();
        // print_r($detailtb);exit();
       
        //print_r($detailtb);exit();
        // Excel::create($name,function($excel) use ($data){
        //     $excel->sheet('sheet', function($sheet) use ($data){
        //         $sheet->fromArray($data);
        //     });

        return Excel::create($name, function($excel) use ($tb,$detailtb) {
             // Our first sheet
            $excel->sheet('Terima Barang', function($sheet) use ($tb) {
                $sheet->fromArray($tb);
            });

            // Our second sheet
            $excel->sheet('Detail Terima Barang', function($sheet1) use ($detailtb) {
                // foreach ($detailtb as $item) {
                    // $sheet1->fromArray($item);
                // }
                $sheet1->fromArray($detailtb);
            });
        })->download('xls');
    }

   public function itungstok(){
        $detailnota=DetailTerimaBarang::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $kodeProyek=session()->get('pilihanproyek');
        // print_r($detailnota);
        foreach ($detailnota as $item) {   
            
            $barangg = MaterialProyek::where('kodeMaterial', '=', $item->kode_material)->where('kodeProyek','=',$kodeProyek)->count();
            
            if($barangg==0){
                $materialproyek=new MaterialProyek(array('kodeProyek' => $kodeProyek, 
                    'kodeMaterial' => $item->kode_material,
                    'stok'=>0
                    ));
                $materialproyek->save();
                $jummasuk=MaterialProyek::totkuantummasuk($item->kodeMaterial,date('Y-m-d'));
                $jumkeluar=MaterialProyek::totkuantumkeluar($item->kodeMaterial,date('Y-m-d'));
                $stok=round($jummasuk,3)-round($jumkeluar,3);
                MaterialProyek::where('kodeMaterial', '=', $item->kodeMaterial)->where('kodeProyek','=',session()->get('pilihanproyek'))->update(['stok'=>$stok]);   
            }
            else{
                $jummasuk=MaterialProyek::totkuantummasuk($item->kodeMaterial,date('Y-m-d'));
                $jumkeluar=MaterialProyek::totkuantumkeluar($item->kodeMaterial,date('Y-m-d'));
                $stok=round($jummasuk,3)-round($jumkeluar,3);
                MaterialProyek::where('kodeMaterial', '=', $item->kodeMaterial)->where('kodeProyek','=',session()->get('pilihanproyek'))->update(['stok'=>$stok]);
            }
        }
        session()->put('success','Data Berhasil Diinputkan');
        return redirect('imporPusat');
    }

    public function inputulang(){
        $notabelimaterial=NotaBeliMaterial::all();
        foreach ($notabelimaterial as $notabeli) {
            $barangs=DetailBeliMaterial::where('nonota','=',$notabeli->nonota)->get();
            foreach ($barangs as $barang) {
                # code...
                 $noterima=NotaTerimaBarang::where('nonota_beli','=',$notabeli->nonota)->get();
                 foreach ($noterima as $ii) {
                    
                    $detter=DetailTerimaBarang::where('nonota','=',$ii->nonota)->where('kode_material','=',$barang->kode_material)->where('baris_detail_beli','=',$barang->noBaris)->update(['harga'=>$barang->harga,'tglNota'=>$ii->tglNota]);
                        
                }
            }
           
        }
    }



}
