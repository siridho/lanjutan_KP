<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\gudang;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;

class gudangsController extends Controller
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
            $gudangs = gudang::where('kodeGudang', 'LIKE', "%$keyword%")
				->orWhere('nama', 'LIKE', "%$keyword%")
				->orWhere('keterangan', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $gudangs = gudang::paginate($perPage);
        }

        return view('gudangs.index', compact('gudangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('gudangs.create');
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
        
        gudang::create($requestData);

        session()->put('success','Data berhasil diinputkan');

        return redirect('gudangs');
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
        $gudang = gudang::where("kodeGudang","=",$id)->first();

        return view('gudangs.show', compact('gudang'));
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
        $gudang = gudang::where("kodeGudang","=",$id)->first();

        return view('gudangs.edit', compact('gudang'));
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
        
        $gudang = gudang::where("kodeGudang","=",$id)->first();
        $gudang->update(array('nama' => $request->get('nama'),
            'keterangan'=>$request->get('keterangan')));

        session()->put('success','Data berhasil diubah');

        return redirect('gudangs');
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
        gudang::destroy($id);

        session()->put('success','Data berhasil dihapus');

        return redirect('gudangs');
    }

    public function exportcsv(){
        $name='G_'.date('YmdHis');
        $data=gudang::all()->toArray();
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
            if($split[0]=='G')
            {
                $data=Excel::load($path, function($reader){})->get();
                if(!empty($data) && $data->count()){
                    foreach ($data->toArray() as $key => $value) {
                            $insert[]=['kodeGudang'=>$value['kodegudang'],'nama'=>$value['nama'],'keterangan'=>$value['keterangan'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                            
                    }
                    if(!empty($insert)){
                        gudang::insert($insert);
                        session()->put('success','Data Berhasil Diimpor');
                        return redirect('gudangs');
                    }
                }
            }
            else{
                session()->put('error','Pastikan Data yang Diimpor Adalah Data Gudang');
                return redirect('gudangs');
            }

        }
            session()->put('error','Tidak Ada File Yang Akan Diupload');
         return redirect('gudangs');
    }
}
