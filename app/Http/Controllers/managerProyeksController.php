<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\managerProyek;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;

class managerProyeksController extends Controller
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

        $managerproyeks = managerProyek::all();

        return view('manager-proyeks.index', compact('managerproyeks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager-proyeks.create');
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
        
        managerProyek::create($requestData);

        Session::flash('flash_message', 'managerProyek added!');

        return redirect('manager-proyeks');
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
        $managerproyek = managerProyek::where("kodeManager","=",$id)->first();

        return view('manager-proyeks.show', compact('managerproyek'));
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
        $managerproyek = managerProyek::where("kodeManager","=",$id)->first();

        return view('manager-proyeks.edit', compact('managerproyek'));
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
        
        $managerproyek = managerProyek::where("kodeManager","=",$id)->first();
        $managerproyek->update(array('nama' => $request->get('nama'),
            'alamat'=>$request->get('alamat'),
            'identitas'=>$request->get('identitas'),
            'tanggalMasuk'=>$request->get('tanggalMasuk'),
            'email'=>$request->get('email'),
            'telepon'=>$request->get('telepon')));

        session()->put('success','Data Berhasil Diubah');

        return redirect('manager-proyeks');
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
        managerProyek::destroy($id);

        Session::flash('flash_message', 'managerProyek deleted!');

        return redirect('manager-proyeks');
    }

    public function exportcsv(){
        $name='MP_'.date('YmdHis');
        $data=managerProyek::all()->toArray();
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
            if($split[0]=='MP')
            {
                $data=Excel::load($path, function($reader){})->get();
                if(!empty($data) && $data->count()){
                    foreach ($data->toArray() as $key => $value) {
                            $insert[]=['kodeManager'=>$value['kodemanager'],'nama'=>$value['nama'],'alamat'=>$value['alamat'],'identitas'=>$value['identitas'],'tanggalMasuk'=>$value['tanggalmasuk'],'email'=>$value['email'],'telepon'=>$value['telepon'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                            
                    }
                    if(!empty($insert)){
                        managerProyek::insert($insert);
                        session()->put('success','Data Berhasil Diimpor');
                        return redirect('manager-proyeks');
                    }
                }
            }
            else{
                session()->put('error','Pastikan Data yang Diimpor Adalah Data Manager Proyek');
                return redirect('manager-proyeks');
            }

        }
            session()->put('error','Tidak Ada File Yang Akan Diupload');
         return redirect('manager-proyeks');
    }
}
