<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\alat;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;

class alatsController extends Controller
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
        $alats = alat::all();


        return view('alats.index', compact('alats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('alats.create');
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
        
        alat::create($requestData);
        session()->put('success','Data berhasil diinputkan');

        return redirect('alats');
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
        $alat = alat::where("kodeAlat","=",$id)->first();

        return view('alats.show', compact('alat'));
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
        $alat = alat::where("kodeAlat","=",$id)->first();

        return view('alats.edit', compact('alat'));
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
        
        $alat = alat::where("kodeAlat","=",$id)->first();
        $alat->update(array('nama' => $request->get('nama'),
            'kelompokUtilitas'=>$request->get('kelompokUtilitas')));

        session()->put('success','Data berhasil diubah');

        return redirect('alats');
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
        alat::destroy($id);

       session()->put('success','Data berhasil dihapus');

        return redirect('alats');
    }

    public function exportcsv(){
        $name='A_'.date('YmdHis');
        $data=alat::all()->toArray();
        return Excel::create($name,function($excel) use ($data){
            $excel->sheet('Alat', function($sheet) use ($data){
                $sheet->fromArray($data);
            });
        })->download('xls');
    }

    public function importcsv(Request $request){
        if($request->hasFile('filecsv')){
            $path=$request->file('filecsv')->getRealPath();
            $name=$request->file('filecsv')->getClientOriginalName();
            $split=str_split($name,1);
            if($split[0]=='A')
            {
                $data=Excel::load($path, function($reader){})->get();
                if(!empty($data) && $data->count()){
                    foreach ($data->toArray() as $key => $value) {
                            $insert[]=['kodeAlat'=>$value['kodealat'],'nama'=>$value['nama'],'kelompokUtilitas'=>$value['kelompokutilitas'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                    }
                    if(!empty($insert)){
                        alat::insert($insert);
                        session()->put('success','Data Berhasil Diimpor');
                        return redirect('alats');
                    }
                }
            }
            else{
                session()->put('error','Pastikan Data yang Diimpor Adalah Data Alat');
                return redirect('alats');
            }

        }
            session()->put('error','Tidak Ada File Yang Akan Diupload');
         return redirect('alats');
    }
}
