<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\standarSewaAlat;
use App\alat;
use App\mitraKerja;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;

class standarSewaAlatController extends Controller
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
            $standarsewaalat = standarSewaAlat::where('kode_alat', 'LIKE', "%$keyword%")
				->orWhere('kode_mitra', 'LIKE', "%$keyword%")
				->orWhere('harga_satuan', 'LIKE', "%$keyword%")
				->orWhere('janka_bayar', 'LIKE', "%$keyword%")
				->orWhere('jatuh_tempo', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $standarsewaalat = standarSewaAlat::paginate($perPage);
        }

        return view('standar-sewa-alat.index', compact('standarsewaalat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $alats=alat::all();
        $mitras=mitraKerja::all();
        return view('standar-sewa-alat.create',compact('alats','mitras'));
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
        
        standarSewaAlat::create($requestData);

        session()->put('success','Data berhasil diinputkan');

        return redirect('standar-sewa-alat');
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
        $standarsewaalat = standarSewaAlat::findOrFail($id);

        return view('standar-sewa-alat.show', compact('standarsewaalat'));
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
        $standarsewaalat = standarSewaAlat::findOrFail($id);

        return view('standar-sewa-alat.edit', compact('standarsewaalat'));
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
        
        $standarsewaalat = standarSewaAlat::findOrFail($id);
        $standarsewaalat->update($requestData);

       session()->put('success','Data berhasil diubah');

        return redirect('standar-sewa-alat');
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
        standarSewaAlat::destroy($id);

        session()->put('success','Data berhasil dihapus');

        return redirect('standar-sewa-alat');
    }

    public function exportcsv(){
        $name='SSA_'.date('YmdHis');
        $data=standarSewaAlat::all()->toArray();
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
            if($split[0]=='SSA')
            {
                $data=Excel::load($path, function($reader){})->get();
                if(!empty($data) && $data->count()){
                    foreach ($data->toArray() as $key => $value) {
                            $insert[]=['kode_alat'=>$value['kode_alat'],'kode_mitra'=>$value['kode_mitra'],'harga_satuan'=>$value['harga_satuan'],'jangka_bayar'=>$value['jangka_bayar'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                            
                    }
                    if(!empty($insert)){
                        standarSewaAlat::insert($insert);
                        session()->put('success','Data Berhasil Diimpor');
                        return redirect('standar-sewa-alat');
                    }
                }
            }
            else{
                session()->put('error','Pastikan Data yang Diimpor Adalah Data Standar Sewa Alat');
                return redirect('standar-sewa-alat');
            }

        }
            session()->put('error','Tidak Ada File Yang Akan Diupload');
         return redirect('standar-sewa-alat');
    }

}
