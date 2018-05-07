<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Detail_memo_proyek;
use Illuminate\Http\Request;
use Session;

class Detail_memo_proyeksController extends Controller
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
            $detail_memo_proyeks = Detail_memo_proyek::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('uraian', 'LIKE', "%$keyword%")
				->orWhere('nilai', 'LIKE', "%$keyword%")
				->orWhere('noBaris', 'LIKE', "%$keyword%")
				->orWhere('tglNota', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detail_memo_proyeks = Detail_memo_proyek::paginate($perPage);
        }

        return view('detail_memo_proyeks.index', compact('detail_memo_proyeks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail_memo_proyeks.create');
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
        
        Detail_memo_proyek::create($requestData);

        Session::flash('flash_message', 'Detail_memo_proyek added!');

        return redirect('detail_memo_proyeks');
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
        $detail_memo_proyek = Detail_memo_proyek::findOrFail($id);

        return view('detail_memo_proyeks.show', compact('detail_memo_proyek'));
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
        $detail_memo_proyek = Detail_memo_proyek::findOrFail($id);

        return view('detail_memo_proyeks.edit', compact('detail_memo_proyek'));
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
        
        $detail_memo_proyek = Detail_memo_proyek::findOrFail($id);
        $detail_memo_proyek->update($requestData);

        Session::flash('flash_message', 'Detail_memo_proyek updated!');

        return redirect('detail_memo_proyeks');
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
        Detail_memo_proyek::destroy($id);

        Session::flash('flash_message', 'Detail_memo_proyek deleted!');

        return redirect('detail_memo_proyeks');
    }
}
