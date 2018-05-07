<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\jenisPengeluaranKasProyek;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;

class jenisPengeluaranKasProyeksController extends Controller
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
            $jenispengeluarankasproyeks = jenisPengeluaranKasProyek::where('kodeJenisPengeluaranKasProyek', 'LIKE', "%$keyword%")
				->orWhere('nama', 'LIKE', "%$keyword%")
				->orWhere('satuan', 'LIKE', "%$keyword%")
				->orWhere('keterangan', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $jenispengeluarankasproyeks = jenisPengeluaranKasProyek::paginate($perPage);
        }

        return view('jenis-pengeluaran-kas-proyeks.index', compact('jenispengeluarankasproyeks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('jenis-pengeluaran-kas-proyeks.create');
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
        
        jenisPengeluaranKasProyek::create($requestData);

        session()->put('success','Data berhasil diinputkan');

        return redirect('jenis-pengeluaran-kas-proyeks');
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
        $jenispengeluarankasproyek = jenisPengeluaranKasProyek::where('kodePengeluaran','=',$id)->first();

        return view('jenis-pengeluaran-kas-proyeks.show', compact('jenispengeluarankasproyek'));
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
        $jenispengeluarankasproyek = jenisPengeluaranKasProyek::where('kodePengeluaran','=',$id)->first();

        return view('jenis-pengeluaran-kas-proyeks.edit', compact('jenispengeluarankasproyek'));
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
        
        $jenispengeluarankasproyek = jenisPengeluaranKasProyek::where('kodePengeluaran','=',$id)->first();
        $jenispengeluarankasproyek->update(array('kodePengeluaran' => $request->get('kodePengeluaran'),
            'nama'=>$request->get('nama'),
            'satuan'=>$request->get('satuan'),
            'keterangan'=>$request->get('keterangan')));

        session()->put('success','Data berhasil diubah');

        return redirect('jenis-pengeluaran-kas-proyeks');
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
        jenisPengeluaranKasProyek::destroy($id);

        session()->put('success','Data berhasil dihapus');

        return redirect('jenis-pengeluaran-kas-proyeks');
    }

    public function exportcsv(){
        $name='JPK_'.date('YmdHis');
        $data=jenisPengeluaranKasProyek::all()->toArray();
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
            if($split[0]=='JPK')
            {
                $data=Excel::load($path, function($reader){})->get();
                if(!empty($data) && $data->count()){
                    foreach ($data->toArray() as $key => $value) {
                            $insert[]=['kodePengeluaran'=>$value['kodepengeluaran'],'nama'=>$value['nama'],'satuan'=>$value['satuan'],'keterangan'=>$value['keterangan'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                            
                    }
                    if(!empty($insert)){
                        jenisPengeluaranKasProyek::insert($insert);
                        session()->put('success','Data Berhasil Diimpor');
                        return redirect('jenis-pengeluaran-kas-proyeks');
                    }
                }
            }
            else{
                session()->put('error','Pastikan Data yang Diimpor Adalah Data Jenis Pengeluaran Kas Proyek');
                return redirect('jenis-pengeluaran-kas-proyeks');
            }

        }
            session()->put('error','Tidak Ada File Yang Akan Diupload');
         return redirect('jenis-pengeluaran-kas-proyeks');
    }
}
