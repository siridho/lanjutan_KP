<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\proyek;
use App\customer;
use App\managerProyek;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;

class proyeksController extends Controller
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

        $proyeks = proyek::all();
        



        return view('proyeks.index', compact('proyeks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $customers=customer::all();
        $managers=managerProyek::all();
        return view('proyeks.create',compact('customers','managers'));
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
        
        proyek::create($requestData);

        session()->put('success','Data berhasil diinputkan');

        return redirect('proyeks');
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
        $proyek = proyek::where("kodeProyek",'=',$id)->first();

       

        return view('proyeks.show', compact('proyek'));
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
        $proyek = proyek::where("kodeProyek",'=',$id)->first();
        $customers=customer::all();
        $managers=managerProyek::all();

        return view('proyeks.edit', compact('proyek','customers','managers'));
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
        
        $proyek = proyek::where("kodeProyek",'=',$id)->first();
        $proyek->update(array('kodeCustomer' => $request->get('kodeCustomer'),
            'kodeProyek'=>$request->get('kodeProyek'),
            'uraian'=>$request->get('uraian'),
            'jenis'=>$request->get('jenis'),
            'volume'=>$request->get('volume'),
            'waktu'=>$request->get('waktu'),
            'tanggalMulai'=>$request->get('tanggalMulai') ));

       session()->put('success','Data berhasil diubah');
        return redirect('proyeks');
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
        proyek::destroy($id);

       session()->put('success','Data berhasil dihapus');

        return redirect('proyeks');
    }

    public function exportcsv(){
        $name='P_'.date('YmdHis');
        $data=proyek::all()->toArray();
        return Excel::create($name,function($excel) use ($data){
            $excel->sheet('sheet', function($sheet) use ($data){
                $sheet->fromArray($data);
            });
        })->download('xls');
    }

    public function importcsv(Request $request){
        if($request->hasFile('filecsv')){
            $path=$request->file('filecsv')->getRealPath();
            $name=$request->file('filecsv')->getClientOriginalName();
            $split=str_split($name,1);
            if($split[0]=='P')
            {
                $data=Excel::load($path, function($reader){})->get();
                if(!empty($data) && $data->count()){
                    foreach ($data->toArray() as $key => $value) {
                            $insert[]=['kodeProyek'=>$value['kodeproyek'],'kodeCustomer'=>$value['kodecustomer'],'kodeManager'=>$value['kodemanager'],'uraian'=>$value['uraian'],'jenis'=>$value['jenis'],'volume'=>$value['volume'],'waktu'=>$value['waktu'],'tanggalMulai'=>$value['tanggalmulai'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                            
                    }
                    if(!empty($insert)){
                        proyek::insert($insert);
                        session()->put('success','Data Berhasil Diimpor');
                        return redirect('proyeks');
                    }
                }
            }
            else{
                session()->put('error','Pastikan Data yang Diimpor Adalah Data Proyek');
                return redirect('proyeks');
            }

        }
            session()->put('error','Tidak Ada File Yang Akan Diupload');
         return redirect('proyeks');
    }
}
