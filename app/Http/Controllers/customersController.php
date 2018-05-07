<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\customer;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;

class customersController extends Controller
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
        $customers = customer::all();

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('customers.create');
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
        
        customer::create($requestData);

        session()->put('success','Data berhasil diinputkan');

        return redirect('customers');
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
        $customer = customer::where("kodeCustomer",'=',$id)->first();

        return view('customers.show', compact('customer'));
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
        $customer = customer::where("kodeCustomer",'=',$id)->first();

        return view('customers.edit', compact('customer'));
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
        
        $customer = customer::where("kodeCustomer",'=',$id)->first()->update(array('nama' => $request->get('nama'),
            'alamat'=>$request->get('alamat'),
            'area'=>$request->get('area'),
            'telepon'=>$request->get('telepon'),
            'email'=>$request->get('email'),
            'npwp'=>$request->get('npwp'),
            'kontakNama'=>$request->get('kontakNama'),
            'kontakTelepon'=>$request->get('kontakTelepon') ));
        //$customer->save();
        //$customer->update($requestData);

        session()->put('success','Data berhasil diubah');

        return redirect('customers');
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
        customer::destroy($id);

       session()->put('success','Data berhasil dihapus');

        return redirect('customers');
    }

    public function exportcsv(){
        $name='C_'.date('YmdHis');
        $data=customer::all()->toArray();
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
            if($split[0]=='C')
            {
                $data=Excel::load($path, function($reader){})->get();
                if(!empty($data) && $data->count()){
                    foreach ($data->toArray() as $key => $value) {
                            $insert[]=['kodeCustomer'=>$value['kodecustomer'],'nama'=>$value['nama'],'alamat'=>$value['alamat'],'area'=>$value['area'],'telepon'=>$value['telepon'],'email'=>$value['email'],'npwp'=>$value['npwp'],'kontakNama'=>$value['kontaknama'],'kontakTelepon'=>$value['kontaktelepon'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                            
                    }
                    if(!empty($insert)){
                        customer::insert($insert);
                        session()->put('success','Data Berhasil Diimpor');
                        return redirect('customers');
                    }
                }
            }
            else{
                session()->put('error','Pastikan Data yang Diimpor Adalah Data Customer');
                return redirect('customers');
            }

        }
            session()->put('error','Tidak Ada File Yang Akan Diupload');
         return redirect('customers');
    }
}
