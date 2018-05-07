<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DetailBeliMaterial;
use Illuminate\Http\Request;
use Session;
use Auth;

class DetailBeliMaterialsController extends Controller
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
            $detailbelimaterials = DetailBeliMaterial::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('kode_material', 'LIKE', "%$keyword%")
				->orWhere('qty', 'LIKE', "%$keyword%")
				->orWhere('harga', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailbelimaterials = DetailBeliMaterial::paginate($perPage);
        }

        return view('detail-beli-materials.index', compact('detailbelimaterials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-beli-materials.create');
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
        
        DetailBeliMaterial::create($requestData);

        Session::flash('flash_message', 'DetailBeliMaterial added!');

        return redirect('detail-beli-materials');
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
        $detailbelimaterial = DetailBeliMaterial::findOrFail($id);

        return view('detail-beli-materials.show', compact('detailbelimaterial'));
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
        $detailbelimaterial = DetailBeliMaterial::findOrFail($id);

        return view('detail-beli-materials.edit', compact('detailbelimaterial'));
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
        
        $detailbelimaterial = DetailBeliMaterial::findOrFail($id);
        $detailbelimaterial->update($requestData);

        Session::flash('flash_message', 'DetailBeliMaterial updated!');

        return redirect('detail-beli-materials');
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
        DetailBeliMaterial::destroy($id);

        Session::flash('flash_message', 'DetailBeliMaterial deleted!');

        return redirect('detail-beli-materials');
    }
}
