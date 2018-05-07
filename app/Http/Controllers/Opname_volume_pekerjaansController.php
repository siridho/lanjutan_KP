<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Opname_volume_pekerjaan;
use App\Detail_opname_pekerjaan;
use Illuminate\Http\Request;
use Session;
use auth;
use Excel;
use App\proyek;
use App\Kelompok_kegiatan;

class Opname_volume_pekerjaansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
       
        $opname_volume_pekerjaans = Opname_volume_pekerjaan::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
        
        return view('opname_volume_pekerjaans.index', compact('opname_volume_pekerjaans'));
    }

    public function getsatuan($id){
        $kelompokkegiatan=Kelompok_kegiatan::where('kodeKelompokKegiatan','=',$id)->first();
        echo $kelompokkegiatan->satuan;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tgl=date('Y-m-d');
        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $kodeproyek=session()->get('pilihanproyek');

        $jum=Opname_volume_pekerjaan::where('nonota','like','%P'.$kodeproyek.'%')->count();
        if($jum==0){
            $kode="P".$kodeproyek."OP001";
        }else{
        $nomm=Opname_volume_pekerjaan::where('nonota','like','%P'.$kodeproyek."%")->orderBy('nonota','DESC')->first();
        $no=substr($nomm->nonota,6);
        $kode='P'.$kodeproyek.'OP';
        // $kode=substr($nomm->nonota,0,2);
        $no++;

        if($no<10)
            $kode=$kode."00".$no;
        elseif($no<100)
            $kode=$kode."0".$no;
        else
            $kode=$kode.$no;
        }

        $kelompokKegiatans = Kelompok_kegiatan::whereRaw('LENGTH(kodeKelompokKegiatan)=2')->get();

        return view('opname_volume_pekerjaans.create', compact('proyeks','kode','tgl', 'kelompokKegiatans'));
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
        
        // $requestData = $request->all();
        
        // Opname_volume_pekerjaan::create($requestData);
        $tgl=date_create($request->get('tglNota'));
            // echo $tgl;exit();

        $nonota=$request->get('nonota');
        $proyek=session()->get('pilihanproyek');
        $kode=$request->get('kode');
        $volume=$request->get('volume');

        $nota=new opname_volume_pekerjaan(array(
            'nonota'=>$nonota,
            'tglNota'=>$tgl,
            'kodeProyek'=>$proyek,
            'idKaryawan'=>auth::user()->id,
            'status_nota'=>"menunggu",
            'validator'=>auth::user()->id,
            'waktu_valid'=>null
            ));
        $nota->save();
        $baris=1;
        for($i=0;$i<sizeof($volume);$i++){
           $detail=new Detail_opname_pekerjaan(array('nonota'=>$nonota,
            'tglNota'=>$tgl,
            'noBaris'=>$baris,
            'kodeKelompokKegiatan'=>$kode[$i],
            'volume'=>$volume[$i]
            ));
           $detail->save();
           $baris++;
        }

       session()->put('success','Data berhasil diinputkan');


        return redirect('opname_volume_pekerjaans');
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
         $notaopname = Opname_volume_pekerjaan::findOrFail($id);
        $tgl=date('Y-m-d');
        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $kodeproyek=session()->get('pilihanproyek');
        $kelompokKegiatans = Kelompok_kegiatan::whereRaw('LENGTH(kodeKelompokKegiatan)=2')->get();
        $details=$notaopname->detail;


        return view('opname_volume_pekerjaans.show', compact('notaopname','tgl','proyeks','kodeproyek','kelompokKegiatans','details'));
        // return view('opname_volume_pekerjaans.show', compact('opname_volume_pekerjaan'));
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
        $notaopname = Opname_volume_pekerjaan::findOrFail($id);
        $tgl=date('Y-m-d');
        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $kodeproyek=session()->get('pilihanproyek');
        $kelompokKegiatans = Kelompok_kegiatan::whereRaw('LENGTH(kodeKelompokKegiatan)=2')->get();
        $details=$notaopname->detail;


        return view('opname_volume_pekerjaans.edit', compact('notaopname','tgl','proyeks','kodeproyek','kelompokKegiatans','details'));
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
        
        $nota = Opname_volume_pekerjaan::whereNonota($id)->first();
        $tgl=date_create($request->get('tglNota'));
            // echo $tgl;exit();

        $proyek=session()->get('pilihanproyek');
        $kode=$request->get('kode');
        $volume=$request->get('volume');

        $nota->update([
            'tglNota'=>$tgl,
            'idKaryawan'=>auth::user()->id
            ]);
    Detail_opname_pekerjaan::whereNonota($id)->delete();
        $baris=1;
        for($i=0;$i<sizeof($volume);$i++){
           $detail=new Detail_opname_pekerjaan(array('nonota'=>$nota->nonota,
            'tglNota'=>$tgl,
            'noBaris'=>$baris,
            'kodeKelompokKegiatan'=>$kode[$i],
            'volume'=>$volume[$i]
            ));
           $detail->save();
           $baris++;
        }
        // $opname_volume_pekerjaan->update($requestData);

        session()->put('success','Data berhasil diubah');

        return redirect('opname_volume_pekerjaans');
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
        Opname_volume_pekerjaan::destroy($id);

        session()->put('success','Data berhasil dihapus');

        return redirect('opname_volume_pekerjaans');
    }
    function exportcsv(Request $request){
        $name='OP_'.date('YmdHis');
        $tglAwal=date_create($request->get('tglAwal'));
        $tglAkhir=date_create($request->get('tglAkhir'));
        // print_r($tglAwal);print_r($tglAkhir);exit();
        Opname_volume_pekerjaan::where('tglNota','>=',$tglAwal)->where('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->update(['status_nota'=>'valid','validator'=>auth::user()->id,'waktu_valid'=>date('Y-m-d')]);

        $pk=Opname_volume_pekerjaan::where('tglNota','>=',$tglAwal)->orWhere('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();
        $detailPK=Detail_opname_pekerjaan::where('tglNota','>=',$tglAwal)->orWhere('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();

        // Excel::create($name,function($excel) use ($data){
        //     $excel->sheet('sheet', function($sheet) use ($data){
        //         $sheet->fromArray($data);
        //     });

        return Excel::create($name, function($excel) use ($pk,$detailPK) {
             // Our first sheet
            $excel->sheet('Opname Volume Pekerjaan', function($sheet) use ($pk) {
                $sheet->fromArray($pk);
            });

            // Our second sheet
            $excel->sheet('Detail Opname Volume Pekerjaan', function($sheet1) use ($detailPK) {
                $sheet1->fromArray($detailPK);
            });
        })->download('xls');
    }
}
