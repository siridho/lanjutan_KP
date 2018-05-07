<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\standarBeliMaterial;
use App\material;
use App\mitraKerja;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;

class standarBeliMaterialController extends Controller
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

        if (!empty($keyword)) {
            $standarbelimaterial = standarBeliMaterial::where('kode_material', 'LIKE', "%$keyword%")
				->orWhere('kode_mitra', 'LIKE', "%$keyword%")
				->orWhere('harga_satuan', 'LIKE', "%$keyword%")
				->orWhere('janka_bayar', 'LIKE', "%$keyword%")
				->orWhere('jatuh_tempo', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $standarbelimaterial = standarBeliMaterial::paginate($perPage);
        }

        return view('standar-beli-material.index', compact('standarbelimaterial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $materials=material::all();
        $mitras=mitraKerja::all();
        return view('standar-beli-material.create',compact('materials','mitras'));
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
        
        standarBeliMaterial::create($requestData);

       session()->put('success','Data berhasil diinputkan');

        return redirect('standar-beli-material');
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
        $standarbelimaterial = standarBeliMaterial::find($id);

       

        return view('standar-beli-material.show', compact('standarbelimaterial'));
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
        $standarbelimaterial = standarBeliMaterial::findOrFail($id);

        return view('standar-beli-material.edit', compact('standarbelimaterial'));
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
        
        $standarbelimaterial = standarBeliMaterial::findOrFail($id);
        $standarbelimaterial->update($requestData);

        session()->put('success','Data berhasil diubah');

        return redirect('standar-beli-material');
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
        standarBeliMaterial::destroy($id);

       session()->put('success','Data berhasil dihapus');

        return redirect('standar-beli-material');
    }


    public function exportcsv(){
        $name='SBM_'.date('YmdHis');
        $data=standarBeliMaterial::all()->toArray();
        return Excel::create($name,function($excel) use ($data){
            $excel->sheet('sheet', function($sheet) use ($data){
                $sheet->fromArray($data);
            });
        })->download('csv');
    }

    public function importcsv(Request $request){
        if($request->hasFile('filecsv')){
            $path=$request->file('filecsv')->getRealPath();
            $name=$request->file('filecsv')->getClientOriginalName();
            $split=str_split($name,3);
            if($split[0]=='SBM')
            {
                $data=Excel::load($path, function($reader){})->get();
                if(!empty($data) && $data->count()){
                    foreach ($data->toArray() as $key => $value) {
                            $insert[]=['kode_material'=>$value['kode_material'],'kode_mitra'=>$value['kode_mitra'],'harga_satuan'=>$value['harga_satuan'],'jangka_bayar'=>$value['jangka_bayar'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                            
                    }
                    if(!empty($insert)){
                        standarBeliMaterial::insert($insert);
                        session()->put('success','Data Berhasil Diimpor');
                        return redirect('standar-beli-material');
                    }
                }
            }
            else{
                session()->put('error','Pastikan Data yang Diimpor Adalah Data Standar Beli Material');
                return redirect('standar-beli-material');
            }

        }
            session()->put('error','Tidak Ada File Yang Akan Diupload');
         return redirect('standar-beli-material');
    }
}
