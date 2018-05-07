<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\NotaKasMasuk;
use App\NotaPengeluaranKass;
use App\NotaBeliMaterial;
use App\DetailNotaKasMasuk;
use App\material;
use App\mitraKerja;
use DB;
use Excel;
use App\proyek;
use Illuminate\Http\Request;
use Session;
use auth;

class NotaKasMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        $notakasmasuk = NotaKasMasuk::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
        

        return view('nota-kas-masuk.index', compact('notakasmasuk'));
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
        $jum=NotaKasMasuk::where('nonota','like','%P'.$kodeproyek.'%')->count();
        if($jum==0){
            $kode="P".$kodeproyek."KM001";
        }else{
        $nomm=NotaKasMasuk::where('nonota','like','%P'.$kodeproyek."%")->orderBy('nonota','DESC')->first();
        $no=substr($nomm->nonota,6);
        $kode='P'.$kodeproyek.'KM';
        // $kode=substr($nomm->nonota,0,2);
        $no++;

        if($no<10)
            $kode=$kode."00".$no;
        elseif($no<100)
            $kode=$kode."0".$no;
        else
            $kode=$kode.$no;
        }

        return view('nota-kas-masuk.create', compact('materials', 'mitras','proyeks','kode','tgl'));
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
        $uraian=$request->get('uraian');
        $harsat=$request->get('price');
        $status="menunggu";
        $kodeProyek = session()->get('pilihanproyek');
    
        $nota=new NotaKasMasuk( array('nonota' =>$request->get('nonota') ,
            'id_karyawan'=>auth::user()->id,
            'status_nota'=>$status,
            'kodeProyek'=>$kodeProyek,
            'tglNota'=>date_create($request->get('tglNota')),
            'referensi'=> $request->get('cboreferensi')
            ));

       
       $nota->save();


        for($i=0;$i<sizeof($harsat);$i++){
            $baris=$i+1;
            $DetailNotaKasMasuk= new DetailNotaKasMasuk(array('nonota'=>$request->get('nonota'),
                'tglNota'=>date_create($request->get('tglNota')),
                'uraian'=>$uraian[$i],
                'noBaris'=>$baris,
                'saldo'=>$harsat[$i]
                ));
            $DetailNotaKasMasuk->save();   
        }

        session()->put('success','Data berhasil diinputkan');
        return redirect('nota-kas-masuk');
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
        $notakasmasuk = NotaKasMasuk::where('nonota','=',$id)->first();
        $detailnota=$notakasmasuk->detailnota;

        return view('nota-kas-masuk.show', compact('notakasmasuk','detailnota'));
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
        $materials=material::all();
        $mitras=mitraKerja::all();
        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $kodeproyek=session()->get('pilihanproyek');
        $notakasmasuk = NotaKasMasuk::where('nonota',$id)->first();
        $detailnota=$notakasmasuk->detailnota;
        return view('nota-kas-masuk.edit', compact('tgl','proyeks','notakasmasuk','detailnota'));
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
        $uraian=$request->get('uraian');
        $harsat=$request->get('price');
        $status="menunggu";
        $kodeProyek = session()->get('pilihanproyek');
        //$requestData = $request->all();
        $notakasmasuk = NotaKasMasuk::where('nonota',$id)->update(['id_karyawan'=>auth::user()->id,
            'status_nota'=>$status,
            'kodeProyek'=>$kodeProyek,
            'tglNota'=>date_create($request->get('tglNota')),
            'referensi'=> $request->get('cboreferensi')]);

        DetailNotaKasMasuk::where('nonota',$id)->delete();
        for($i=0;$i<sizeof($harsat);$i++){
            $baris=$i+1;
            $DetailNotaKasMasuk= new DetailNotaKasMasuk(array('nonota'=>$id,
                'tglNota'=>date_create($request->get('tglNota')),
                'uraian'=>$uraian[$i],
                'noBaris'=>$baris,
                'saldo'=>$harsat[$i]
                ));
            $DetailNotaKasMasuk->save();   
        }

        // $notakasmasuk = NotaKasMasuk::findOrFail($id);
        // $notakasmasuk->update($requestData);

        session()->put('success','Data berhasil diubah');

        return redirect('nota-kas-masuk');
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
        NotaKasMasuk::destroy($nonota);

        session()->put('success','Data berhasil dihapus');

        return redirect('nota-kas-masuk');
    }
    public function exportcsv(Request $request){
        $name='KM_'.date('YmdHis');
        $tglAwal=date_create($request->get('tglAwal'));
        $tglAkhir=date_create($request->get('tglAkhir'));
        
        NotaKasMasuk::where('tglNota','>=',$tglAwal)->where('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->update(['status_nota'=>'valid','validator'=>auth::user()->id,'waktu_valid'=>date('Y-m-d')]);

        $beli=NotaKasMasuk::where('tglNota','>=',$tglAwal)->orWhere('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();
        $detailBeli=DetailNotaKasMasuk::where('tglNota','>=',$tglAwal)->orWhere('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();

        // Excel::create($name,function($excel) use ($data){
        //     $excel->sheet('sheet', function($sheet) use ($data){
        //         $sheet->fromArray($data);
        //     });

        return Excel::create($name, function($excel) use ($beli,$detailBeli) {
             // Our first sheet
            $excel->sheet('Kas Masuk', function($sheet) use ($beli) {
                $sheet->fromArray($beli);
            });

            // Our second sheet
            $excel->sheet('Detail Kas Masuk', function($sheet1) use ($detailBeli) {
                $sheet1->fromArray($detailBeli);
            });
        })->download('xls');
    }
}
