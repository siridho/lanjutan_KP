<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\DetailNotaKasMasuk;
use Illuminate\Http\Request;
use Session;

class DetailNotaKasMasukController extends Controller
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
            $detailnotakasmasuk = DetailNotaKasMasuk::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('uraian', 'LIKE', "%$keyword%")
				->orWhere('noBaris', 'LIKE', "%$keyword%")
				->orWhere('saldo', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailnotakasmasuk = DetailNotaKasMasuk::paginate($perPage);
        }

        return view('detail-nota-kas-masuk.index', compact('detailnotakasmasuk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-nota-kas-masuk.create');
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
        
        DetailNotaKasMasuk::create($requestData);

        Session::flash('flash_message', 'DetailNotaKasMasuk added!');

        return redirect('detail-nota-kas-masuk');
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
        $detailnotakasmasuk = DetailNotaKasMasuk::findOrFail($id);

        return view('detail-nota-kas-masuk.show', compact('detailnotakasmasuk'));
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
        $detailnotakasmasuk = DetailNotaKasMasuk::findOrFail($id);

        return view('detail-nota-kas-masuk.edit', compact('detailnotakasmasuk'));
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
        
        $detailnotakasmasuk = DetailNotaKasMasuk::findOrFail($id);
        $detailnotakasmasuk->update($requestData);

        Session::flash('flash_message', 'DetailNotaKasMasuk updated!');

        return redirect('detail-nota-kas-masuk');
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
        DetailNotaKasMasuk::destroy($id);

        Session::flash('flash_message', 'DetailNotaKasMasuk deleted!');

        return redirect('detail-nota-kas-masuk');
    }
}
