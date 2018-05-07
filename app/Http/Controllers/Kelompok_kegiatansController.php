<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Kelompok_kegiatan;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;

class Kelompok_kegiatansController extends Controller
{
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
            $kelompok_kegiatans = Kelompok_kegiatan::where('kodeKelompokKegiatan', 'LIKE', "%$keyword%")
				->orWhere('nama', 'LIKE', "%$keyword%")
				->orWhere('satuan', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $kelompok_kegiatans = Kelompok_kegiatan::paginate($perPage);
        }

        return view('kelompok_kegiatans.index', compact('kelompok_kegiatans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('kelompok_kegiatans.create');
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
        
        Kelompok_kegiatan::create($requestData);

       session()->put('success','Data Berhasil Diinputkan');
       
        return redirect('kelompok_kegiatans');
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
        $kelompok_kegiatan = Kelompok_kegiatan::findOrFail($id);

        return view('kelompok_kegiatans.show', compact('kelompok_kegiatan'));
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
        $kelompok_kegiatan = Kelompok_kegiatan::findOrFail($id);

        return view('kelompok_kegiatans.edit', compact('kelompok_kegiatan'));
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
        
        $kelompok_kegiatan = Kelompok_kegiatan::findOrFail($id);
        $kelompok_kegiatan->update($requestData);

        session()->put('success','Data Berhasil Diubah');

        return redirect('kelompok_kegiatans');
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
        Kelompok_kegiatan::destroy($id);

        Session::flash('flash_message', 'Kelompok_kegiatan deleted!');

        return redirect('kelompok_kegiatans');
    }

      public function exportcsv(){
        $name='KG_'.date('YmdHis');
        $data=Kelompok_kegiatan::all()->toArray();
        return Excel::create($name,function($excel) use ($data){
            $excel->sheet('Kelompok Kegiatan', function($sheet) use ($data){
                $sheet->fromArray($data);
            });
        })->download('xls');
    }
}
