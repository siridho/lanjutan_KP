<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Session;
use Excel;

class usersController extends Controller
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

        $users = User::all();
      
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
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
        
        User::create([
            'username'=>$request->get('username'),
            'nama' => $request->get('nama'),
            'level' => $request->get('level'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);

       session()->put('success','Data berhasil diinputkan');

        return redirect('users');
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
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
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
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
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
        
        $user = User::findOrFail($id);
        $user->update([
            'username'=>$request->get('username'),
            'nama' => $request->get('nama'),
            'level' => $request->get('level'),
            'email' => $request->get('email')
        ]);
        if ($request->get('password')) {
           $user->update([
            'username'=>$request->get('username'),
            'nama' => $request->get('nama'),
            'level' => $request->get('level'),
            'email' => $request->get('email'),
            'password' =>  bcrypt($request->get('password'))
        ]);
        }

        session()->put('success','Data berhasil diubah');

        return redirect('users');
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
        User::destroy($id);

        session()->put('success','Data berhasil dihapus');

        return redirect('users');
    }

    public function exportcsv(){
        $name='U_'.date('YmdHis');
        $data=User::all();
         // $data=User::all()->toArray();
        $data->makeVisible('password')->toArray();
        // print_r($data);exit();
        
        return Excel::create($name,function($excel) use ($data){
            $excel->sheet('User EDP', function($sheet) use ($data){
                $sheet->fromArray($data);
            });
        })->download('xls');
    }
}
