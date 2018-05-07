<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BiayaKas;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;
use App\MaterialProyek;
use App\DetailPengeluaranKass;
use App\JenisBiayaProyek;
use DB;

class BiayaKasController extends Controller
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
        $biayakas = BiayaKas::all();

        return view('biaya-kas.index', compact('biayakas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('biaya-kas.create');
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
        
        BiayaKas::create($requestData);

        session()->put('success','Data berhasil diinputkan');

        return redirect('biaya-kas');
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
        $biayakas = BiayaKas::where('kodeBiayaKas', '=', $id)->first();

        return view('biaya-kas.show', compact('biayakas'));
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
        $biayakas = BiayaKas::where("kodeBiayaKas","=",$id)->first();

        return view('biaya-kas.edit', compact('biayakas'));
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
        
        $biayakas = BiayaKas::where('kodeBiayaKas', '=', $id)->first();
        $biayakas->update(array('nama' => $request->get('nama'),
            'satuan'=>$request->get('satuan'),
            'keterangan'=>$request->get('keterangan')));

        Session::flash('flash_message', 'Data berhasil diubah');

        return redirect('biaya-kas');
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
        BiayaKas::destroy($id);

       session()->put('success','Data berhasil dihapus');

        return redirect('biaya-kas');
    }

    public function exportcsv(){
        $name='BK_'.date('YmdHis');
        $data=BiayaKas::all()->toArray();
        return Excel::create($name,function($excel) use ($data){
            $excel->sheet('Biaya Kas', function($sheet) use ($data){
                $sheet->fromArray($data);
            });
        })->download('xls');
    }

    public function importcsv(Request $request){
        if($request->hasFile('filecsv')){
            $path=$request->file('filecsv')->getRealPath();
            $name=$request->file('filecsv')->getClientOriginalName();
            $split=str_split($name,2);
            if($split[0]=='BK')
            {
                $data=Excel::load($path, function($reader){})->get();
                if(!empty($data) && $data->count()){
                    foreach ($data->toArray() as $key => $value) {
                            $insert[]=['kodeBiayaKas'=>$value['kodebiayakas'],'nama'=>$value['nama'],'satuan'=>$value['satuan'],'keterangan'=>$value['keterangan']];
                            
                    }
                    if(!empty($insert)){
                        BiayaKas::insert($insert);
                        session()->put('success','Data Berhasil Diimpor');
                        return redirect('biaya-kas');
                    }
                }
            }
            else{
                session()->put('error','Pastikan Data yang Diimpor Adalah Data Biaya Kas');
                return redirect('biaya-kas');
            }

        }
            session()->put('error','Tidak Ada File Yang Akan Diupload');
         return redirect('biaya-kas');
    }


    public function rekapitulasibiaya(){
        $alataa=DB::table('detail_pengeluaran_kasses')->select(DB::raw("alats.Satuan as satuan,alats.nama as nama,detail_pengeluaran_kasses.kodeAlat as kode"))->join('alats','alats.kodeAlat','=','detail_pengeluaran_kasses.kodeAlat')->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas',null)->distinct('kode');
        // $alat=DetailPengeluaranKass::join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat',null)->distinct('kode')->select(['detail_pengeluaran_kasses.kodeAlat as kode']);
 
        // $biaya=DetailPengeluaranKass::join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat',null)->distinct('kode')->select(['detail_pengeluaran_kasses.kodeBiayaKas as kode']);
    

        $biayaaa=DB::table('detail_pengeluaran_kasses')->select(DB::raw("biaya_kas.satuan as satuan, biaya_kas.nama as nama,detail_pengeluaran_kasses.kodeBiayaKas as kode"))->join('biaya_kas','detail_pengeluaran_kasses.kodeBiayaKas','=','biaya_kas.kodeBiayaKas')->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat',null)->distinct('kode');
        // print_r($biayaaa);
        // exit();
        $biayas=$alataa->union($biayaaa)->get();
        $tgl=date('Y-m-d');
        $temp=BiayaKas::orderBy('kodeBiayaKas')->first();
        
        return view('biaya-kas.rekapitulasi-biaya', compact('tgl','biayas','temp'));
    }

    public function tampilrekap($jenis,$tgl){
        if($jenis==2){
         $biaya_proyeks=DB::table('detail_pengeluaran_kasses')->select(DB::raw("alats.satuan as satuan,alats.nama as nama,detail_pengeluaran_kasses.kodeAlat as kode"))->join('alats','alats.kodeAlat','=','detail_pengeluaran_kasses.kodeAlat')->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas',null)->where('alats.kodeAlat','like',$jenis.'%')->distinct('kode')->get();
        }
        else if($jenis>2){
        $biaya_proyeks=DB::table('detail_pengeluaran_kasses')->select(DB::raw("biaya_kas.satuan as satuan,biaya_kas.nama as nama,detail_pengeluaran_kasses.kodeBiayaKas as kode"))->join('biaya_kas','detail_pengeluaran_kasses.kodeBiayaKas','=','biaya_kas.kodeBiayaKas')->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat',null)->where('biaya_kas.kodeBiayaKas','like',$jenis.'%')->distinct('kode')->get();
        }
        else{
              $alataa=DB::table('detail_pengeluaran_kasses')->select(DB::raw("alats.satuan as satuan,alats.nama as nama,detail_pengeluaran_kasses.kodeAlat as kode"))->join('alats','alats.kodeAlat','=','detail_pengeluaran_kasses.kodeAlat')->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas',null)->distinct('kode');
               $biayaaa=DB::table('detail_pengeluaran_kasses')->select(DB::raw("biaya_kas.satuan as satuan,biaya_kas.nama as nama,detail_pengeluaran_kasses.kodeBiayaKas as kode"))->join('biaya_kas','detail_pengeluaran_kasses.kodeBiayaKas','=','biaya_kas.kodeBiayaKas')->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat',null)->distinct('kode');
                $biaya_proyeks=$alataa->union($biayaaa)->get();
        }

       
         foreach($biaya_proyeks as $biaya){
            
            if(BiayaKas::totkuantum($biaya->kode, $tgl)){
                echo ' <tr>
                        <td>'.$biaya->kode.'</td>
                        <td style="vertical-align: middle; text-align: left; width: 25%;">'.$biaya->nama.'</td>
                        <td style="vertical-align: middle; text-align: left; width: 15%;">'.BiayaKas::totkuantum($biaya->kode, $tgl).' '.$biaya->satuan.'</td>
                        <td style="text-align: right;">Rp '.number_format(BiayaKas::totharga($biaya->kode, $tgl),0,",",".").'</td>
                        <td style="text-align: right;">Rp '.number_format(BiayaKas::hitungratarata($biaya->kode, $tgl),0,",",".").'</td>
                    </tr>';
            }
                
            }
    }

    public function tampilrekapfoot($jenis,$tgl){

        echo '<td colspan="3">JUMLAH</td>
            <td style="text-align: right; font-weight: bold;">Rp '. number_format(BiayaKas::grandtotharga($jenis,$tgl),0,",",".") .'</td>
            <td></td>';
    }

    public function transaksikas(){
        $terima=DB::table('detail_nota_kas_masuks')->select(DB::raw("
            nota_kas_masuks.nonota as nonota, 
            nota_kas_masuks.tglNota as tglNota, 
            nota_kas_masuks.referensi as referensi, 
            detail_nota_kas_masuks.saldo as saldo, 
            detail_nota_kas_masuks.uraian as uraian, 
            'Masuk' as status,
            '' as kode
            "))->join('nota_kas_masuks','nota_kas_masuks.nonota','=','detail_nota_kas_masuks.nonota')->where('nota_kas_masuks.kodeProyek','=',session()->get('pilihanproyek'));
        $masuk=DB::table('detail_pengeluaran_kasses')->select(DB::raw("
            nota_pengeluaran_kasses.nonota as nonota, 
            nota_pengeluaran_kasses.tglNota as tglNota, 
            nota_pengeluaran_kasses.referensi as referensi, 
            (detail_pengeluaran_kasses.harga * detail_pengeluaran_kasses.jumlah) as saldo, 
            detail_pengeluaran_kasses.uraian as uraian, 
            'keluar' as status,
            detail_pengeluaran_kasses.kodeBiayaKas as kode
            "))->join('nota_pengeluaran_kasses','nota_pengeluaran_kasses.nonota','=','detail_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'));
        $biayakass=$terima->union($masuk)->orderBy('tglNota','ASC')->get();

        if(!$biayakass->isEmpty()){
            $temp=BiayaKas::orderBy('kodeBiayaKas')->first();
            $tglakh=date('Y-m-d');
            $tgl=$terima->union($masuk)->orderBy('tglNota','ASC')->first('tglNota');
            $tglaw=$tgl->tglNota;
            // echo $tglaw.' '.$tglakh;exit();
            return view('biaya-kas.transaksi-kas', compact('biayakass','tglaw','tglakh','temp'));
        }
        else{
            return view('error.nodata');
        }

    }

    public function tampiltransaksi($tglaw,$tglakh){
        $temp=BiayaKas::orderBy('kodeBiayaKas')->first();
        $terima=DB::table('detail_nota_kas_masuks')->select(DB::raw("
            nota_kas_masuks.nonota as nonota, 
            nota_kas_masuks.tglNota as tglNota, 
            nota_kas_masuks.referensi as referensi, 
            detail_nota_kas_masuks.saldo as saldo, 
            detail_nota_kas_masuks.uraian as uraian, 
            'Masuk' as status,
            '' as kode
            "))->join('nota_kas_masuks','nota_kas_masuks.nonota','=','detail_nota_kas_masuks.nonota')->where('nota_kas_masuks.kodeProyek','=',session()->get('pilihanproyek'))->where('nota_kas_masuks.tglNota','>=',$tglaw)->where('nota_kas_masuks.tglNota','<=',$tglakh);
        $masuk=DB::table('detail_pengeluaran_kasses')->select(DB::raw("
            nota_pengeluaran_kasses.nonota as nonota, 
            nota_pengeluaran_kasses.tglNota as tglNota, 
            nota_pengeluaran_kasses.referensi as referensi, 
            (detail_pengeluaran_kasses.harga * detail_pengeluaran_kasses.jumlah) as saldo, 
            detail_pengeluaran_kasses.uraian as uraian, 
            'keluar' as status,
            detail_pengeluaran_kasses.kodeBiayaKas as kode
            "))->join('nota_pengeluaran_kasses','nota_pengeluaran_kasses.nonota','=','detail_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('nota_pengeluaran_kasses.tglNota','>=',$tglaw)->where('nota_pengeluaran_kasses.tglNota','<=',$tglakh);
        $biayakass=$terima->union($masuk)->orderBy('tglNota','ASC')->get();

        foreach($biayakass as $biayakas){
               echo '<tr class="';echo  ($biayakas->status=="Masuk")?'success':'danger';echo '">
                        <td style="text-align: left;">'.$biayakas->tglNota.'</td>
                        <td style="text-align: left;">'.$biayakas->nonota.'</td>
                        <td style="text-align: left;">'.$biayakas->uraian.'</td>
                        <td style="text-align: left;">'.$biayakas->referensi.'</td>
                        <td style="text-align: left;">'.$biayakas->kode.' - '. $temp->getnama($biayakas->kode).'</td>
                        <td style="text-align: left;">'.$biayakas->status.'</td>
                        <td style="text-align: right;">'.$biayakas->saldo.'</td>
                    </tr>';
            }
    }


    public function bukuKas(){
        $masuk=DB::table('detail_nota_kas_masuks')->select(DB::raw("detail_nota_kas_masuks.nonota as nonota, detail_nota_kas_masuks.tglNota as tglNota,detail_nota_kas_masuks.uraian as uraian, detail_nota_kas_masuks.saldo as saldo, '' as kode,'1' as no_baris"))->join('nota_kas_masuks','detail_nota_kas_masuks.nonota','=','nota_kas_masuks.nonota')->where('nota_kas_masuks.kodeProyek','=',session()->get('pilihanproyek'));
        $alat=DB::table('detail_pengeluaran_kasses')->select(DB::raw("detail_pengeluaran_kasses.nonota as nonota, detail_pengeluaran_kasses.tglNota as tglNota,detail_pengeluaran_kasses.uraian as uraian, detail_pengeluaran_kasses.jumlah as saldo,  kodeAlat as kode, detail_pengeluaran_kasses.noBaris as no_baris "))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas',null);
        $biaya=DB::table('detail_pengeluaran_kasses')->select(DB::raw("detail_pengeluaran_kasses.nonota as nonota, detail_pengeluaran_kasses.tglNota as tglNota,detail_pengeluaran_kasses.uraian as uraian, detail_pengeluaran_kasses.jumlah as saldo,  kodeBiayaKas as kode, detail_pengeluaran_kasses.noBaris as no_baris "))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat',null);
        $kas=$alat->union($biaya)->union($masuk)->orderBy('tglNota','ASC')->get();

        if(!$kas->isEmpty()){
            $saldo=0;
            $tglakh=date('Y-m-d');
            $tgl=$alat->union($biaya)->union($masuk)->orderBy('tglNota','ASC')->first('tglNota');
            $tglaw=$tgl->tglNota;
            $temp=BiayaKas::orderBy('kodeBiayaKas')->first();
            return view('biaya-kas.buku-kas',compact('tglaw','tglakh','saldo','kas','temp'));
        }
        else{
            return view('error.nodata');
        }

        
    }

    public function tampilbukukas($tglaw,$tglakh){
        $masuk=DB::table('detail_nota_kas_masuks')->select(DB::raw("detail_nota_kas_masuks.nonota as nonota, detail_nota_kas_masuks.tglNota as tglNota,detail_nota_kas_masuks.uraian as uraian, detail_nota_kas_masuks.saldo as saldo, '' as kode,'1' as no_baris"))->join('nota_kas_masuks','detail_nota_kas_masuks.nonota','=','nota_kas_masuks.nonota')->where('nota_kas_masuks.kodeProyek','=',session()->get('pilihanproyek'))->where('nota_kas_masuks.tglNota','>=',$tglaw)->where('nota_kas_masuks.tglNota','<=',$tglakh);
        $alat=DB::table('detail_pengeluaran_kasses')->select(DB::raw("detail_pengeluaran_kasses.nonota as nonota, detail_pengeluaran_kasses.tglNota as tglNota,detail_pengeluaran_kasses.uraian as uraian, detail_pengeluaran_kasses.jumlah as saldo,  kodeAlat as kode, detail_pengeluaran_kasses.noBaris as no_baris"))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas',null)->where('nota_pengeluaran_kasses.tglNota','>=',$tglaw)->where('nota_pengeluaran_kasses.tglNota','<=',$tglakh);
        $biaya=DB::table('detail_pengeluaran_kasses')->select(DB::raw("detail_pengeluaran_kasses.nonota as nonota, detail_pengeluaran_kasses.tglNota as tglNota,detail_pengeluaran_kasses.uraian as uraian, detail_pengeluaran_kasses.jumlah as saldo,  kodeBiayaKas as kode, detail_pengeluaran_kasses.noBaris as no_baris"))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat',null)->where('nota_pengeluaran_kasses.tglNota','>=',$tglaw)->where('nota_pengeluaran_kasses.tglNota','<=',$tglakh);
        $kas=$alat->union($biaya)->union($masuk)->orderBy('tglNota','ASC')->get();
        $saldo=BiayaKas::getsaldoawal($tglaw);
        echo '<tr>
                <td style="width: 10%;">'.$tglaw.'</td>
                <td style="text-align: left;width: 10%;"></td>
                <td style="text-align: left; font-weight:bold;width: 25%;">SALDO AWAL</td>
                <td style="text-align: left;width: 5%;"></td>
                <td style="text-align: right;width: 15%;';
                 echo ($saldo<=0)? 'color:red;':'';
               echo '">Rp '.number_format($saldo).'</td>
                <td style="text-align: right;width: 15%;"></td>
                <td style="text-align: right;width: 15%;"></td>
            </tr>';

         foreach($kas as $ka){
            if(!$ka->kode){
                $saldo+=$ka->saldo;
            }
            else{
                $saldo-=BiayaKas::tothargasaat($ka->kode, $ka->tglNota,$ka->nonota,$ka->no_baris);
            }
           echo '<tr>
                    <td style="width: 10%;">'.$ka->tglNota.'</td>
                    <td style="text-align: left;width: 10%;">'.$ka->nonota.'</td>
                    <td style="text-align: left;width: 25%;">'.$ka->uraian.'</td>
                    <td style="text-align: left;width: 5%;">'.$ka->kode.'</td>
                    <td style="text-align: right;width: 15%;">'; 
                    echo (!$ka->kode)?'Rp '.number_format($ka->saldo,0,",","."):'-'; 
                    echo'</td>
                    <td style="text-align: right;width: 15%;"> '; echo  $ka->kode?'Rp '.number_format(BiayaKas::tothargasaat($ka->kode, $ka->tglNota, $ka->nonota, $ka->no_baris),0,",","."):'-'; 
                    echo '</td>
                    <td style="text-align: right;width: 15%;';
                    echo ($saldo<=0)? 'color:red;':'';
                    echo'">Rp '.number_format($saldo,0,",",".").'</td>
                </tr>';
           }

    }

    public function tampilbukukasfoot($tglaw,$tglakh){
         $saldo=BiayaKas::getsaldoakhir($tglaw,$tglakh);
        echo '<tr>
                <td colspan="4" style="text-align: right;">JUMLAH</td>
                <td style="text-align: right;">Rp '.number_format(BiayaKas::grantotmasukkas($tglaw,$tglakh),0,",",".").'</td>
                <td style="text-align: right;">Rp '.number_format(BiayaKas::grantotkeluarkas($tglaw,$tglakh),0,",",".").'</td>
                <td style="text-align: right;';
                 echo ($saldo<=0)? 'color:red;':'';
                echo '">Rp '.number_format($saldo,0,",",".").'</td>
            </tr>';
    }


    public function rekapitulasiprogresbiaya(){
        $masuk=DB::table('detail_nota_kas_masuks')->select(DB::raw("detail_nota_kas_masuks.nonota as nonota, detail_nota_kas_masuks.tglNota as tglNota,detail_nota_kas_masuks.uraian as uraian, detail_nota_kas_masuks.saldo as saldo, '' as kode"))->join('nota_kas_masuks','detail_nota_kas_masuks.nonota','=','nota_kas_masuks.nonota')->where('nota_kas_masuks.kodeProyek','=',session()->get('pilihanproyek'));
        $alat=DB::table('detail_pengeluaran_kasses')->select(DB::raw("detail_pengeluaran_kasses.nonota as nonota, detail_pengeluaran_kasses.tglNota as tglNota,detail_pengeluaran_kasses.uraian as uraian, detail_pengeluaran_kasses.jumlah as saldo,  kodeAlat as kode"))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas',null);
        $biaya=DB::table('detail_pengeluaran_kasses')->select(DB::raw("detail_pengeluaran_kasses.nonota as nonota, detail_pengeluaran_kasses.tglNota as tglNota,detail_pengeluaran_kasses.uraian as uraian, detail_pengeluaran_kasses.jumlah as saldo,  kodeBiayaKas as kode"))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat',null);
      
        $kas=$alat->union($biaya)->union($masuk)->orderBy('tglNota','ASC')->get();

        $materials = JenisBiayaProyek::where('kodeJenisBiaya','LIKE','1%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $alats=JenisBiayaProyek::where('kodeJenisBiaya','LIKE','2%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $upahs=JenisBiayaProyek::where('kodeJenisBiaya','LIKE','3%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $bops=JenisBiayaProyek::where('kodeJenisBiaya','LIKE','4%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $bups=JenisBiayaProyek::where('kodeJenisBiaya','LIKE','5%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();

        // print_r(sizeof($kas));
        if(sizeof($kas)){
        if($materials->isEmpty() && $alats->isEmpty() && $upahs->isEmpty() && $bops->isEmpty() && $bups->isEmpty()){
           return view('error.nodata');
        }
        else{
            $tglakh=date('Y-m-d');
            $tgl=$alat->union($biaya)->union($masuk)->orderBy('tglNota','ASC')->first('tglNota');
            $tglaw=$tgl->tglNota;
            $tgl=date('Y-m-d',strtotime($tglaw . " - 1 day"));
           
            $temp=BiayaKas::orderBy('kodeBiayaKas')->first();
            return view('biaya-kas.rekapitulasi-progres-biaya', compact('tglaw','tglakh', 'materials','alats','upahs','bups','bops'));
        }
        }else{
             return view('error.nodata');
        }
    }

    public function tampilprogresbiaya($tglaw,$tglakh){
         $masuk=DB::table('detail_nota_kas_masuks')->select(DB::raw("detail_nota_kas_masuks.nonota as nonota, detail_nota_kas_masuks.tglNota as tglNota,detail_nota_kas_masuks.uraian as uraian, detail_nota_kas_masuks.saldo as saldo, '' as kode"))->join('nota_kas_masuks','detail_nota_kas_masuks.nonota','=','nota_kas_masuks.nonota')->where('nota_kas_masuks.kodeProyek','=',session()->get('pilihanproyek'));
        $alat=DB::table('detail_pengeluaran_kasses')->select(DB::raw("detail_pengeluaran_kasses.nonota as nonota, detail_pengeluaran_kasses.tglNota as tglNota,detail_pengeluaran_kasses.uraian as uraian, detail_pengeluaran_kasses.jumlah as saldo,  kodeAlat as kode"))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas',null);
        $biaya=DB::table('detail_pengeluaran_kasses')->select(DB::raw("detail_pengeluaran_kasses.nonota as nonota, detail_pengeluaran_kasses.tglNota as tglNota,detail_pengeluaran_kasses.uraian as uraian, detail_pengeluaran_kasses.jumlah as saldo,  kodeBiayaKas as kode"))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat',null);
      
        $kas=$alat->union($biaya)->union($masuk)->orderBy('tglNota','ASC')->get();
        $materials = JenisBiayaProyek::where('kodeJenisBiaya','LIKE','1%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $alats=JenisBiayaProyek::where('kodeJenisBiaya','LIKE','2%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $upahs=JenisBiayaProyek::where('kodeJenisBiaya','LIKE','3%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $bops=JenisBiayaProyek::where('kodeJenisBiaya','LIKE','4%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $bups=JenisBiayaProyek::where('kodeJenisBiaya','LIKE','5%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $tgl=date('Y-m-d',strtotime($tglaw . " - 1 day"));
        $temp=BiayaKas::orderBy('kodeBiayaKas')->first();

        echo '<tr>
                  <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="info">1. MATERIAL</td>
              </tr>';
        foreach($materials as $item){
            $lalu=$item->totkeluarsaat($item->kodeJenisBiaya,$tgl);
            $ini=$item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh);
            if($lalu||$ini){   
                echo '<tr>
                      <td style="vertical-align: middle; text-align: left;">'.$item->kodeJenisBiaya.' - '.$item->nama.'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".").'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".").'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".").'</td>
                  </tr>';
            }
        }
        echo '<tr style="">
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: left; font-weight:bold; ">SUBTOTAL MATERIAL</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".") .'</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".") .'</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".") .'</td>
          </tr>';

          echo '<tr>
                  <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="info">2. ALAT</td>
              </tr>';
        foreach($alats as $item){
            $lalu=$item->totkeluarsaat($item->kodeJenisBiaya,$tgl);
            $ini=$item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh);
            if($lalu||$ini){   
                echo '<tr>
                      <td style="vertical-align: middle; text-align: left;">'.$item->kodeJenisBiaya.' - '.$item->nama.'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".").'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".").'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".").'</td>
                  </tr>';
            }
        }
        echo '<tr style="">
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: left; font-weight:bold; ">SUBTOTAL ALAT</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".") .'</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".") .'</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".") .'</td>
          </tr>';

          echo '<tr>
                  <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="info">3. UPAH</td>
              </tr>';
        foreach($upahs as $item){
            $lalu=$item->totkeluarsaat($item->kodeJenisBiaya,$tgl);
            $ini=$item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh);
            if($lalu||$ini){   
                echo '<tr>
                      <td style="vertical-align: middle; text-align: left;">'.$item->kodeJenisBiaya.' - '.$item->nama.'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".").'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".").'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".").'</td>
                  </tr>';
            }
        }
        echo '<tr style="">
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: left; font-weight:bold; ">SUBTOTAL UPAH</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".") .'</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".") .'</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".") .'</td>
          </tr>';

          echo '<tr>
                  <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="info">4. BIAYA OPERASIONAL PROYEK</td>
              </tr>';
        foreach($bops as $item){
            $lalu=$item->totkeluarsaat($item->kodeJenisBiaya,$tgl);
            $ini=$item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh);
            if($lalu||$ini){   
                echo '<tr>
                      <td style="vertical-align: middle; text-align: left;">'.$item->kodeJenisBiaya.' - '.$item->nama.'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".").'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".").'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".").'</td>
                  </tr>';
            }
        }
        echo '<tr style="">
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: left; font-weight:bold; ">SUBTOTAL BIAYA OPERASIONAL PROYEK</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".") .'</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".") .'</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".") .'</td>
          </tr>';

          echo '<tr>
                  <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="info">5. BIAYA UMUM PROYEK</td>
              </tr>';
        foreach($bups as $item){
            $lalu=$item->totkeluarsaat($item->kodeJenisBiaya,$tgl);
            $ini=$item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh);
            if($lalu||$ini){   
                echo '<tr>
                      <td style="vertical-align: middle; text-align: left;">'.$item->kodeJenisBiaya.' - '.$item->nama.'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".").'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".").'</td>
                      <td style="vertical-align: middle; text-align: right;">Rp '.number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".").'</td>
                  </tr>';
            }
        }
        echo '<tr style="">
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: left; font-weight:bold; ">SUBTOTAL BIAYA UMUM PROYEK</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".") .'</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".") .'</td>
              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp '. number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".") .'</td>
          </tr>';
        
    }
    public function tampilprogresbiayafoot($tglaw,$tglakh){
        // $temp=BiayaKas::orderBy('kodeBiayaKas')->first();
        $tgl=date('Y-m-d',strtotime($tglaw . " - 1 day"));
        echo '<tr>
                  <td style="border-top: 2px gray solid; border-bottom: 2px gray solid; vertical-align: middle; text-align: left; font-weight:bold; ">TOTAL BIAYA</td>
                  <td style="border-top: 2px gray solid; border-bottom: 2px gray solid;  vertical-align: middle; text-align: right;font-weight:bold;">Rp '. number_format(JenisBiayaProyek::totbiayakeluarsaat($tgl),0,",",".") .'</td>
                  <td style="border-top: 2px gray solid; border-bottom: 2px gray solid;  vertical-align: middle; text-align: right;font-weight:bold;">Rp '. number_format(JenisBiayaProyek::totbiayakeluar($tglaw,$tglakh),0,",",".") .'</td>
                  <td style="border-top: 2px gray solid; border-bottom: 2px gray solid;  vertical-align: middle; text-align: right;font-weight:bold;">Rp '. number_format(JenisBiayaProyek::totbiayakeluarsaat($tglakh),0,",",".") .'</td>
              </tr>';
        
    }
}
