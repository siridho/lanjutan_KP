<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Detail_opname_pekerjaan;
use Illuminate\Http\Request;
use Session;

class Detail_opname_pekerjaansController extends Controller
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
            $detail_opname_pekerjaans = Detail_opname_pekerjaan::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('tglNota', 'LIKE', "%$keyword%")
				->orWhere('noBaris', 'LIKE', "%$keyword%")
				->orWhere('kodeKelompokKegiatan', 'LIKE', "%$keyword%")
				->orWhere('volume', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detail_opname_pekerjaans = Detail_opname_pekerjaan::paginate($perPage);
        }

        return view('detail_opname_pekerjaans.index', compact('detail_opname_pekerjaans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail_opname_pekerjaans.create');
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
        
        Detail_opname_pekerjaan::create($requestData);

        Session::flash('flash_message', 'Detail_opname_pekerjaan added!');

        return redirect('detail_opname_pekerjaans');
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
        $detail_opname_pekerjaan = Detail_opname_pekerjaan::findOrFail($id);

        return view('detail_opname_pekerjaans.show', compact('detail_opname_pekerjaan'));
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
        $detail_opname_pekerjaan = Detail_opname_pekerjaan::findOrFail($id);

        return view('detail_opname_pekerjaans.edit', compact('detail_opname_pekerjaan'));
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
        
        $detail_opname_pekerjaan = Detail_opname_pekerjaan::findOrFail($id);
        $detail_opname_pekerjaan->update($requestData);

        Session::flash('flash_message', 'Detail_opname_pekerjaan updated!');

        return redirect('detail_opname_pekerjaans');
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
        Detail_opname_pekerjaan::destroy($id);

        Session::flash('flash_message', 'Detail_opname_pekerjaan deleted!');

        return redirect('detail_opname_pekerjaans');
    }
}
