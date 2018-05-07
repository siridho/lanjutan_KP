<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Personal_manajemen;
use Illuminate\Http\Request;
use Session;
use Excel;
use DB;
use Auth;

class Personal_manajemensController extends Controller
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

        $personal_manajemens = Personal_manajemen::all();        

        return view('personal_manajemens.index', compact('personal_manajemens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('personal_manajemens.create');
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
        
        Personal_manajemen::create($requestData);

       session()->put('success','Data berhasil diinputkan');

        return redirect('personal_manajemens');
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
        $personal_manajemen = Personal_manajemen::findOrFail($id);

        return view('personal_manajemens.show', compact('personal_manajemen'));
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
        $personal_manajemen = Personal_manajemen::findOrFail($id);

        return view('personal_manajemens.edit', compact('personal_manajemen'));
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
        
        $personal_manajemen = Personal_manajemen::findOrFail($id);
        $personal_manajemen->update($requestData);

       session()->put('success','Data berhasil diubah');
        return redirect('personal_manajemens');
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
        Personal_manajemen::destroy($id);

        session()->put('success','Data berhasil dihapus');

        return redirect('personal_manajemens');
    }
}
