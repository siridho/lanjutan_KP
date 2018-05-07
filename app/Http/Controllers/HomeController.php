<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\proyek;
use App\gudang;
use App\material;
use App\alat;
use App\User;
use App\customer;
use App\mitraKerja;
use App\BiayaKas;
use App\MaterialProyek;
use App\NotaBeliMaterial;
use App\DetailBeliMaterial;
use App\NotaPengeluaranKass;
use App\DetailPengeluaranKass;
use App\NotaPenggunaanMaterial;
use App\NotaKasMasuk;
use App\DetailNotaKasMasuk;
use App\DetailPenggunaanMaterial;
use App\NotaTerimaBarang;
use App\DetailTerimaBarang;
use App\JenisBiayaProyek;
use App\Memo_proyek;
use App\Detail_memo_proyek;
use App\Opname_volume_pekerjaan;
use App\Detail_opname_pekerjaan;
use App\kelompok_kegiatan;
use App\Rap;
use PDF;
use DB;
use Excel;
use session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $proyek = proyek::where('kodeProyek', '=', '001')->first();
        // session(['pilihanproyek' =>  $proyek->kodeProyek]);
        // session(['namaproyek' =>  $proyek->uraian]);
    

        $kasmasuk = DetailNotaKasMasuk::select(DB::raw("SUM(saldo) as count"),DB::raw('month(tglNota) bulan'))
            ->groupBy("bulan")
            ->get()->toArray();
        $kas = array_column($kasmasuk, 'count');
        // dd($kas);
        //print_r($kas);
        $itung=1;
        $kasmasuk=array();
        for ($i=0;$i<sizeof($kas);$i++) {
            $jum=$kas[$i];
            for($j=0;$j<$i;$j++){
                $jum+=$kas[$j];
                // echo $jum.' ';
            }
            $kasmasuk[$i]=$jum;
        }

        // dd($arr);

        // print_r($kasmasuk);
        $kaskeluar = DetailPengeluaranKass::select(DB::raw("SUM(harga) as count"),DB::raw('month(tglNota) bulan'))
            ->groupBy("bulan")
            ->get()->toArray();
        $kas = array_column($kaskeluar, 'count');

        $kaskeluar=array();
        for ($i=0;$i<sizeof($kas);$i++) {
            $jum=$kas[$i];
            for($j=0;$j<$i;$j++){
                $jum+=$kas[$j];
                // echo $jum.' ';
            }
            $kaskeluar[$i]=$jum;
        }
        // print_r($kaskeluar);
        array_push($kasmasuk, 0);

        $bulan = DetailPengeluaranKass::select(DB::raw('distinct concat(year(tglNota),"-",month(tglNota)) bulan'))->get()->toArray();
            // print_r($bulan);
        $bulan = array_column($bulan, 'bulan');
            $i=0;
            $arr=array();

        // $arr['year']=$bulan;
        // $arr['value']=$kasmasuk;
        // $arr['value2']=$kaskeluar;

        foreach ($bulan as $key => $value) {
            $hmm=(!isset($kasmasuk[$i]))?null:$kasmasuk[$i];
            $aa=array($value,$hmm,$kaskeluar[$i]);
            // $aa=array('year'=>$value,'value'=>$hmm,'value2'=>$kaskeluar[$i]);
            array_push($arr, $aa);
            $i++;
        }

        // print_r($arr);exit();


        return view('home')
            ->with('kasmasuk',json_encode($kasmasuk,JSON_NUMERIC_CHECK))
            ->with('kaskeluar',json_encode($kaskeluar,JSON_NUMERIC_CHECK))
            ->with('bulan',json_encode($bulan,JSON_NUMERIC_CHECK))
            ->with('data',$arr);
    }

    public function pilihproyek(){
        $proyeks = proyek::all();
        // print_r($proyek);
        // exit();
        return view('pilihproyek',compact('proyeks'));
      
    }

    public function pilihproyekk(Request $request){
        $pilihanproyek = $request->get('pilihanproyek');
        $proyek = proyek::where('kodeProyek', '=', $pilihanproyek)->first();
        // echo $proyek->uraian;
        if(session()->get('pilihanproyek')){
            session()->forget('pilihanproyek');
            session()->forget('namaproyek');
        }
        // $request->session()->put('pilihanproyek', $proyek->kodeProyek);
        // $request->session()->put('namaproyek', $proyek->uraian);
        session(['pilihanproyek' => $proyek->kodeProyek]);
        session(['namaproyek' => $proyek->uraian]);
        return redirect('/home');
    }

    public function imporLapangan(){
        return view('ekspor-impor.imporLapangan');
    }

    public function imporPusat(){
        return view('ekspor-impor.imporPusat');
    }

    public function imporLapangancsv(Request $request){
            if($request->hasFile('material')){
                $pathMaterial=$request->file('material')->getRealPath();
                $nameMaterial=$request->file('material')->getClientOriginalName();
                $splitMaterial=str_split($nameMaterial,1);
                $splitExtension=explode('.',$nameMaterial);
                if ($splitMaterial[0]=='M' && $splitExtension[1]=='xls')
                {
                    DB::statement("SET foreign_key_checks = 0");
                    DB::table('materials')->truncate();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    $dataMaterial=Excel::load($pathMaterial, function($reader){})->get();
                    if(!empty($dataMaterial) && $dataMaterial->count()){
                        foreach ($dataMaterial->toArray() as $key => $value) {
                                $insertMaterial[]=['kodeMaterial'=>$value['kodematerial'],'nama'=>$value['nama'],'satuan'=>$value['satuan'],'keterangan'=>$value['keterangan'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertMaterial))
                        material::insert($insertMaterial);
                    }
                }
                else{
                    session()->put('error','Pastikan Data yang Diimpor Adalah Data Material');
                    return redirect('imporLapangan');
                }
            }
            
            if($request->hasFile('alat')){
                $pathAlat=$request->file('alat')->getRealPath();
                $nameAlat=$request->file('alat')->getClientOriginalName();
                $splitAlat=str_split($nameAlat,1);
                $splitExtension=explode('.',$nameAlat);
                if($splitAlat[0]=='A' && $splitExtension[1]=='xls')
                {
                    DB::statement("SET foreign_key_checks = 0");
                    DB::table('alats')->truncate();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    $dataAlat=Excel::load($pathAlat, function($reader){})->get();
                    if(!empty($dataAlat) && $dataAlat->count()){
                        foreach ($dataAlat->toArray() as $key => $value) {
                                $insertAlat[]=['kodeAlat'=>$value['kodealat'],'nama'=>$value['nama'],'created_at'=>$value['created_at'],'keterangan'=>$value['keterangan'],'masapakai'=>$value['masapakai'],'Satuan'=>$value['satuan'],'kelompokUtilitas'=>$value['kelompokutilitas'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertAlat))
                        alat::insert($insertAlat);
                    }
                    else{
                        session()->put('error','Pastikan Data yang Diimpor Adalah Data Alat');
                        return redirect('imporLapangan');
                    }
                }
            }
            if($request->hasFile('proyek')){
                $pathProyek=$request->file('proyek')->getRealPath();
                $nameProyek=$request->file('proyek')->getClientOriginalName();
                $splitProyek=str_split($nameProyek,1);
                $splitExtension=explode('.',$nameProyek);
                if($splitProyek[0]=='P' && $splitExtension[1]=='xls')
                {
                    DB::statement("SET foreign_key_checks = 0");
                    DB::table('proyeks')->truncate();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    $dataProyek=Excel::load($pathProyek, function($reader){})->get();
                    if(!empty($dataProyek) && $dataProyek->count()){
                        foreach ($dataProyek->toArray() as $key => $value) {
                                $insertProyek[]=['kodeProyek'=>$value['kodeproyek'],'kodeCustomer'=>$value['kodecustomer'],'kodeManager'=>$value['kodemanager'],'uraian'=>$value['uraian'],'jenis'=>$value['jenis'],'volume'=>$value['volume'],'waktu'=>$value['waktu'],'tanggalMulai'=>$value['tanggalmulai'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertProyek))
                        proyek::insert($insertProyek);
                    }
                    else{
                        session()->put('error','Pastikan Data yang Diimpor Adalah Data Proyek');
                        return redirect('imporLapangan');
                    }
                }
            }
            if($request->hasFile('user')){
                $pathUser=$request->file('user')->getRealPath();
                $nameUser=$request->file('user')->getClientOriginalName();
                $splitUser=str_split($nameUser,1);
                $splitExtension=explode('.',$nameUser);
                if($splitUser[0]=='U' && $splitExtension[1]=='xls')
                {
                    DB::statement("SET foreign_key_checks = 0");
                    DB::table('users')->truncate();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    $dataUser=Excel::load($pathUser, function($reader){})->get();
                    if(!empty($dataUser) && $dataUser->count()){
                        foreach ($dataUser->toArray() as $key => $value) {
                                $insertUser[]=['id'=>$value['id'],'username'=>$value['username'],'nama'=>$value['nama'],'email'=>$value['email'],'password'=>$value['password'],'level'=>$value['level'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertUser))
                        User::insert($insertUser);
                    }
                    else{
                        session()->put('error','Pastikan Data yang Diimpor Adalah Data User');
                        return redirect('imporLapangan');
                    }
                }
            }
            if($request->hasFile('manager')){
                $pathManager=$request->file('manager')->getRealPath();
                $nameManager=$request->file('manager')->getClientOriginalName();
                $splitManager=str_split($nameManager,2);
                $splitExtension=explode('.',$nameManager);
                if($splitUser[0]=='MP' && $splitExtension[1]=='xls')
                {
                    DB::statement("SET foreign_key_checks = 0");
                    DB::table('manager_proyeks')->truncate();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    $dataManager=Excel::load($pathManager, function($reader){})->get();
                    if(!empty($dataManager) && $dataManager->count()){
                        foreach ($dataManager->toArray() as $key => $value) {
                                $insertManager[]=['kodeManager'=>$value['kodemanager'],'nama'=>$value['nama'],'alamat'=>$value['alamat'],'identitas'=>$value['identitas'],'tanggalMasuk'=>$value['tanggalmasuk'],'email'=>$value['email'],'telepon'=>$value['telepon'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                                
                        }
                        if(!empty($insertManager))
                        managerProyek::insert($insertManager);
                    }
                    else{
                        session()->put('error','Pastikan Data yang Diimpor Adalah Data Manager');
                        return redirect('imporLapangan');
                    }
                }
            }
            if($request->hasFile('pelanggan')){
                $pathPelanggan=$request->file('pelanggan')->getRealPath();
                $namePelanggan=$request->file('pelanggan')->getClientOriginalName();
                $splitPelanggan=str_split($namePelanggan,1);
                $splitExtension=explode('.',$namePelanggan);
                if($splitPelanggan[0]=='C' && $splitExtension[1]=='xls')
                {
                    DB::statement("SET foreign_key_checks = 0");
                    DB::table('customers')->truncate();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    $dataPelanggan=Excel::load($pathPelanggan, function($reader){})->get();
                    if(!empty($dataPelanggan) && $dataPelanggan->count()){
                        foreach ($dataPelanggan->toArray() as $key => $value) {
                            $insertPelanggan[]=['kodeCustomer'=>$value['kodecustomer'],'nama'=>$value['nama'],'alamat'=>$value['alamat'],'area'=>$value['area'],'telepon'=>$value['telepon'],'email'=>$value['email'],'npwp'=>$value['npwp'],'kontakNama'=>$value['kontaknama'],'kontakTelepon'=>$value['kontaktelepon'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];  
                        }
                        if(!empty($insertPelanggan))
                        customer::insert($insertPelanggan);
                    }
                }
            }
            if($request->hasFile('mitra')){
                $pathMitra=$request->file('mitra')->getRealPath();
                $nameMitra=$request->file('mitra')->getClientOriginalName();
                $splitMitra=str_split($nameMitra,2);
                $splitExtension=explode('.',$nameMitra);
                if($splitMitra[0]=='MK' && $splitExtension[1]=='xls')
                {
                    DB::statement("SET foreign_key_checks = 0");
                    DB::table('mitra_kerjas')->truncate();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    $dataMitra=Excel::load($pathMitra, function($reader){})->get();
                    if(!empty($dataMitra) && $dataMitra->count()){
                        foreach ($dataMitra->toArray() as $key => $value) {
                                $insertMitra[]=['kodeMitra'=>$value['kodemitra'],'nama'=>$value['nama'],'alamat'=>$value['alamat'],'telepon'=>$value['telepon'],'email'=>$value['email'],'npwp'=>$value['npwp'],'kontakNama'=>$value['kontaknama'],'kontakTelepon'=>$value['kontaktelepon'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertMitra))
                        mitraKerja::insert($insertMitra);
                    }
                    else{
                        session()->put('error','Pastikan Data yang Diimpor Adalah Data Mitra Keuangan');
                        return redirect('imporLapangan');
                    }
                }
            }
            if($request->hasFile('gudang')){
                $pathGudang=$request->file('gudang')->getRealPath();
                $nameGudang=$request->file('gudang')->getClientOriginalName();
                $splitGudang=str_split($nameGudang,1);
                $splitExtension=explode('.',$nameGudang);
                if($splitGudang[0]=='G' && $splitExtension[1]=='xls')
                {
                    DB::statement("SET foreign_key_checks = 0");
                    DB::table('gudangs')->truncate();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    $dataGudang=Excel::load($pathGudang, function($reader){})->get();
                    if(!empty($dataGudang) && $dataGudang->count()){
                        foreach ($dataGudang->toArray() as $key => $value) {
                                $insertGudang[]=['kodeGudang'=>$value['kodegudang'],'nama'=>$value['nama'],'keterangan'=>$value['keterangan'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']]; 
                        }
                        if(!empty($insertGudang))
                        gudang::insert($insertGudang);
                    }
                    else{
                        session()->put('error','Pastikan Data yang Diimpor Adalah Data Gudang');
                        return redirect('imporLapangan');
                    }
                }
            }
            if($request->hasFile('biayaKas')){
                $pathBiayaKas=$request->file('biayaKas')->getRealPath();
                $nameBiayaKas=$request->file('biayaKas')->getClientOriginalName();
                $splitBiayaKas=str_split($nameBiayaKas,2);
                $splitExtension=explode('.',$nameBiayaKas);
                if($splitBiayaKas[0]=='BK' && $splitExtension[1]=='xls')
                {
                    DB::statement("SET foreign_key_checks = 0");
                    DB::table('biaya_kas')->truncate();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    $dataBiayaKas=Excel::load($pathBiayaKas, function($reader){})->get();
                    if(!empty($dataBiayaKas) && $dataBiayaKas->count()){
                        foreach ($dataBiayaKas->toArray() as $key => $value) {
                                $insertBiayaKas[]=['kodeBiayaKas'=>$value['kodebiayakas'],'nama'=>$value['nama'],'satuan'=>$value['satuan'],'keterangan'=>$value['keterangan'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertBiayaKas))
                        BiayaKas::insert($insertBiayaKas);
                    }
                }
                else{
                    session()->put('error','Pastikan Data yang Diimpor Adalah Data Biaya Kas');
                    return redirect('imporLapangan');
                }
            }

            if($request->hasFile('jenisBiayaProyek')){
                $pathJenisBiaya=$request->file('jenisBiayaProyek')->getRealPath();
                $nameJenisBiaya=$request->file('jenisBiayaProyek')->getClientOriginalName();
                $splitJenisBiaya=str_split($nameJenisBiaya,3);
                $splitExtension=explode('.',$nameJenisBiaya);
                if($splitJenisBiaya[0]=='JBP' && $splitExtension[1]=='xls')
                {
                    DB::statement("SET foreign_key_checks = 0");
                    DB::table('jenis_biaya_proyeks')->truncate();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    $dataJenisBiaya=Excel::load($pathJenisBiaya, function($reader){})->get();
                    if(!empty($dataJenisBiaya) && $dataJenisBiaya->count()){
                        foreach ($dataJenisBiaya->toArray() as $key => $value) {
                                $insertBiayaKass[]=['kodeJenisBiaya'=>$value['kodejenisbiaya'],'nama'=>$value['nama'],'satuan'=>$value['satuan'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertBiayaKass))
                        JenisBiayaProyek::insert($insertBiayaKass);
                    }
                }
                else{
                    session()->put('error','Pastikan Data yang Diimpor Adalah Data Jenis Biaya Proyek');
                    return redirect('imporLapangan');
                }
            }

            if($request->hasFile('kelompokKegiatan')){
                $pathkelompokKegiatan=$request->file('kelompokKegiatan')->getRealPath();
                $namekelompokKegiatan=$request->file('kelompokKegiatan')->getClientOriginalName();
                $splitkelompokKegiatan=str_split($namekelompokKegiatan,2);
                $splitExtension=explode('.',$namekelompokKegiatan);
                if($splitkelompokKegiatan[0]=='KG' && $splitExtension[1]=='xls')
                {
                    DB::statement("SET foreign_key_checks = 0");
                    DB::table('kelompok_kegiatans')->truncate();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    $datakelompokKegiatan=Excel::load($pathkelompokKegiatan, function($reader){})->get();
                    if(!empty($datakelompokKegiatan) && $datakelompokKegiatan->count()){
                        foreach ($datakelompokKegiatan->toArray() as $key => $value) {
                                $insertkelompokKegiatan[]=['kodeKelompokKegiatan'=>$value['kodekelompokkegiatan'],'nama'=>$value['nama'],'satuan'=>$value['satuan'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                                
                        }
                        if(!empty($insertkelompokKegiatan))
                        kelompok_kegiatan::insert($insertkelompokKegiatan);
                    }
                    else{
                        session()->put('error','Pastikan Data yang Diimpor Adalah Data Kelompok Kegiatan');
                        return redirect('imporLapangan');
                    }
                }
            }

            session()->put('success','Data Berhasil Diinputkan');
            return redirect('imporLapangan');
    }

    public function imporPusatcsv(Request $request){
    
            if($request->hasFile('beli')){
                $pathBeli=$request->file('beli')->getRealPath();
                $nameBeli=$request->file('beli')->getClientOriginalName();
                $splitBeli=str_split($nameBeli,2);
                $splitExtension=explode('.',$nameBeli);
                if ($splitBeli[0]=='BE' && $splitExtension[1]=='xls')
                {
                    $dataBeli=Excel::selectSheetsByIndex(0)->load($pathBeli, function($reader){})->get();
                    $dataDetailBeli=Excel::selectSheetsByIndex(1)->load($pathBeli, function($reader){})->get();
                    if(!empty($dataBeli) && $dataBeli->count()){
                        foreach ($dataBeli->toArray() as $key => $value) {
                                $insertBeli[]=['nonota'=>$value['nonota'],'id_karyawan'=>$value['id_karyawan'],'kodeMitra'=>$value['kodemitra'],'tglNota'=>$value['tglnota'],'status'=>$value['status'],'status_barang'=>$value['status_barang'],'kodeProyek'=>$value['kodeproyek'],'status_nota'=>$value['status_nota'],'validator'=>$value['validator'],'waktu_valid'=>$value['waktu_valid'],'referensi'=>$value['referensi'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertBeli))
                        NotaBeliMaterial::insert($insertBeli);
                    }
                    if(!empty($dataDetailBeli) && $dataDetailBeli->count()){
                        foreach ($dataDetailBeli->toArray() as $key => $value) {
                                $insertDetailBeli[]=['nonota'=>$value['nonota'],'kode_material'=>$value['kode_material'],'qty'=>$value['qty'],'noBaris'=>$value['nobaris'],'keterangan'=>$value['keterangan'],'harga'=>$value['harga'],'tglNota'=>$value['tglnota'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertDetailBeli))
                        DetailBeliMaterial::insert($insertDetailBeli);
                    }
                }
                else{
                    session()->put('error','Pastikan Data yang Diimpor Adalah Data Pembelian Material');
                    return redirect('imporPusat');
                }
            }

             if($request->hasFile('terima')){
                $pathTerima=$request->file('terima')->getRealPath();
                $nameTerima=$request->file('terima')->getClientOriginalName();
                $splitTerima=str_split($nameTerima,2);
                $splitExtension=explode('.',$nameTerima);
                if ($splitTerima[0]=='TB' && $splitExtension[1]=='xls')
                {
                    $dataTerima=Excel::selectSheetsByIndex(0)->load($pathTerima, function($reader){})->get();
                    $dataDetailTerima=Excel::selectSheetsByIndex(1)->load($pathTerima, function($reader){})->get();
                    // print_r($dataDetailTerima);exit();
                    if(!empty($dataTerima) && $dataTerima->count()){
                        foreach ($dataTerima->toArray() as $key => $value) {
                                $insertTerima[]=['nonota'=>$value['nonota'],'id_karyawan'=>$value['id_karyawan'],'nonota_beli'=>$value['nonota_beli'],'kodeMitra'=>$value['kodemitra'],'tglNota'=>$value['tglnota'],'status'=>$value['status'],'kodeProyek'=>$value['kodeproyek'],'status_nota'=>$value['status_nota'],'validator'=>$value['validator'],'waktu_valid'=>$value['waktu_valid'],'referensi'=>$value['referensi'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertTerima))
                        NotaTerimaBarang::insert($insertTerima);
                    }
                    if(!empty($dataDetailTerima) && $dataDetailTerima->count()){
                        foreach ($dataDetailTerima->toArray() as $key => $value) {
                            // echo $value['nonota'];exit();
                                $insertDetailTerima[]=['nonota'=>$value['nonota'],'kode_material'=>$value['kode_material'],'jumlah'=>$value['jumlah'],'noBaris'=>$value['nobaris'],'baris_detail_beli'=>$value['baris_detail_beli'],'keterangan'=>$value['keterangan'],'kodeProyek'=>$value['kodeproyek'],'tglNota'=>$value['tglnota'],'harga'=>$value['harga'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertDetailTerima))
                        DetailTerimaBarang::insert($insertDetailTerima);
                    }
                }
                else{
                    session()->put('error','Pastikan Data yang Diimpor Adalah Data Penerimaan Material');
                    return redirect('imporPusat');
                }
            }

             if($request->hasFile('guna')){
                $pathPenggunaan=$request->file('guna')->getRealPath();
                $namePenggunaan=$request->file('guna')->getClientOriginalName();
                $splitPenggunaan=str_split($namePenggunaan,2);
                $splitExtension=explode('.',$namePenggunaan);
                if ($splitPenggunaan[0]=='PM' && $splitExtension[1]=='xls')
                {
                    $dataPenggunaan=Excel::selectSheetsByIndex(0)->load($pathPenggunaan, function($reader){})->get();
                    $dataDetailPenggunaan=Excel::selectSheetsByIndex(1)->load($pathPenggunaan, function($reader){})->get();
                    if(!empty($dataPenggunaan) && $dataPenggunaan->count()){
                        foreach ($dataPenggunaan->toArray() as $key => $value) {
                                $insertPenggunaan[]=['nonota'=>$value['nonota'],'id_karyawan'=>$value['id_karyawan'],'kodeProyek'=>$value['kodeproyek'],'tanggalNota'=>$value['tanggalnota'],'status_nota'=>$value['status_nota'],'validator'=>$value['validator'],'waktu_valid'=>$value['waktu_valid'],'referensi'=>$value['referensi'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertPenggunaan))
                        NotaPenggunaanMaterial::insert($insertPenggunaan);
                    }
                    if(!empty($dataDetailPenggunaan) && $dataDetailPenggunaan->count()){
                        foreach ($dataDetailPenggunaan->toArray() as $key => $value) {
                                $insertDetailPenggunaan[]=['nonota'=>$value['nonota'],'kodeMaterial'=>$value['kodematerial'],'jumlah'=>$value['jumlah'],'keterangan'=>$value['keterangan'],'noBaris'=>$value['nobaris'],'tglNota'=>$value['tglnota'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertDetailPenggunaan))
                        DetailPenggunaanMaterial::insert($insertDetailPenggunaan);
                    }
                }
                else{
                    session()->put('error','Pastikan Data yang Diimpor Adalah Data Penggunaan Material');
                    return redirect('imporPusat');
                }
            }

            if($request->hasFile('kasKeluar')){
                $pathKas=$request->file('kasKeluar')->getRealPath();
                $nameKas=$request->file('kasKeluar')->getClientOriginalName();
                $splitKas=str_split($nameKas,2);
                $splitExtension=explode('.',$nameKas);
                if ($splitKas[0]=='KK' && $splitExtension[1]=='xls')
                {
                    $dataKas=Excel::selectSheetsByIndex(0)->load($pathKas, function($reader){})->get();
                    $dataDetailKas=Excel::selectSheetsByIndex(1)->load($pathKas, function($reader){})->get();
                    if(!empty($dataKas) && $dataKas->count()){
                        foreach ($dataKas->toArray() as $key => $value) {
                                $insertKas[]=['nonota'=>$value['nonota'],'id_karyawan'=>$value['id_karyawan'],'tglNota'=>$value['tglnota'],'kodeProyek'=>$value['kodeproyek'],'status_nota'=>$value['status_nota'],'validator'=>$value['validator'],'waktu_valid'=>$value['waktu_valid'],'referensi'=>$value['referensi'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertKas))
                        NotaPengeluaranKass::insert($insertKas);
                    }
                    if(!empty($dataDetailKas) && $dataDetailKas->count()){
                        foreach ($dataDetailKas->toArray() as $key => $value) {
                                $insertDetailKas[]=['nonota'=>$value['nonota'],'tglNota'=>$value['tglnota'],'uraian'=>$value['uraian'],'noBaris'=>$value['nobaris'],'kodeBiayaKas'=>$value['kodebiayakas'],'kodeAlat'=>$value['kodealat'],'harga'=>$value['harga'],'jumlah'=>$value['jumlah'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertDetailKas))
                        DetailPengeluaranKass::insert($insertDetailKas);
                    }
                }
                else{
                    session()->put('error','Pastikan Data yang Diimpor Adalah Kas Keluar');
                    return redirect('imporPusat');
                }
            }

            if($request->hasFile('kasMasuk')){
                $pathKas=$request->file('kasMasuk')->getRealPath();
                $nameKas=$request->file('kasMasuk')->getClientOriginalName();
                $splitKas=str_split($nameKas,2);
                $splitExtension=explode('.',$nameKas);
                if ($splitKas[0]=='KM' && $splitExtension[1]=='xls')
                {
                    $dataKas=Excel::selectSheetsByIndex(0)->load($pathKas, function($reader){})->get();
                    $dataDetailKasMasuk=Excel::selectSheetsByIndex(1)->load($pathKas, function($reader){})->get();
                    if(!empty($dataKas) && $dataKas->count()){
                        foreach ($dataKas->toArray() as $key => $value) {
                                $insertKas[]=['nonota'=>$value['nonota'],'id_karyawan'=>$value['id_karyawan'],'tglNota'=>$value['tglnota'],'kodeProyek'=>$value['kodeproyek'],'status_nota'=>$value['status_nota'],'validator'=>$value['validator'],'waktu_valid'=>$value['waktu_valid'],'referensi'=>$value['referensi'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertKas))
                        NotaKasMasuk::insert($insertKas);
                    }
                    if(!empty($dataDetailKasMasuk) && $dataDetailKasMasuk->count()){
                        foreach ($dataDetailKasMasuk->toArray() as $key => $value) {
                                $insertDetailKasMasuk[]=['nonota'=>$value['nonota'],'tglNota'=>$value['tglnota'],'uraian'=>$value['uraian'],'noBaris'=>$value['nobaris'],'saldo'=>$value['saldo'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertDetailKasMasuk))
                        DetailNotaKasMasuk::insert($insertDetailKasMasuk);
                    }
                }
                else{
                    session()->put('error','Pastikan Data yang Diimpor Adalah Data Kas Masuk');
                    return redirect('imporPusat');
                }
            }

            if($request->hasFile('memo')){
                $pathMemo=$request->file('memo')->getRealPath();
                $nameMemo=$request->file('memo')->getClientOriginalName();
                $splitMemo=str_split($nameMemo,2);
                $splitExtension=explode('.',$nameMemo);
                if ($splitMemo[0]=='MP' && $splitExtension[1]=='xls')
                {
                    $dataMemo=Excel::selectSheetsByIndex(0)->load($pathMemo, function($reader){})->get();
                    $dataDetailMemo=Excel::selectSheetsByIndex(1)->load($pathMemo, function($reader){})->get();
                    if(!empty($dataMemo) && $dataMemo->count()){
                        foreach ($dataMemo->toArray() as $key => $value) {
                                $insertMemo[]=['nonota'=>$value['nonota'],'id_karyawan'=>$value['id_karyawan'],'tgl'=>$value['tgl'],'kodeProyek'=>$value['kodeproyek'],'status_nota'=>$value['status_nota'],'validator'=>$value['validator'],'waktu_valid'=>$value['waktu_valid'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertMemo))
                        Memo_proyek::insert($insertMemo);
                    }
                    if(!empty($dataDetailMemo) && $dataDetailMemo->count()){
                        foreach ($dataDetailMemo->toArray() as $key => $value) {
                                $insertDetailMemo[]=['nonota'=>$value['nonota'],'tglNota'=>$value['tglnota'],'uraian'=>$value['uraian'],'noBaris'=>$value['nobaris'],'nilai'=>$value['nilai'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertDetailMemo))
                        Detail_memo_proyek::insert($insertDetailMemo);
                    }
                }
                else{
                    session()->put('error','Pastikan Data yang Diimpor Adalah Data Memo Proyek');
                    return redirect('imporPusat');
                }
            }              

            if($request->hasFile('opname')){
                $pathopname=$request->file('opname')->getRealPath();
                $nameopname=$request->file('opname')->getClientOriginalName();
                $splitopname=str_split($nameopname,2);
                $splitExtension=explode('.',$nameopname);
                if ($splitopname[0]=='OP' && $splitExtension[1]=='xls')
                {
                    $dataopname=Excel::selectSheetsByIndex(0)->load($pathopname, function($reader){})->get();
                    $dataDetailopname=Excel::selectSheetsByIndex(1)->load($pathopname, function($reader){})->get();
                    if(!empty($dataopname) && $dataopname->count()){
                        foreach ($dataopname->toArray() as $key => $value) {
                                $insertopname[]=['nonota'=>$value['nonota'],'idKaryawan'=>$value['idkaryawan'],'tglNota'=>$value['tglnota'],'kodeProyek'=>$value['kodeproyek'],'status_nota'=>$value['status_nota'],'validator'=>$value['validator'],'waktu_valid'=>$value['waktu_valid'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertopname))
                        Opname_volume_pekerjaan::insert($insertopname);
                    }
                    if(!empty($dataDetailopname) && $dataDetailopname->count()){
                        foreach ($dataDetailopname->toArray() as $key => $value) {
                                $insertDetailopname[]=['nonota'=>$value['nonota'],'tglNota'=>$value['tglnota'],'kodeKelompokKegiatan'=>$value['kodekelompokkegiatan'],'noBaris'=>$value['nobaris'],'volume'=>$value['volume'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertDetailopname))
                        Detail_opname_pekerjaan::insert($insertDetailopname);
                    }
                }
                else{
                    session()->put('error','Pastikan Data yang Diimpor Adalah Data Opname Volume Pekerjaan Proyek');
                    return redirect('imporPusat');
                }
            }

            if($request->hasFile('netral')){
                $pathnetral=$request->file('netral')->getRealPath();
                $namenetral=$request->file('netral')->getClientOriginalName();
                $splitnetral=str_split($namenetral,2);
                $splitExtension=explode('.',$namenetral);
                if ($splitnetral[0]=='PK' && $splitExtension[1]=='xls')
                {
                    $datanetral=Excel::selectSheetsByIndex(0)->load($pathnetral, function($reader){})->get();
                    $dataDetailnetral=Excel::selectSheetsByIndex(1)->load($pathnetral, function($reader){})->get();
                    if(!empty($datanetral) && $datanetral->count()){
                        foreach ($datanetral->toArray() as $key => $value) {
                                $insertnetral[]=['nonota'=>$value['nonota'],'id_karyawan'=>$value['id_karyawan'],'tglNota'=>$value['tglnota'],'kodeProyek'=>$value['kodeproyek'],'status_nota'=>$value['status_nota'],'validator'=>$value['validator'],'waktu_valid'=>$value['waktu_valid'],'referensi'=>$value['referensi'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                            }
                            if(!empty($insertnetral))
                            NotaPengeluaranKass::insert($insertnetral);
                        }
                    if(!empty($dataDetailnetral) && $dataDetailnetral->count()){
                        foreach ($dataDetailnetral->toArray() as $key => $value) {
                                $insertDetailnetral[]=['nonota'=>$value['nonota'],'tglNota'=>$value['tglnota'],'uraian'=>$value['uraian'],'noBaris'=>$value['nobaris'],'kodeBiayaKas'=>$value['kodebiayakas'],'kodeAlat'=>$value['kodealat'],'harga'=>$value['harga'],'jumlah'=>$value['jumlah'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                        }
                        if(!empty($insertDetailnetral))
                        DetailPengeluaranKass::insert($insertDetailopname);
                    }
                }
                else{
                    session()->put('error','Pastikan Data yang Diimpor Adalah Data Penetralan Kasbon Proyek');
                    return redirect('imporPusat');
                }
            } 

            if($request->hasFile('rap')){
                $pathrap=$request->file('rap')->getRealPath();
                $namerap=$request->file('rap')->getClientOriginalName();
                $splitrap=str_split($namerap,3);
                $splitExtension=explode('.',$namerap);
                if ($splitrap[0]=='RAP' && $splitExtension[1]=='xls')
                {
                    
                }
                else{
                    session()->put('error','Pastikan Data yang Diimpor Adalah Data Rencana Angaran Proyek');
                    return redirect('imporPusat');
                }
            } 



            
            // return redirect('imporPusat');\
            return redirect('itungstok');
    }

    public function printmaster($nama){
        if($nama=="material"){
            $data=material::all();
            $pdf = PDF::loadView('pdf.material-pdf', ['data'=>$data]);
            return $pdf->download('Laporan-Material.pdf');
        }
        elseif($nama=="alat"){
            $data=alat::all();
            $pdf = PDF::loadView('pdf.alat-pdf', ['data'=>$data]);
            return $pdf->download('Laporan-Alat.pdf');
        }
        elseif($nama=="biayakas"){
            $data=BiayaKas::all();
            $pdf = PDF::loadView('pdf.biaya-kas-pdf', ['data'=>$data]);
            return $pdf->download('Laporan-Biaya-Kas.pdf');
        }
          elseif($nama=="proyek"){
            $data=proyek::all();
            $pdf = PDF::loadView('pdf.proyek-pdf', ['data'=>$data]);
            return $pdf->download('Laporan-Alat.pdf');
        }
        elseif($nama=="jenisbiayaproyek"){
            $data=JenisBiayaProyek::all();
            $pdf = PDF::loadView('pdf.jenis-biaya-proyek-pdf', ['data'=>$data]);
            return $pdf->download('Laporan-Jenis-Biaya-Proyek.pdf');
        }
        elseif($nama=="user"){
            $data=User::orderBy('level','asc')->get();
            $pdf = PDF::loadView('pdf.user-pdf', ['data'=>$data]);
            return $pdf->download('Laporan-User-EDP.pdf');
        }

    }

    public function printnota($nama,$kode){
        $namaproyek=session()->get('namaproyek');
        if($nama=='beli'){
            $notabelimaterial = NotaBeliMaterial::where('nonota','=',$kode)->first();
            $detailnota=$notabelimaterial->detailnota;
            $pdf = PDF::loadView('pdf.nota-beli-pdf',['notabelimaterial'=>$notabelimaterial,'detailnota'=>$detailnota])->setPaper('a4','landscape');
            return $pdf->download('nota_beli_proyek_'.$namaproyek.'_'.$notabelimaterial->tglNota.'.pdf');
        }
        elseif($nama=='terima'){
            $notaterimabarang = NotaTerimaBarang::where('nonota','=',$kode)->first();
            $detailnota=$notaterimabarang->detailterima;
            $pdf = PDF::loadView('pdf.nota-terima-pdf',['notaterimabarang'=>$notaterimabarang,'detailnota'=>$detailnota])->setPaper('a4','landscape');
            return $pdf->download('nota_terima_proyek_'.$namaproyek.'_'.$notaterimabarang->tglNota.'.pdf');
        }
        elseif($nama=='guna'){
            $notapenggunaanmaterial = NotaPenggunaanMaterial::where('nonota', '=', $kode)->first();
            $detailnota=$notapenggunaanmaterial->detailnota;
            $pdf = PDF::loadView('pdf.nota-penggunaan-pdf',['notapenggunaanmaterial'=>$notapenggunaanmaterial,'detailnota'=>$detailnota])->setPaper('a4','landscape');
            return $pdf->download('nota_penggunaan_proyek_'.$namaproyek.'_'.$notapenggunaanmaterial->tglNota.'.pdf');
        }
        elseif($nama=='terimakas'){
            $notakasmasuk = NotaKasMasuk::where('nonota','=',$kode)->first();
            $detailnota=$notakasmasuk->detailnota;
            $pdf = PDF::loadView('pdf.nota-terima-kas-pdf',['notakasmasuk'=>$notakasmasuk,'detailnota'=>$detailnota])->setPaper('a4','landscape');
            return $pdf->download('nota_penerimaan_kas_proyek_'.$namaproyek.'_'.$notakasmasuk->tglNota.'.pdf');
        }
        elseif($nama=='keluarkas'){
            $notapengeluarankass = NotaPengeluaranKass::where('nonota','=',$kode)->first();
            $detailnota=$notapengeluarankass->detailnota;
            $pdf = PDF::loadView('pdf.nota-keluar-kas-pdf',['notapengeluarankass'=>$notapengeluarankass,'detailnota'=>$detailnota])->setPaper('a4','landscape');
            return $pdf->download('nota_pengeluaran_kas_proyek_'.$namaproyek.'_'.$notapengeluarankass->tglNota.'.pdf');
        }
         elseif($nama=='memoProyek'){
            $memoProyek = Memo_proyek::where('nonota','=',$kode)->first();
            $detailmemo=$memoProyek->detailnota;
            $pdf = PDF::loadView('pdf.memo-proyek-pdf',['memoProyek'=>$memoProyek,'detailmemo'=>$detailmemo])->setPaper('a4','landscape');
            return $pdf->download('memo_proyek_'.$namaproyek.'_'.$memoProyek->tglNota.'.pdf');
        }
         
    }

    public function rekapmaterialpdf($tglan){
        $data = MaterialProyek::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
        $tgl=date('Y-m-d',strtotime($tglan));
        $namaproyek=session()->get('namaproyek');
        $pdf = PDF::loadView('pdf.rekap-material-pdf',['data'=>$data,'namaproyek'=>$namaproyek,'tgl'=>$tgl])->setPaper('a4','potrait');
        return $pdf->download('Laporan_Rekap_Material_Proyek_'.$namaproyek.'_s/d'.$tgl.'.pdf');
    }

    public function rangkumanmaterialpdf($tglan){
        $data =JenisBiayaProyek::where('kodeJenisBiaya','LIKE','1%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $tgl=date('Y-m-d',strtotime($tglan));
        $namaproyek=session()->get('namaproyek');
        $pdf = PDF::loadView('pdf.rangkuman-material-pdf',['data'=>$data,'namaproyek'=>$namaproyek,'tgl'=>$tgl])->setPaper('a4','potrait');
        return $pdf->download('Laporan_Rangkuman_Material_Proyek_'.$namaproyek.'_s/d'.$tgl.'.pdf');
    }

    public function transaksimaterialpdf($tglaw,$tglakh){
        $terima=DB::table('detail_terima_barangs')->select(DB::raw("nota_terima_barangs.nonota as nonota, nota_terima_barangs.tglNota as tglNota, nota_terima_barangs.referensi as referensi, detail_terima_barangs.kode_material as kode, detail_terima_barangs.jumlah as kuantum,detail_terima_barangs.keterangan as uraian, 'Masuk' as status "))->join('nota_terima_barangs','nota_terima_barangs.nonota','=','detail_terima_barangs.nonota')->where('nota_terima_barangs.kodeProyek','=',session()->get('pilihanproyek'))->where('nota_terima_barangs.tglNota','>=',$tglaw)->where('nota_terima_barangs.tglNota','<=',$tglakh);
        $masuk=DB::table('detail_penggunaan_materials')->select(DB::raw("nota_penggunaan_materials.nonota as nonota, nota_penggunaan_materials.tanggalNota as tglNota, nota_penggunaan_materials.referensi as referensi, detail_penggunaan_materials.kodeMaterial as kode, detail_penggunaan_materials.jumlah as kuantum,detail_penggunaan_materials.keterangan as uraian, 'keluar' as status"))->join('nota_penggunaan_materials','nota_penggunaan_materials.nonota','=','detail_penggunaan_materials.nonota')->where('nota_penggunaan_materials.kodeProyek','=',session()->get('pilihanproyek'))->where('nota_penggunaan_materials.tanggalNota','>=',$tglaw)->where('nota_penggunaan_materials.tanggalNota','<=',$tglakh);
        $materials=$terima->union($masuk)->orderBy('tglNota','ASC')->get();
        $temp=material::orderBy('kodeMaterial')->first();
        $namaproyek=session()->get('namaproyek');
        $pdf = PDF::loadView('pdf.transaksi-material-pdf',['materials'=>$materials,'tglaw'=>$tglaw,'temp'=>$temp,'tglakh'=>$tglakh,'namaproyek'=>$namaproyek])->setPaper('a4','potrait');
        return $pdf->download('Laporan_Transaksi_Material_Proyek_'.$namaproyek.'_Priode'.$tglaw.'s/d'.$tglakh.'.pdf');
    }

    public function rekappenggunaanpdf($tglaw,$tglakh){
        $material_proyeks = MaterialProyek::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
        $namaproyek=session()->get('namaproyek');
        $pdf = PDF::loadView('pdf.rekap-penggunaan-pdf',['material_proyeks'=>$material_proyeks,'tglaw'=>$tglaw,'tglakh'=>$tglakh,'namaproyek'=>$namaproyek])->setPaper('a4','landscape');
        return $pdf->download('Laporan_Progres_Biaya_Proyek_(Penggunaan Material)_Proyek_'.$namaproyek.'_Periode_'.$tglaw.'s/d'.$tglakh.'.pdf');
    }

    public function bukukaspdf($tglaw,$tglakh){
        $namaproyek=session()->get('namaproyek');
        $masuk=DB::table('detail_nota_kas_masuks')->select(DB::raw("detail_nota_kas_masuks.nonota as nonota, detail_nota_kas_masuks.tglNota as tglNota,detail_nota_kas_masuks.uraian as uraian, detail_nota_kas_masuks.saldo as saldo, '' as kode,'1' as no_baris"))->join('nota_kas_masuks','detail_nota_kas_masuks.nonota','=','nota_kas_masuks.nonota')->where('nota_kas_masuks.kodeProyek','=',session()->get('pilihanproyek'))->where('nota_kas_masuks.tglNota','>=',$tglaw)->where('nota_kas_masuks.tglNota','<=',$tglakh);
        $alat=DB::table('detail_pengeluaran_kasses')->select(DB::raw("detail_pengeluaran_kasses.nonota as nonota, detail_pengeluaran_kasses.tglNota as tglNota,detail_pengeluaran_kasses.uraian as uraian, detail_pengeluaran_kasses.jumlah as saldo,  kodeAlat as kode, detail_pengeluaran_kasses.noBaris as no_baris"))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeBiayaKas',null)->where('nota_pengeluaran_kasses.tglNota','>=',$tglaw)->where('nota_pengeluaran_kasses.tglNota','<=',$tglakh);
        $biaya=DB::table('detail_pengeluaran_kasses')->select(DB::raw("detail_pengeluaran_kasses.nonota as nonota, detail_pengeluaran_kasses.tglNota as tglNota,detail_pengeluaran_kasses.uraian as uraian, detail_pengeluaran_kasses.jumlah as saldo,  kodeBiayaKas as kode, detail_pengeluaran_kasses.noBaris as no_baris"))->join('nota_pengeluaran_kasses','detail_pengeluaran_kasses.nonota','=','nota_pengeluaran_kasses.nonota')->where('nota_pengeluaran_kasses.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeAlat',null)->where('nota_pengeluaran_kasses.tglNota','>=',$tglaw)->where('nota_pengeluaran_kasses.tglNota','<=',$tglakh);
        $kas=$alat->union($biaya)->union($masuk)->orderBy('tglNota','ASC')->get();
        $saldo=BiayaKas::getsaldoakhir($tglaw,$tglakh);
        $temp=BiayaKas::orderBy('kodeBiayaKas')->first();
        $pdf = PDF::loadView('pdf.buku-kas-pdf',['kas'=>$kas,'saldo'=>$saldo,'tglaw'=>$tglaw,'temp'=>$temp,'tglakh'=>$tglakh])->setPaper('a4','potrait');
        return $pdf->download('Laporan_Buku_Kas_Proyek_'.$namaproyek.'_Periode '.$tglaw.'s/d'.$tglakh.'.pdf');
    }

    public function rekapkaspdf($tgl,$jenis){
        $namaproyek=session()->get('namaproyek');
        $temp=BiayaKas::orderBy('kodeBiayaKas')->first();
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
        $pdf = PDF::loadView('pdf.rekap-kas-pdf',['biaya_proyeks'=>$biaya_proyeks,'tgl'=>$tgl,'temp'=>$temp,'jenis'=>$jenis,'namaproyek'=>$namaproyek])->setPaper('a4','landscape');
        return $pdf->download('Laporan_Rekap_Kas_Jenis_'.$jenis.'_Proyek_'.$namaproyek.'_Periode s/d'.$tgl.'.pdf');
    }

    public function transaksikaspdf($tglaw,$tglakh){
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
        $namaproyek=session()->get('namaproyek');
        $pdf = PDF::loadView('pdf.transaksi-kas-pdf',['biayakass'=>$biayakass,'tglaw'=>$tglaw,'temp'=>$temp,'tglakh'=>$tglakh,'namaproyek'=>$namaproyek])->setPaper('a4','potrait');
        return $pdf->download('Laporan_Transaksi_Kas_Proyek_'.$namaproyek.'_Priode'.$tglaw.'s/d'.$tglakh.'.pdf');
    }

    public function rekapprogresbiayapdf($tglaw,$tglakh){
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
        $namaproyek=session()->get('namaproyek');
        $pdf = PDF::loadView('pdf.rekap-progres-biaya-pdf',['kas'=>$kas,'tglaw'=>$tglaw,'temp'=>$temp,'tglakh'=>$tglakh,'namaproyek'=>$namaproyek,'materials'=>$materials,'alats'=>$alats,'upahs'=>$upahs,'bops'=>$bops,'bups'=>$bups])->setPaper('a4','landscape   ');
        return $pdf->download('Laporan_Progres_Biaya_Proyek_'.$namaproyek.'_Priode'.$tgl.'s/d'.$tglakh.'.pdf');
    }

    public function kartustokpdf($id){
        setlocale(LC_ALL,'IND');
        
        $materialss=MaterialProyek::kartuStok($id);
        $masuk=DetailTerimaBarang::where('kode_material','=',$id)->where('kodeProyek','=',session()->get('pilihanproyek'))->sum('jumlah');
        $keluar= DetailPenggunaanMaterial::join('nota_penggunaan_materials','detail_penggunaan_materials.nonota','=','nota_penggunaan_materials.nonota')->where('nota_penggunaan_materials.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeMaterial', '=', $id)->sum('jumlah');
        $saldo=round($masuk,4)-round($keluar,4);
        $namaproyek=session()->get('namaproyek');
        $pdf = PDF::loadView('pdf.kartu-stok-pdf',['id'=>$id,'materialss'=>$materialss,'namaproyek'=>$namaproyek,'masuk'=>$masuk,'keluar'=>$keluar,'saldo'=>$saldo])->setPaper('a4','potrait');
        return $pdf->download('Laporan_Transaksi_Material_s/d'.strftime('%d %B %Y',strtotime(date('d-m-Y'))).'.pdf');
    }

    public function printrap($kode){
        $namaproyek = session()->get('namaproyek');
        
        $rap = Rap::where('nonota', '=', $kode)->first();
        $rapkegiatan = $rap->rapkegiatan;
        $rapbiaya = $rap->rapbiaya;

        $pdf = PDF::loadView('pdf.rap',['rap'=>$rap,'rapkegiatan'=>$rapkegiatan, 'rapbiaya'=>$rapbiaya, 'namaproyek'=>$namaproyek])->setPaper('a4','landscape');
        
        return $pdf->download('rap_'.$namaproyek.'_'.$rap->tglNota.'.pdf');
    }

    public function nodata(){
        return view('error.nodata');
    }
}
