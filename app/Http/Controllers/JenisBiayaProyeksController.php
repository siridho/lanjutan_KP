<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\JenisBiayaProyek;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;

class JenisBiayaProyeksController extends Controller
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
        $jenisbiayaproyeks = JenisBiayaProyek::all();

        return view('jenis-biaya-proyeks.index', compact('jenisbiayaproyeks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('jenis-biaya-proyeks.create');
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
        
        JenisBiayaProyek::create($requestData);

        session()->put('success','Data berhasil diinputkan');

        return redirect('jenis-biaya-proyeks');
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
        $jenisbiayaproyek = JenisBiayaProyek::where("kodeJenisBiaya","=",$id)->first();

        return view('jenis-biaya-proyeks.show', compact('jenisbiayaproyek'));
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
        $jenisbiayaproyek = JenisBiayaProyek::where("kodeJenisBiaya","=",$id)->first();

        return view('jenis-biaya-proyeks.edit', compact('jenisbiayaproyek'));
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
        
        $jenisbiayaproyek = JenisBiayaProyek::where("kodeJenisBiaya","=",$id)->first();
        $jenisbiayaproyek->update(array('nama' => $request->get('nama')));

        session()->put('success','Data berhasil diubah');

        return redirect('jenis-biaya-proyeks');
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
        JenisBiayaProyek::destroy($id);

        session()->put('success','Data berhasil dihapus');

        return redirect('jenis-biaya-proyeks');
    }

    public function exportcsv(){
        $name='JBP_'.date('YmdHis');
        $data=JenisBiayaProyek::all()->toArray();
        return Excel::create($name,function($excel) use ($data){
            $excel->sheet('Jenis Biaya Proyek', function($sheet) use ($data){
                $sheet->fromArray($data);
            });
        })->download('csv');
    }

    public function importcsv(Request $request){
        if($request->hasFile('filecsv')){
            $path=$request->file('filecsv')->getRealPath();
            $name=$request->file('filecsv')->getClientOriginalName();
            $split=str_split($name,3);
            if($split[0]=='JBP')
            {
                $data=Excel::load($path, function($reader){})->get();
                if(!empty($data) && $data->count()){
                    foreach ($data->toArray() as $key => $value) {
                            $insert[]=['kodeJenisBiaya'=>$value['kodejenisbiaya'],'nama'=>$value['nama'],'satuan'=>$value['satuan']];
                            
                    }
                    if(!empty($insert)){
                        JenisBiayaProyek::insert($insert);
                        session()->put('success','Data Berhasil Diimpor');
                        return redirect('jenis-biaya-proyeks');
                    }
                }
            }
            else{
                session()->put('error','Pastikan Data yang Diimpor Adalah Data Jenis Biaya Proyek');
                return redirect('jenis-biaya-proyeks');
            }

        }
            session()->put('error','Tidak Ada File Yang Akan Diupload');
         return redirect('jenis-biaya-proyeks');
    }
}
