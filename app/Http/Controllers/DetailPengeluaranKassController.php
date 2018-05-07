<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DetailPengeluaranKass;
use Illuminate\Http\Request;
use Session;
use Auth;

class DetailPengeluaranKassController extends Controller
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
            $detailpengeluarankass = DetailPengeluaranKass::where('uraian', 'LIKE', "%$keyword%")
				->orWhere('kode', 'LIKE', "%$keyword%")
				->orWhere('kodejpk', 'LIKE', "%$keyword%")
				->orWhere('jumlah', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailpengeluarankass = DetailPengeluaranKass::paginate($perPage);
        }

        return view('detail-pengeluaran-kass.index', compact('detailpengeluarankass'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-pengeluaran-kass.create');
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
        
        DetailPengeluaranKass::create($requestData);

        Session::flash('flash_message', 'DetailPengeluaranKass added!');

        return redirect('detail-pengeluaran-kass');
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
        $detailpengeluarankass = DetailPengeluaranKass::findOrFail($id);

        return view('detail-pengeluaran-kass.show', compact('detailpengeluarankass'));
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
        $detailpengeluarankass = DetailPengeluaranKass::findOrFail($id);

        return view('detail-pengeluaran-kass.edit', compact('detailpengeluarankass'));
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
        
        $detailpengeluarankass = DetailPengeluaranKass::findOrFail($id);
        $detailpengeluarankass->update($requestData);

        Session::flash('flash_message', 'DetailPengeluaranKass updated!');

        return redirect('detail-pengeluaran-kass');
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
        DetailPengeluaranKass::destroy($id);

        Session::flash('flash_message', 'DetailPengeluaranKass deleted!');

        return redirect('detail-pengeluaran-kass');
    }
}
