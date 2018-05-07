<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DetailPenggunaanMaterial;
use Illuminate\Http\Request;
use Session;
use Auth;

class DetailPenggunaanMaterialsController extends Controller
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
            $detailpenggunaanmaterials = DetailPenggunaanMaterial::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('kodeMaterial', 'LIKE', "%$keyword%")
				->orWhere('jumlah', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailpenggunaanmaterials = DetailPenggunaanMaterial::paginate($perPage);
        }

        return view('detail-penggunaan-materials.index', compact('detailpenggunaanmaterials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-penggunaan-materials.create');
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
        
        DetailPenggunaanMaterial::create($requestData);

        Session::flash('flash_message', 'DetailPenggunaanMaterial added!');

        return redirect('detail-penggunaan-materials');
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
        $detailpenggunaanmaterial = DetailPenggunaanMaterial::findOrFail($id);

        return view('detail-penggunaan-materials.show', compact('detailpenggunaanmaterial'));
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
        $detailpenggunaanmaterial = DetailPenggunaanMaterial::findOrFail($id);

        return view('detail-penggunaan-materials.edit', compact('detailpenggunaanmaterial'));
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
        
        $detailpenggunaanmaterial = DetailPenggunaanMaterial::findOrFail($id);
        $detailpenggunaanmaterial->update($requestData);

        Session::flash('flash_message', 'DetailPenggunaanMaterial updated!');

        return redirect('detail-penggunaan-materials');
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
        DetailPenggunaanMaterial::destroy($id);

        Session::flash('flash_message', 'DetailPenggunaanMaterial deleted!');

        return redirect('detail-penggunaan-materials');
    }
}
