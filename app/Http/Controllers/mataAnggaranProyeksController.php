<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\mataAnggaranProyek;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;

class mataAnggaranProyeksController extends Controller
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
            $mataanggaranproyeks = mataAnggaranProyek::where('kodeKelompokAnggaran', 'LIKE', "%$keyword%")
				->orWhere('nama', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $mataanggaranproyeks = mataAnggaranProyek::paginate($perPage);
        }

        return view('mata-anggaran-proyeks.index', compact('mataanggaranproyeks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('mata-anggaran-proyeks.create');
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
        
        mataAnggaranProyek::create($requestData);

        session()->put('success','Data berhasil diinputkan');

        return redirect('mata-anggaran-proyeks');
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
        $mataanggaranproyek = mataAnggaranProyek::where("kodeKelompokAnggaran","=",$id)->first();

        return view('mata-anggaran-proyeks.show', compact('mataanggaranproyek'));
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
       $mataanggaranproyek = mataAnggaranProyek::where("kodeKelompokAnggaran","=",$id)->first();

        return view('mata-anggaran-proyeks.edit', compact('mataanggaranproyek'));
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
        
        $mataanggaranproyek = mataAnggaranProyek::where("kodeKelompokAnggaran","=",$id)->first();
        $mataanggaranproyek->update(array('nama' => $request->get('nama')));

        session()->put('success','Data berhasil diubah');

        return redirect('mata-anggaran-proyeks');
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
        mataAnggaranProyek::destroy($id);

       session()->put('success','Data berhasil dihapus');

        return redirect('mata-anggaran-proyeks');
    }

     public function exportcsv(){
        $name='MAP_'.date('YmdHis');
        $data=mataAnggaranProyek::all()->toArray();
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
            if($split[0]=='MAP')
            {
                $data=Excel::load($path, function($reader){})->get();
                if(!empty($data) && $data->count()){
                    foreach ($data->toArray() as $key => $value) {
                            $insert[]=['kodeKelompokAnggaran'=>$value['kodekelompokanggaran'],'nama'=>$value['nama'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                            
                    }
                    if(!empty($insert)){
                        mataAnggaranProyek::insert($insert);
                        session()->put('success','Data Berhasil Diimpor');
                        return redirect('mata-anggaran-proyeks');
                    }
                }
            }
            else{
                session()->put('error','Pastikan Data yang Diimpor Adalah Data Mata Anggaran Proyek');
                return redirect('mata-anggaran-proyeks');
            }

        }
            session()->put('error','Tidak Ada File Yang Akan Diupload');
         return redirect('mata-anggaran-proyeks');
    }
}
