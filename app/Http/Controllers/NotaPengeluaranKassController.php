<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\NotaPengeluaranKass;
use App\NotaBeliMaterial;
use App\DetailPengeluaranKass;
use App\material;
use App\mitraKerja;
use DB;
use Excel;
use App\proyek;
use Illuminate\Http\Request;
use Session;
use auth;
use App\BiayaKas;
use App\alat;

class NotaPengeluaranKassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        $notapengeluarankass = NotaPengeluaranKass::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
        

        return view('nota-pengeluaran-kass.index', compact('notapengeluarankass'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tgl=date('Y-m-d');
        $materials=material::all();
        $mitras=mitraKerja::all();
        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
         $kodeproyek=session()->get('pilihanproyek');
        $jum=NotaPengeluaranKass::where('nonota','like','%P'.$kodeproyek.'%')->count();
        if($jum==0){
            $kode="P".$kodeproyek."PK001";
        }else{
        $nomm=NotaPengeluaranKass::where('nonota','like','%P'.$kodeproyek."%")->orderBy('nonota','DESC')->first();
        $no=substr($nomm->nonota,6);
        $kode='P'.$kodeproyek.'PK';
        // $kode=substr($nomm->nonota,0,2);
        $no++;

        if($no<10)
            $kode=$kode."00".$no;
        elseif($no<100)
            $kode=$kode."0".$no;
        else
            $kode=$kode.$no;
        }

       
        $biayakass = BiayaKas::select('kodeBiayaKas AS kode', 'nama AS nama')->orderBy('nama', 'ASC');
        $biayakasalats = alat::select('kodeAlat AS kode', 'nama AS nama')->union($biayakass)->orderBy('nama', 'ASC')->get();

        return view('nota-pengeluaran-kass.create', compact('materials', 'mitras','proyeks','kode','tgl', 'biayakasalats'));
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
        
        // NotaPengeluaranKass::create($requestData);

        $uraian=$request->get('uraian');
        $qty=$request->get('qty');
        $kodeBiayaKas=$request->get('kode');
        
        
      

        $harsat=$request->get('price');
        $total=$request->get('total');
        $grantot=$request->get('grandTot');
        // $requestData = $request->all();
        $status="menunggu";
        $kodeProyek = session()->get('pilihanproyek');

        
        // $itung=1;

        $nota=new NotaPengeluaranKass( array('nonota' =>$request->get('nonota') ,
            'id_karyawan'=>auth::user()->id,
            'status_nota'=>$status,
            'kodeProyek'=>$kodeProyek,
            'tglNota'=>date_create($request->get('tglNota')),
            'referensi'=> $request->get('cboreferensi')
            ));

       
       $nota->save();


        for($i=0;$i<sizeof($qty);$i++){
            $baris=$i+1;

            $depan = substr($kodeBiayaKas[$i], 0, 1);
            //alat
            if($depan == 1 || $depan == 2){
                $jeniskode = "alat";
            }
            //biaya
            else{
                $jeniskode = "biaya";
            }

            if($jeniskode == "alat"){
                $DetailPengeluaranKass= new DetailPengeluaranKass(array('nonota'=>$request->get('nonota'),
                'tglNota'=>date_create($request->get('tglNota')),
                'uraian'=>$uraian[$i],
                'noBaris'=>$baris,
                'kodeAlat'=>$kodeBiayaKas[$i],
                'harga'=>$harsat[$i],
                'jumlah'=>$qty[$i]
                ));
            }
            else{
                $DetailPengeluaranKass= new DetailPengeluaranKass(array('nonota'=>$request->get('nonota'),
                'tglNota'=>date_create($request->get('tglNota')),
                'uraian'=>$uraian[$i],
                'noBaris'=>$baris,
                'kodeBiayaKas'=>$kodeBiayaKas[$i],
                'harga'=>$harsat[$i],
                'jumlah'=>$qty[$i]
                ));    
            }

            
            $DetailPengeluaranKass->save();   

            //ambil data barang
            // $barangg = Barang::where('kodebarang', '=', $idbarang[$i])->first();
            
            // //cek harga beli, kalo beda dgn harga jual hitung average
            // if($barangg->hargabeli != $harsat[$i]){
            //     $hargaaverage = (($barangg->stokriil * $barangg->hargabeli)+($qty[$i] * $harsat[$i])) / ($barangg->stokriil + $qty[$i]);
            //     $barangg->hargabeli = $hargaaverage;
            // }

            // //update stok di tabel barang
            // $stokriil = $barangg->stokriil;
            // $stokriil += $qty[$i];

            // $barangg->stokriil = $stokriil;
            // $barangg->save(); 
        }

        session()->put('success','Data berhasil diinputkan');

        return redirect('nota-pengeluaran-kass');
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
        $notapengeluarankass = NotaPengeluaranKass::where('nonota','=',$id)->first();
        $detailnota=$notapengeluarankass->detailnota;

        return view('nota-pengeluaran-kass.show', compact('notapengeluarankass', 'detailnota'));
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
        $notapengeluarankass = NotaPengeluaranKass::where('nonota','=',$id)->first();
        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $detailnota=$notapengeluarankass->detailnota;
        $biayakass = BiayaKas::select('kodeBiayaKas AS kode', 'nama AS nama')->orderBy('nama', 'ASC');
        $biayakasalats = alat::select('kodeAlat AS kode', 'nama AS nama')->union($biayakass)->orderBy('nama', 'ASC')->get();

        return view('nota-pengeluaran-kass.edit', compact('notapengeluarankass', 'detailnota','proyeks','biayakasalats'));
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
        $uraian=$request->get('uraian');
        $qty=$request->get('qty');
        $kodeBiayaKas=$request->get('kode');
        $harsat=$request->get('price');
        $total=$request->get('total');
        $grantot=$request->get('grandTot');
        $status="menunggu";
        $kodeProyek = session()->get('pilihanproyek');

        $nota = NotaPengeluaranKass::where('nonota','=',$id)->update([
            'id_karyawan'=>auth::user()->id,
             'referensi'=>$request->get('cboreferensi'),
            ]);
        
        DetailPengeluaranKass::where('nonota','=',$id)->delete();
       
        for($i=0;$i<sizeof($qty);$i++){
            $baris=$i+1;

            $depan = substr($kodeBiayaKas[$i], 0, 1);
            //alat
            if($depan == 1 || $depan == 2){
                $jeniskode = "alat";
            }
            //biaya
            else{
                $jeniskode = "biaya";
            }

            if($jeniskode == "alat"){
                $DetailPengeluaranKass= new DetailPengeluaranKass(array('nonota'=>$request->get('nonota'),
                'tglNota'=>date_create($request->get('tglNota')),
                'uraian'=>$uraian[$i],
                'noBaris'=>$baris,
                'kodeAlat'=>$kodeBiayaKas[$i],
                'harga'=>$harsat[$i],
                'jumlah'=>$qty[$i]
                ));
            }
            else{
                $DetailPengeluaranKass= new DetailPengeluaranKass(array('nonota'=>$request->get('nonota'),
                'tglNota'=>date_create($request->get('tglNota')),
                'uraian'=>$uraian[$i],
                'noBaris'=>$baris,
                'kodeBiayaKas'=>$kodeBiayaKas[$i],
                'harga'=>$harsat[$i],
                'jumlah'=>$qty[$i]
                ));    
            }

            
            $DetailPengeluaranKass->save();   

        }
        session()->put('success','Data berhasil diubah');

        return redirect('nota-pengeluaran-kass');
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
        NotaPengeluaranKass::where('no','=',$id)->first();

        session()->put('success','Data berhasil dihapus');

        return redirect('nota-pengeluaran-kass');
    }

    public function loaddetail($id){
        $notabeli=NotaBeliMaterial::find($id);

        $barangs=$notabeli->detailnota;
        // print_r($barangs);
        foreach ($barangs as $item) {
            
        }
    }
     
     function exportcsv(Request $request){
        $name='KK_'.date('YmdHis');
        $tglAwal=date_create($request->get('tglAwal'));
        $tglAkhir=date_create($request->get('tglAkhir'));
        NotaPengeluaranKass::where('tglNota','<=',$tglAwal)->where('tglNota','>=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->update(['status_nota'=>'valid','validator'=>auth::user()->id,'waktu_valid'=>date('Y-m-d')]);

        $pk=NotaPengeluaranKass::where('tglNota','>=',$tglAwal)->orWhere('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();
        $detailPK=DetailPengeluaranKass::where('tglNota','>=',$tglAwal)->orWhere('tglNota','<=',$tglAkhir)->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();

        // Excel::create($name,function($excel) use ($data){
        //     $excel->sheet('sheet', function($sheet) use ($data){
        //         $sheet->fromArray($data);
        //     });

        return Excel::create($name, function($excel) use ($pk,$detailPK) {
             // Our first sheet
            $excel->sheet('Kas Keluar', function($sheet) use ($pk) {
                $sheet->fromArray($pk);
            });

            // Our second sheet
            $excel->sheet('Detail Kas Keluar', function($sheet1) use ($detailPK) {
                $sheet1->fromArray($detailPK);
            });
        })->download('xls');
    }

    public function penetralankasbon(Request $request)
    {
        $notapengeluarankass = DB::table('nota_pengeluaran_kasses') 
            ->join('detail_pengeluaran_kasses', 'nota_pengeluaran_kasses.nonota', '=', 'detail_pengeluaran_kasses.nonota') 
            ->join('users', 'nota_pengeluaran_kasses.id_karyawan', '=', 'users.id') 
            ->select('nota_pengeluaran_kasses.*','users.nama as nama') 
            ->distinct('notapengeluarankass.nonota')
            ->where('detail_pengeluaran_kasses.kodeBiayaKas','=','319.02')->whereRaw('LENGTH(detail_pengeluaran_kasses.kodeBiayaKas)=6')
            ->where('kodeProyek', '=', session()->get('pilihanproyek'))
            ->where('detail_pengeluaran_kasses.uraian', 'LIKE', '%Penetralan Kasbon No.%')
            ->get();

        return view('nota-pengeluaran-kass.penetralan-kasbon', compact('notapengeluarankass'));
    }

  public function createpenetralankasbon()
    {
        $tgl = date('Y-m-d');
        $materials = material::all();
        $proyeks = proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $kodeproyek = session()->get('pilihanproyek');
        $jum = NotaPengeluaranKass::where('nonota','like','%P'.$kodeproyek.'%')->count();
        if($jum == 0){
            $kode = "P".$kodeproyek."PK001";
        }
        else{
            $nomm = NotaPengeluaranKass::where('nonota','like','%P'.$kodeproyek."%")->orderBy('nonota','DESC')->first();
            $no = substr($nomm->nonota,6);
            $kode = 'P'.$kodeproyek.'PK';
            // $kode=substr($nomm->nonota,0,2);
            $no++;

            if($no < 10)
                $kode = $kode."00".$no;
            elseif($no < 100)
                $kode = $kode."0".$no;
            else
                $kode = $kode.$no;
        }

        $notakasbon = DB::table('detail_pengeluaran_kasses')
                        ->where('kodeBiayaKas', '=', '319.02')
                        ->where('harga', '>', 0)
                        ->whereRaw('SUBSTRING(nonota, 2, 3)='. session()->get('pilihanproyek'))
                        ->where('uraian', 'NOT LIKE', '%(NETRAL)%')
                        ->distinct('nonota')
                        ->get();

        return view('nota-pengeluaran-kass.create-penetralan-kasbon', compact('materials','proyeks','kode','tgl', 'notakasbon'));
    }

    public function loadharga($nonota, $nobaris){
        $notakasbon=DetailPengeluaranKass::where('nonota', '=', $nonota)->where('noBaris', '=', $nobaris)->first();

        return $notakasbon->harga;
    }

   public function simpanpenetralankasbon(Request $request)
    {
        $requestData = $request->all();
        
        $uraian = $request->get('uraian');
        $harsat = $request->get('price');
        $referensi = $request->get('referensi');
   
        $status = "menunggu";
        $kodeProyek = session()->get('pilihanproyek');
    
        $nota = new NotaPengeluaranKass( array('nonota' =>$request->get('nonota') ,
            'id_karyawan'=>auth::user()->id,
            'status_nota'=>$status,
            'kodeProyek'=>$kodeProyek,
            'tglNota'=>date_create($request->get('tglNota'))
            ));
        $nota->save();

        for($i=0; $i<sizeof($harsat); $i++){
            $baris = $i+1;
            $kodeBiayaKas = "319.02";
            $jumlah = 1;
            $harga = -1 * $harsat[$i];
            $uraiann = "Penetralan Kasbon No." . substr($referensi[$i], 0, 9) . " " . $uraian[$i];

            $DetailPengeluaranKass = new DetailPengeluaranKass(array('nonota'=>$request->get('nonota'),
                'tglNota'=>date_create($request->get('tglNota')),
                'uraian'=>$uraiann,
                'noBaris'=>$baris,
                'kodeBiayaKas'=>$kodeBiayaKas,
                'harga'=>$harga,
                'jumlah'=>$jumlah
            ));
            $DetailPengeluaranKass->save();  

            $notakaskeluar = DetailPengeluaranKass::where("nonota","=", substr($referensi[$i], 0, 9))
                            ->where('noBaris', '=', substr($referensi[$i], 10,1))
                            ->first();
            
            DetailPengeluaranKass::where("nonota","=", substr($referensi[$i], 0, 9))
                                ->where('noBaris', '=', substr($referensi[$i], 10,1))
                                ->update(['uraian'=>$notakaskeluar->uraian." (NETRAL)"]);
             
        }
 
       Session::flash('flash_message', 'NotaPengeluaranKass added!');

       return redirect('penetralan-kasbon');
    }

    public function editpenetralan($id)
    {
        $tgl = date('Y-m-d');
        
        $proyeks = proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $kodeproyek = session()->get('pilihanproyek');

        $notakaskeluar = NotaPengeluaranKass::where('nonota',$id)->first();
        $detailnota = $notakaskeluar->detailnota;

        $notakasbon = DB::table('detail_pengeluaran_kasses')
                        ->where('kodeBiayaKas', '=', '319.02')
                        ->where('harga', '>', 0)
                        ->whereRaw('SUBSTRING(nonota, 2, 3)='. session()->get('pilihanproyek'))
                        // ->where('uraian', 'NOT LIKE', '%(NETRAL)%')
                        ->distinct('nonota')
                        ->get();

        return view('nota-pengeluaran-kass.editpenetralan', compact('tgl','proyeks','notakaskeluar','detailnota', 'notakasbon'));
    }

    public function updatepenetralan($id, Request $request){
        $requestData = $request->all();
        
        $uraian = $request->get('uraian');
        $harsat = $request->get('price');
        $referensi = $request->get('referensi');
        $tglNota = $request->get('tglNota');
   
        $kodeProyek = session()->get('pilihanproyek');

        NotaPengeluaranKass::where("nonota", "=", $id)
                            ->update(['tglNota' => $tglNota]);

        for($i=0; $i<sizeof($harsat); $i++){
            DetailPengeluaranKass::where('nonota','=',$id)
                                ->where('noBaris', '=', substr($referensi[$i], 10,1))
                                ->delete();

            $baris = $i+1;
            $kodeBiayaKas = "319.02";
            $jumlah = 1;
            $harga = -1 * $harsat[$i];
            $uraiann = "Penetralan Kasbon No." .substr($referensi[$i], 0, 9)." ".$uraian[$i];
       
            $DetailPengeluaranKass = new DetailPengeluaranKass(array('nonota'=>$request->get('nonota'),
                'tglNota'=>date_create($request->get('tglNota')),
                'uraian'=>$uraiann,
                'noBaris'=>$baris,
                'kodeBiayaKas'=>$kodeBiayaKas,
                'harga'=>$harga,
                'jumlah'=>$jumlah
            ));
            $DetailPengeluaranKass->save();   

            $notakaskeluar = DetailPengeluaranKass::where("nonota","=", substr($referensi[$i], 0, 9))
                            ->where('noBaris', '=', substr($referensi[$i], 10,1))
                            ->first();
            
            DetailPengeluaranKass::where("nonota","=", substr($referensi[$i], 0, 9))
                                ->where('noBaris', '=', substr($referensi[$i], 10,1))
                                ->update(['uraian'=>$notakaskeluar->uraian." (NETRAL)"]);    
        }
 
       Session::flash('flash_message', 'Penetralan Kasbon updated!');

       return redirect('penetralan-kasbon');
    }

     function exportkasboncsv(Request $request){
        $name='PK_'.date('YmdHis');
        $tglAwal=date_create($request->get('tglAwal'));
        $tglAkhir=date_create($request->get('tglAkhir'));
        NotaPengeluaranKass::where('tglNota','<=',$tglAwal)->where('tglNota','>=',$tglAkhir)->where('detail_pengeluaran_kasses.kodeBiayaKas','=','319.02')->whereRaw('LENGTH(detail_pengeluaran_kasses.kodeBiayaKas)=6')->where('kodeProyek','=',session()->get('pilihanproyek'))->update(['status_nota'=>'valid','validator'=>auth::user()->id,'waktu_valid'=>date('Y-m-d')]);

        $pk=NotaPengeluaranKass::where('tglNota','>=',$tglAwal)->orWhere('tglNota','<=',$tglAkhir)->where('detail_pengeluaran_kasses.kodeBiayaKas','=','319.02')->whereRaw('LENGTH(detail_pengeluaran_kasses.kodeBiayaKas)=6')->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();
        $detailPK=DetailPengeluaranKass::where('tglNota','>=',$tglAwal)->orWhere('tglNota','<=',$tglAkhir)->where('detail_pengeluaran_kasses.kodeBiayaKas','=','319.02')->whereRaw('LENGTH(detail_pengeluaran_kasses.kodeBiayaKas)=6')->where('kodeProyek','=',session()->get('pilihanproyek'))->get()->toArray();

        // Excel::create($name,function($excel) use ($data){
        //     $excel->sheet('sheet', function($sheet) use ($data){
        //         $sheet->fromArray($data);
        //     });

        return Excel::create($name, function($excel) use ($pk,$detailPK) {
             // Our first sheet
            $excel->sheet('Kas Kasbon', function($sheet) use ($pk) {
                $sheet->fromArray($pk);
            });

            // Our second sheet
            $excel->sheet('Detail Kas Kasbon', function($sheet1) use ($detailPK) {
                $sheet1->fromArray($detailPK);
            });
        })->download('xls');
    }
   
}
