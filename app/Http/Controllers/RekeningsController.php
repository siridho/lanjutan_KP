<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Rekening;
use Illuminate\Http\Request;
use Session;

class RekeningsController extends Controller
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
            $rekenings = Rekening::where('kode', 'LIKE', "%$keyword%")
				->orWhere('norek', 'LIKE', "%$keyword%")
				->orWhere('namabank', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $rekenings = Rekening::paginate($perPage);
        }

        return view('rekenings.index', compact('rekenings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('rekenings.create');
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
        
        Rekening::create($requestData);

       session()->put('success','Data berhasil diinputkan');

        return redirect('rekenings');
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
        $rekening = Rekening::findOrFail($id);

        return view('rekenings.show', compact('rekening'));
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
        $rekening = Rekening::findOrFail($id);

        return view('rekenings.edit', compact('rekening'));
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
        
        $rekening = Rekening::findOrFail($id);
        $rekening->update($requestData);

       session()->put('success','Data berhasil diubah');

        return redirect('rekenings');
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
        Rekening::destroy($id);

      session()->put('success','Data berhasil dihapus');

        return redirect('rekenings');
    }
}
