<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Rap;
use Illuminate\Http\Request;
use session;
use App\proyek;
use App\Kelompok_kegiatan;
use App\JenisBiayaProyek;
use Auth;
use App\RapKegiatan;
use App\RapBiaya;
use App\RapPekerjaan;

class RapsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        

        // session()->keep(['username', 'email','pilihanproyek']);
        // session()->flush();
        if(session()->has('baris')){
            for($i=1;$i<=session()->get('baris');$i++){
                session()->forget('kodeJenisBiaya_'.$i);
                session()->forget('volumeBiaya_'.$i );
                session()->forget('hargaSatBiaya_'.$i);
                session()->forget('totalBiaya_'.$i);
                session()->forget('grandTotBiaya_'.$i);
            }
             session()->forget('baris');
        }
    //     if (!empty($keyword)) {
    //         $raps = Rap::where('nonota', 'LIKE', "%$keyword%")
				// ->orWhere('tglNota', 'LIKE', "%$keyword%")
				// ->orWhere('kodeProyek', 'LIKE', "%$keyword%")
				// ->orWhere('id_karyawan', 'LIKE', "%$keyword%")
				// ->orWhere('status', 'LIKE', "%$keyword%")
				// ->orWhere('validator', 'LIKE', "%$keyword%")
				// ->orWhere('waktu_valid', 'LIKE', "%$keyword%")
				// ->paginate($perPage);
    //     } else {
    //         $raps = Rap::paginate($perPage);
    //     }


        $raps = Rap::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
        return view('raps.index', compact('raps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tgl=date('Y-m-d');
        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $kodeproyek=session()->get('pilihanproyek');
        $jum=Rap::where('nonota','like','%P'.$kodeproyek.'%')->count();
        if($jum==0){
            $kode="P".$kodeproyek."RAP001";
        }else{
        $nomm=Rap::where('nonota','like','%P'.$kodeproyek."%")->orderBy('nonota','DESC')->first();
        $no=substr($nomm->nonota,6);
        $kode='P'.$kodeproyek.'RAP';
        // $kode=substr($nomm->nonota,0,2);
        $no++;

        if($no<10)
            $kode=$kode."00".$no;
        elseif($no<100)
            $kode=$kode."0".$no;
        else
            $kode=$kode.$no;
        }

        $pekerjaans = Kelompok_kegiatan::whereRaw('LENGTH(kodeKelompokKegiatan)=1')->get();
        $kegiatans = Kelompok_kegiatan::whereRaw('LENGTH(kodeKelompokKegiatan)=2')->get();
        $biayas = JenisBiayaProyek::whereRaw('LENGTH(kodeJenisBiaya)=3')->get();

        return view('raps.create', compact('proyeks','kode','tgl', 'kegiatans', 'pekerjaans', 'biayas'));
    }

    public function tambahpekerjaan($id){
        $rap=Rap::where("nonota","=",$id)->first();
        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();
        $pekerjaans = Kelompok_kegiatan::whereRaw('LENGTH(kodeKelompokKegiatan)=1')->get();
        $kegiatans = Kelompok_kegiatan::whereRaw('LENGTH(kodeKelompokKegiatan)=2')->get();
        $biayas = JenisBiayaProyek::whereRaw('LENGTH(kodeJenisBiaya)=3')->get();

        return view('raps.create', compact('proyeks','rap', 'kegiatans', 'pekerjaans', 'biayas'));

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
        $kodeKelompokKegiatan = $request->get('kodeKelompokKegiatan');
        $kodeJenisBiaya=$request->get('kodeJenisBiaya');
        // dd($kodeJenisBiaya);
        $minggu_mulai = $request->get('minggu_mulai');
        $lama = $request->get('lama');
        $volume = $request->get('volume');
        $total = $request->get('total');
        $grantot = $request->get('grandTot');
        $requestData = $request->all();
        $keterangan = $request->get('keterangan');
        $hargaSat = $request->get('hargaSat');
        
        $status = "belum disetujui";
        $arr = array();
        $kodeProyek = session()->get('pilihanproyek');
        $nonota = "P".$kodeProyek.'RA'.$request->get('nonota');
        
        $tgl = date_create($request->get('tglNota'));
        $pekerjaan = $request->get('pekerjaan');

         

        $nonotaRap=Rap::where("nonota","=",$nonota)->first();

        if(!isset($nonotaRap)){

            //SIMPAN RAP
            $nonotaRap = new Rap(array('nonota' => $nonota,
                'tglNota' => $tgl,
                'id_karyawan' => auth::user()->id,
                'kodeProyek' => $kodeProyek,
                'status' => $status,
                'validator' => 1,
                'created_at' => $request->get('created_at')
                ));
            $nonotaRap->save();
           
        }

         //SIMPAN RAP PEKERJAAN
            $RapPekerjaan = new RapPekerjaan(array('nonota' => $nonotaRap->nonota,             
                'kodeKelompokKegiatan' => $pekerjaan,
                'keterangan'=> $keterangan
                ));
            $RapPekerjaan->save();  

            //SIMPAN RAP KEGIATAN
            for($i=0; $i<sizeof($volume); $i++){
                $baris = $i+1;

                $RapKegiatan = new RapKegiatan(array('nonota' => $nonotaRap->nonota,    
                    'tglNota' => $tgl,            
                    'kodeKelompokKegiatan' => $kodeKelompokKegiatan[$i],
                    // 'keterangan' => $keterangan,
                    'minggu_mulai' => $minggu_mulai[$i],
                    'lama' => $lama[$i],
                    'volume' => $volume[$i],
                    'hargaSat' => $hargaSat[$i],
                    'totalHarga' => $total[$i],
                    'noBaris' => $baris,
                    'kode_pekerjaan' => $pekerjaan
                    ));
                $RapKegiatan->save();   
              
            }

              //SIMPAN RAP BIAYA
                $noBarisKegiatan=0;
                for($b=1;$b<=session()->get('baris');$b++){
                    if(session()->get('kodeJenisBiaya_'.$b)){
                        $noBarisKegiatan++;        

                        $kodebiaya=session()->get('kodeJenisBiaya_'.$b);
                        $volumeBiaya=session()->get('volumeBiaya_'.$b);
                        $hargaSatBiaya=session()->get('hargaSatBiaya_'.$b);

                        for($j=0; $j<sizeof($kodebiaya); $j++){
                            $barisbiaya = $j+1;

                            $RapBiaya = new RapBiaya(array('nonota' => $nonotaRap->nonota,    
                                'tglNota' => $tgl,            
                                'kodeJenisBiaya' => $kodebiaya[$j],
                                'qty' => $volumeBiaya[$j],
                                'harsat' => $hargaSatBiaya[$j],
                                'noBaris' => $barisbiaya,
                                'noBarisKegiatan' => $noBarisKegiatan,
                                'kodeKegiatan' => $kodeKelompokKegiatan[$noBarisKegiatan-1],
                                'kodePekerjaan' => $pekerjaan
                                ));
                            $RapBiaya->save();
                        }
                    }
                }
        session()->put('success','Data berhasil diinputkan');
        return redirect('raps');
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
        $rap = Rap::whereNonota($id)->first();
        // $rapbiaya = $rap->rapbiaya;
        // $rapkegiatan = $rap->kegiatan;

        return view('raps.show', compact('rap'));
    }

    public function rekapbiayamingguan(){
        $data=array();
        $rap=Rap::where('kodeProyek','=',session()->get('pilihanproyek'))->first();
        $la=RapKegiatan::whereNonota($rap->nonota)->selectRaw('minggu_mulai+lama-1 as akh')->orderBy('akh','desc')->first();
        $minggu=array();

        for($i=0;$i<$la->akh;$i++){
            array_push($minggu, 0);
        }
    
        $kodebiaya=array();
        $sum=array();
        $kode=RapKegiatan::join('kelompok_kegiatans','kelompok_kegiatans.kodeKelompokKegiatan','=','rap_kegiatans.kodeKelompokKegiatan' )->whereNonota($rap->nonota)->selectRaw('distinct rap_kegiatans.kodeKelompokKegiatan, kelompok_kegiatans.nama, kelompok_kegiatans.satuan')->orderBy('kelompok_kegiatans.kodeKelompokKegiatan','asc')->get();
        // print_r($kode);exit();
        foreach ($kode as $v) {
            // echo $v->kodeKelompokKegiatan;
            $data[$v->kodeKelompokKegiatan.'-'.$v->nama]=$minggu;
            array_push($kodebiaya, $v->kodeKelompokKegiatan.'-'.$v->nama);
            $jum=RapKegiatan::whereNonota($rap->nonota)->where('kodeKelompokKegiatan','=',$v->kodeKelompokKegiatan)->selectRaw('sum(totalHarga) as jum')->groupBy('kodeKelompokKegiatan')->first();
              array_push($sum,'Rp '. number_format($jum['jum'],0,',','.'));
        }
        // exit();
        $biayas=RapKegiatan::whereNonota($rap->nonota)->get();
        foreach ($biayas as $biaya) {
            $lama=RapKegiatan::whereNonota($rap->nonota)->where('kodeKelompokKegiatan','=',$biaya->kodeKelompokKegiatan)->first();
            for($i=0;$i<$lama->lama;$i++){
                $data[$biaya->kodeKelompokKegiatan.'-'.$biaya->kelompok_kegiatan->nama][$lama->minggu_mulai-1+$i]+=round($biaya->totalHarga/$lama->lama,0);
            }
        }
        $biaya=Kelompok_kegiatan::first();
        $lama=$la;
        foreach ($kode as $v) {
            for($i=0;$i<$la->akh;$i++){
                if($data[$v->kodeKelompokKegiatan.'-'.$v->kelompok_kegiatan->nama][$i]){
                     // $data[$v->kodeKelompokKegiatan.'-'.$v->biaya->nama][$i].=' '.$v->satuan;
                }else{
                     $data[$v->kodeKelompokKegiatan.'-'.$v->kelompok_kegiatan->nama][$i]='-';
                }
            }
        }
        return view('raps.rekap-rbm', compact('rap','data','biaya','lama','kodebiaya','sum','minggu'));

    }

    public function rekapmingguan(){
        $data=array();
        $rap=Rap::where('kodeProyek','=',session()->get('pilihanproyek'))->first();
        $la=RapKegiatan::whereNonota($rap->nonota)->selectRaw('minggu_mulai+lama-1 as akh')->orderBy('akh','desc')->first();
        $minggu=array();
        $satuan=array();
        for($i=0;$i<$la->akh;$i++){
            array_push($minggu, 0);
        }
    
        $kodebiaya=array();
        $sum=array();
        $kode=RapBiaya::join('jenis_biaya_proyeks','jenis_biaya_proyeks.kodeJenisBiaya','=','rap_biayas.kodeJenisBiaya')->whereNonota($rap->nonota)->selectRaw('distinct rap_biayas.kodeJenisBiaya,jenis_biaya_proyeks.nama,jenis_biaya_proyeks.satuan')->orderBy('rap_biayas.kodeJenisBiaya','asc')->get();
        
        foreach ($kode as $v) {
            $data[$v->kodeJenisBiaya.'-'.$v->biaya->nama]=$minggu;
              array_push($kodebiaya, $v->kodeJenisBiaya.'-'.$v->biaya->nama);
              $jum=RapBiaya::whereNonota($rap->nonota)->where('kodeJenisBiaya','=',$v->kodeJenisBiaya)->selectRaw('sum(qty) as jum')->groupBy('kodeJenisBiaya')->first();
              array_push($sum, $jum['jum']);
              array_push($satuan, $v->satuan);
        }
        $biayas=RapBiaya::whereNonota($rap->nonota)->get();
        foreach ($biayas as $biaya) {
            $lama=RapKegiatan::whereNonota($rap->nonota)->whereKodePekerjaan($biaya->kodePekerjaan)->where('kodeKelompokKegiatan','=',$biaya->kodeKegiatan)->first();
            for($i=0;$i<$lama->lama;$i++){
                $data[$biaya->kodeJenisBiaya.'-'.$biaya->biaya->nama][$lama->minggu_mulai-1+$i]+=round($biaya->qty/$lama->lama,2);
            }
        }
        $biaya=JenisBiayaProyek::first();
        $lama=$la;
        foreach ($kode as $v) {
            for($i=0;$i<$la->akh;$i++){
                if($data[$v->kodeJenisBiaya.'-'.$v->biaya->nama][$i]){
                     // $data[$v->kodeJenisBiaya.'-'.$v->biaya->nama][$i].=' '.$v->satuan;
                }else{
                     $data[$v->kodeJenisBiaya.'-'.$v->biaya->nama][$i]='-';
                }
            }
        }
        return view('raps.rekap-rvm', compact('rap','data','biaya','lama','kodebiaya','sum','satuan'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function editrap($id, $kode_pekerjaan)
    {
        $rap=Rap::whereNonota($id)->first();
        $detail = RapKegiatan::whereNonota($id)->whereKodePekerjaan($kode_pekerjaan)->get();
        $kerja=RapPekerjaan::where('kodeKelompokKegiatan','=',$kode_pekerjaan)->whereNonota($id)->first();
        // print_r($pekerjaan);exit();
        $pekerjaans = Kelompok_kegiatan::whereRaw('LENGTH(kodeKelompokKegiatan)=1')->get();
        $kegiatans = Kelompok_kegiatan::whereRaw('LENGTH(kodeKelompokKegiatan)=2')->get();
        $biayas = JenisBiayaProyek::whereRaw('LENGTH(kodeJenisBiaya)=3')->get();
        $proyeks=proyek::where('kodeProyek','=',session()->get('pilihanproyek'))->get();

        if(session()->has('baris')){
            for($i=1;$i<=session()->get('baris');$i++){
                session()->forget('kodeJenisBiaya_'.$i);
                session()->forget('volumeBiaya_'.$i );
                session()->forget('hargaSatBiaya_'.$i);
                session()->forget('totalBiaya_'.$i);
                session()->forget('grandTotBiaya_'.$i);
            }
             session()->forget('baris');
        }
        // $detailbiaya=RapBiaya::whereNonota($id)->distinct('noBarisKegiatan')->pluck('noBarisKegiatan')->toArray();
    
        $length= $detail->count();
        
        // exit();
        for ($value=1;$value<=$length;$value++) {
            $baris=$value;
           $kodejenis= RapBiaya::whereNonota($id)->where('noBarisKegiatan','=',$value)->where('kodePekerjaan','=',$kode_pekerjaan)->pluck('kodeJenisBiaya')->toArray();
           $volume= RapBiaya::whereNonota($id)->where('noBarisKegiatan','=',$value)->where('kodePekerjaan','=',$kode_pekerjaan)->pluck('qty')->toArray();
           $harsat= RapBiaya::whereNonota($id)->where('noBarisKegiatan','=',$value)->where('kodePekerjaan','=',$kode_pekerjaan)->pluck('harsat')->toArray();
           $sub= RapBiaya::whereNonota($id)->where('noBarisKegiatan','=',$value)->where('kodePekerjaan','=',$kode_pekerjaan)->selectRaw('harsat*qty as tot')->get()->toArray();
           $subtot= array();
           $grand=0;
           foreach ($sub as $a => $b) {
               array_push($subtot, $b['tot']);
               $grand+=$b['tot'];
           }
           // print_r($kodejenis);
           // echo $grand;
            session(['kodeJenisBiaya_'.$baris =>  $kodejenis]);
            session(['volumeBiaya_'.$baris =>  $volume]);
            session(['hargaSatBiaya_'.$baris =>  $harsat]);
            session(['totalBiaya_'.$baris =>  $subtot]);
            session(['grandTotBiaya_'.$baris =>  $grand]);
            
        }
        session(['baris'=>$length]);
        // print_r(session()->get('kodeJenisBiaya_1')); 
        // exit();

        
        return view('raps.edit', compact('rap','detail','pekerjaans','kegiatans','biayas','proyeks','kerja'));
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
        
        $kodeKelompokKegiatan = $request->get('kodeKelompokKegiatan');
        $minggu_mulai = $request->get('minggu_mulai');
        $lama = $request->get('lama');
        $volume = $request->get('volume');
        $total = $request->get('total');
        $grantot = $request->get('grandTot');
        $requestData = $request->all();
        $keterangan = $request->get('keterangan');
         $pekerjaan = $request->get('pekerjaan');
        $status = "belum disetujui";
        $arr = array();
        $kodeProyek = session()->get('pilihanproyek');
        $nonota = "P".$kodeProyek.'RA'.$request->get('nonota');
        
        $tgl = date_create($request->get('tglNota'));
        $kerja = $request->get('kerja');

        $rap = Rap::where('nonota', '=', $id)->first();
        $RapPekerjaan = $rap->detailpekerjaan($id);
        $RapKegiatan = RapKegiatan::where('nonota', '=', $id)->get();
        $RapBiaya = RapBiaya::where('nonota', '=', $id)->get();

        //SIMPAN RAP
        Rap::whereNonota($id)->update(['id_karyawan'=>auth::user()->id]);
        $nota =Rap::whereNonota($id)->first();

        //RapKegiatan::whereNonota($id)->where('kodeKelompokKegiatan','=',$kodeKelompokKegiatan)->where('kode_pekerjaan', '=', $pekerjaan)->delete();
        // RapBiaya::whereNonota($id)->delete();
        RapPekerjaan::whereNonota($id)->where('kodeKelompokKegiatan','=',$kerja)->delete();
        // Rap::whereNonota($id)->delete();
      //SIMPAN RAP
            // $nota = new Rap(array('nonota' => $nonota,
            //     'tglNota' => $tgl,
            //     'id_karyawan' => auth::user()->id,
            //     'kodeProyek' => $kodeProyek,
            //     'status' => $status,
            //     'validator' => 1,
            //     'created_at' => $request->get('created_at'),
            //     'keterangan'=> $keterangan
            //     ));
            // $nota->save();

            //SIMPAN RAP PEKERJAAN
            $RapPekerjaan = new RapPekerjaan(array('nonota' => $nonota,             
                'kodeKelompokKegiatan' => $pekerjaan,
                'keterangan'=> $keterangan
                ));
            $RapPekerjaan->save();  

            //SIMPAN RAP KEGIATAN
            for($i=0; $i<sizeof($volume); $i++){
                $baris = $i+1;

                $RapKegiatan = new RapKegiatan(array('nonota' => $nonota,    
                    'tglNota' => $tgl,            
                    'kodeKelompokKegiatan' => $kodeKelompokKegiatan[$i],
                    // 'keterangan' => $keterangan,
                    'minggu_mulai' => $minggu_mulai[$i],
                    'lama' => $lama[$i],
                    'volume' => $volume[$i],
                    'totalHarga' => $total[$i],
                    'noBaris' => $baris,
                    'kode_pekerjaan' => $pekerjaan
                    ));
                $RapKegiatan->save();   

            }
            //SIMPAN RAP BIAYA
            $baris=0;
            for($i=1;$i<=session()->get('baris');$i++){
                if(session()->get('kodeJenisBiaya_'.$i)){
                    $baris++;        

                    $kodebiaya=session()->get('kodeJenisBiaya_'.$i);
                    $volumeBiaya=session()->get('volumeBiaya_'.$i);
                    $hargaSatBiaya=session()->get('hargaSatBiaya_'.$i);

                    for($j=0; $j<sizeof($kodebiaya); $j++){
                        $barisbiaya = $j+1;

                        $RapBiaya = new RapBiaya(array('nonota' => $nonota,    
                            'tglNota' => $tgl,            
                            'kodeJenisBiaya' => $kodebiaya[$j],
                            'qty' => $volumeBiaya[$j],
                            'harsat' => $hargaSatBiaya[$j],
                            'noBaris' => $barisbiaya,
                            'noBarisKegiatan' => $baris
                            ));
                        $RapBiaya->save();
                    }
                }
            }
         session()->put('success','Data berhasil diubah');
        return redirect('raps');
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
        Rap::destroy($id);

        // session::flash('flash_message', 'Rap deleted!');

        return redirect('raps');
    }



    public function destroypekerjaan(Request $request, $id, $kerja)
    {
        RapPekerjaan::whereNonota($id)->where('kodeKelompokKegiatan','=',$kerja)->delete();
        RapBiaya::whereNonota($id)->where('kodePekerjaan','=',$kerja)->delete();
        // session::flash('flash_message', 'Rap deleted!');
         session()->put('success','Data berhasil dihapus');

        return redirect('raps');
    }

    public function getsatuanbiaya($id){
        $jenisbiaya=JenisBiayaProyek::where('kodeJenisBiaya','=',$id)->first();
        echo $jenisbiaya->satuan;
    }

    public function setsessionbiaya(Request $request){
        $baris = $request->get('noBarisModal');

        // session(['noBiaya_'.$baris =>  $request->get('noBiaya')]);
        session(['kodeJenisBiaya_'.$baris =>  $request->get('kodeJenisBiaya')]);
        session(['volumeBiaya_'.$baris =>  $request->get('volumeBiaya')]);
        session(['hargaSatBiaya_'.$baris =>  $request->get('hargaSatBiaya')]);
        session(['totalBiaya_'.$baris =>  $request->get('totalBiaya')]);
        session(['grandTotBiaya_'.$baris =>  $request->get('grandTotBiaya')]);
        session(['baris'=>$baris]);
            
        echo $request->get('grandTotBiaya');
    }

    public function getisimodal($no){
        $noBiaya = session()->get('noBiaya_'.$no);
        $satuan=array();

        $kodeJenisBiaya = array();
        foreach ( session()->get('kodeJenisBiaya_'.$no) as $item ) {
            $kodeJenisBiaya[] = array(
                $item
            );
             $jenisbiaya=JenisBiayaProyek::where('kodeJenisBiaya','=',$item)->first();
            $sat='';
            if($jenisbiaya->satuan)
                $sat=$jenisbiaya->satuan;
            array_push($satuan, $sat);
        }

        $volumeBiaya = array();
        foreach ( session()->get('volumeBiaya_'.$no) as $item ) {
            $volumeBiaya[] = array(
                $item
            );
        }

        $hargaSatBiaya = array();
        foreach ( session()->get('hargaSatBiaya_'.$no) as $item ) {
            $hargaSatBiaya[] = array(
                $item
            );
        }

        $totalBiaya = array();
        foreach ( session()->get('totalBiaya_'.$no) as $item ) {
            $totalBiaya[] = array(
                $item
            );
        }

        $grandTotBiaya = session()->get('grandTotBiaya_'.$no);

        $result = array(
                        'noBiaya'=>$noBiaya,
                        'kodeJenisBiaya'=>$kodeJenisBiaya, 
                        'volumeBiaya'=>$volumeBiaya,
                        'hargaSatBiaya'=>$hargaSatBiaya,
                        'totalBiaya'=>$totalBiaya,
                        'satuan'=>$satuan,
                        'grandTotBiaya'=>$grandTotBiaya);

        echo json_encode($result);
    }

    public function getmodalindex($nonota, $pekerjaan){
        $raps=RapKegiatan::join('kelompok_kegiatans', 'rap_kegiatans.kodeKelompokKegiatan', '=', 'kelompok_kegiatans.kodeKelompokKegiatan')->whereNonota($nonota)->whereKodePekerjaan($pekerjaan)->get()->toArray();
        echo json_encode($raps);

    }
}
