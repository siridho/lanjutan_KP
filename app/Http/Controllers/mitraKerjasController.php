<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\mitraKerja;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;

class mitraKerjasController extends Controller
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

        $mitrakerjas = mitraKerja::all();;

        return view('mitra-kerjas.index', compact('mitrakerjas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('mitra-kerjas.create');
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
        
        mitraKerja::create($requestData);

        session()->put('success','Data berhasil diinputkan');

        return redirect('mitra-kerjas');
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
        $mitrakerja = mitraKerja::where("kodeMitra","=",$id)->first();

        return view('mitra-kerjas.show', compact('mitrakerja'));
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
        $mitrakerja = mitraKerja::where("kodeMitra","=",$id)->first();

        return view('mitra-kerjas.edit', compact('mitrakerja'));
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
        
        $mitrakerja = mitraKerja::where("kodeMitra","=",$id)->first();
        $mitrakerja->update(array('nama' => $request->get('nama'),
            'alamat'=>$request->get('alamat'),
            'telepon'=>$request->get('telepon'),
            'email'=>$request->get('email'),
            'npwp'=>$request->get('npwp'),
            'kontakNama'=>$request->get('kontakNama'),
            'kontakTelepon'=>$request->get('kontakTelepon') ));

        session()->put('success','Data berhasil diubah');

        return redirect('mitra-kerjas');
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
        mitraKerja::destroy($id);

        session()->put('success','Data berhasil dihapus');
        return redirect('mitra-kerjas');
    }

    public function exportcsv(){
        $name='MK_'.date('YmdHis');
        $data=mitraKerja::all()->toArray();
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
            $split=str_split($name,2);
            if($split[0]=='MK')
            {
                $data=Excel::load($path, function($reader){})->get();
                if(!empty($data) && $data->count()){
                    foreach ($data->toArray() as $key => $value) {
                            $insert[]=['kodeMitra'=>$value['kodemitra'],'nama'=>$value['nama'],'alamat'=>$value['alamat'],'telepon'=>$value['telepon'],'email'=>$value['email'],'npwp'=>$value['npwp'],'kontakNama'=>$value['kontaknama'],'kontakTelepon'=>$value['kontaktelepon'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                            
                    }
                    if(!empty($insert)){
                        mitraKerja::insert($insert);
                        session()->put('success','Data Berhasil Diimpor');
                        return redirect('mitra-kerjas');
                    }
                }
            }
            else{
                session()->put('error','Pastikan Data yang Diimpor Adalah Data Mitra Kerja');
                return redirect('mitra-kerjas');
            }

        }
            session()->put('error','Tidak Ada File Yang Akan Diupload');
         return redirect('mitra-kerjas');
    }
}
