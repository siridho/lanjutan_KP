<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MaterialGudang;
use Illuminate\Http\Request;
use Session;
use Auth;

class MaterialGudangsController extends Controller
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
            $materialgudangs = MaterialGudang::where('kodeGudang', 'LIKE', "%$keyword%")
				->orWhere('kodeMaterial', 'LIKE', "%$keyword%")
				->orWhere('stok', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $materialgudangs = MaterialGudang::paginate($perPage);
        }

        return view('material-gudangs.index', compact('materialgudangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('material-gudangs.create');
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
        
        MaterialGudang::create($requestData);

        session()->put('success','Data Berhasil Diinputkan');

        return redirect('material-gudangs');
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
        $materialgudang = MaterialGudang::where($id);

        return view('material-gudangs.show', compact('materialgudang'));
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
        $materialgudang = MaterialGudang::findOrFail($id);

        return view('material-gudangs.edit', compact('materialgudang'));
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
        
        $materialgudang = MaterialGudang::findOrFail($id);
        $materialgudang->update($requestData);

        session()->put('success','Data Berhasil Diubah');

        return redirect('material-gudangs');
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
        MaterialGudang::destroy($id);

        Session::flash('flash_message', 'MaterialGudang deleted!');

        return redirect('material-gudangs');
    }
    
}
