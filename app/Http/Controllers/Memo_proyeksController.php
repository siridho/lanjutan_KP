<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Memo_proyek;
use Illuminate\Http\Request;
use Session;
use App\proyek;
use App\Detail_memo_proyek;
use Excel;
use DB;
use auth;

class Memo_proyeksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $memo_proyeks = Memo_proyek::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
        return view('memo_proyeks.index', compact('memo_proyeks'));
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
        $jum=Memo_proyek::where('nonota','like','%P'.$kodeproyek.'%')->count();
        if($jum==0){
            $kode="P".$kodeproyek."MP001";
        }else{
        $nomm=Memo_proyek::where('nonota','like','%P'.$kodeproyek."%")->orderBy('nonota','DESC')->first();
        $no=substr($nomm->nonota,6);
        $kode="P".$kodeproyek.'MP';
        // $kode=substr($nomm->nonota,0,2);
        $no++;

        if($no<10)
            $kode=$kode."00".$no;
        elseif($no<100)
            $kode=$kode."0".$no;
        else
            $kode=$kode.$no;
        }


        return view('memo_proyeks.create', compact('proyeks','kode','tgl'));
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
        $nilai=$request->get('nilai');
        $status="menunggu";
        $kodeProyek = session()->get('pilihanproyek');

        $nota=new Memo_proyek( array('nonota' =>$request->get('nonota') ,
            'id_karyawan'=>auth::user()->id,
            'status_nota'=>$status,
            'kodeProyek'=>$kodeProyek,
            'tgl'=>date_create($request->get('tgl'))
            ));
       $nota->save();


        for($i=0;$i<sizeof($nilai);$i++){
            $baris=$i+1;
            $Detail_memo_proyek= new Detail_memo_proyek(array('nonota'=>$request->get('nonota'),
                'tglNota'=>date_create($request->get('tglNota')),
                'uraian'=>$uraian[$i],
                'noBaris'=>$baris,
                'nilai'=>$nilai[$i]
                ));
            $Detail_memo_proyek->save();   
        }
        
        // Memo_proyek::create($requestData);

        session()->put('success','Data berhasil diinputkan');

        return redirect('memo_proyeks');
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
        $memo_proyek = Memo_proyek::where('nonota', '=', $id)->first();
        $detailnota = $memo_proyek->detailnota;

        return view('memo_proyeks.show', compact('memo_proyek', 'detailnota'));
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
        $memo_proyek = Memo_proyek::findOrFail($id);

        return view('memo_proyeks.edit', compact('memo_proyek'));
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
        
        $requestData = $request->all();
        
        $memo_proyek = Memo_proyek::findOrFail($id);
        $memo_proyek->update($requestData);

        session()->put('success','Data berhasil diubah');

        return redirect('memo_proyeks');
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
        Memo_proyek::destroy($id);

        session()->put('success','Data berhasil dihapus');

        return redirect('memo_proyeks');
    }

    public function exportcsv(Request $request){
        $name='MP_'.date('YmdHis');
        $tglAwal=date_create($request->get('tglAwal'));
        $tglAkhir=date_create($request->get('tglAkhir'));
        Memo_proyek::where('tgl','>=',$tglAwal)->where('tgl','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->update(['status_nota'=>'valid','validator'=>auth::user()->id,'waktu_valid'=>date('Y-m-d')]);

        $memo=Memo_proyek::where('tgl','>=',$tglAwal)->where('tgl','<=',$tglAkhir)->orwhere('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();
        $detailMemo=Detail_memo_proyek::where('tglNota','>=',$tglAwal)->orwhere('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();

        // Excel::create($name,function($excel) use ($data){
        //     $excel->sheet('sheet', function($sheet) use ($data){
        //         $sheet->fromArray($data);
        //     });

        return Excel::create($name, function($excel) use ($memo,$detailMemo) {
             // Our first sheet
            $excel->sheet('Memo', function($sheet) use ($memo) {
                $sheet->fromArray($memo);
            });

            // Our second sheet
            $excel->sheet('Detail Memo', function($sheet1) use ($detailMemo) {
                $sheet1->fromArray($detailMemo);
            });
        })->download('xls');
    }
}
