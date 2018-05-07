<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\material;
use App\JenisBiayaProyek;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;
use DB;
use App\MaterialProyek;
use App\DetailPenggunaanMaterial;
use App\NotaPenggunaanMaterial;
use App\NotaBeliMaterial;
use App\DetailBeliMaterial;
use App\NotaTerimaBarang;
use App\DetailTerimaBarang;
use App\proyek;
use App\gudang;
use App\mitraKerja;

class materialsController extends Controller
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
        $materials = material::all();

        return view('materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('materials.create');
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
        
        material::create($requestData);

        session()->put('success','Data berhasil diinputkan');

        return redirect('materials');
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
        $material = material::where("kodeMaterial","=",$id)->first();

        return view('materials.show', compact('material'));
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
        $material = material::where("kodeMaterial","=",$id)->first();

        return view('materials.edit', compact('material'));
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
        
        $material = material::where("kodeMaterial","=",$id)->first();
        $material->update(array('nama' => $request->get('nama'),
            'satuan'=>$request->get('satuan')));

        session()->put('success','Data berhasil diubah');

        return redirect('materials');
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
        material::destroy($id);

       session()->put('success','Data berhasil dihapus');
        return redirect('materials');
    }

    public function exportcsv(){
        $name='M_'.date('YmdHis');
        $data=material::all()->toArray();
        return Excel::create($name,function($excel) use ($data){
            $excel->sheet('Material', function($sheet) use ($data){
                $sheet->fromArray($data);
            });
        })->download('xls');
    }

    public function importcsv(Request $request){
        if($request->hasFile('filecsv')){
            $path=$request->file('filecsv')->getRealPath();
            $name=$request->file('filecsv')->getClientOriginalName();
            $split=str_split($name,1);
            if($split[0]=='M')
            {
                $data=Excel::load($path, function($reader){})->get();
                if(!empty($data) && $data->count()){
                    foreach ($data->toArray() as $key => $value) {
                            $insert[]=['kodeMaterial'=>$value['kodematerial'],'nama'=>$value['nama'],'satuan'=>$value['satuan'],'created_at'=>$value['created_at'],'updated_at'=>$value['updated_at']];
                    }
                    if(!empty($insert)){
                        material::insert($insert);
                        session()->put('success','Data Berhasil Diimpor');
                        return redirect('materials');
                    }
                }
            }
            else{
                session()->put('error','Pastikan Data yang Diimpor Adalah Data Material');
                return redirect('materials');
            }

        }
            session()->put('error','Tidak Ada File Yang Akan Diupload');
        return redirect('materials');
    }

    public function rekapitulasimaterial(){
        $material_proyeks = MaterialProyek::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
        $tgl=date('Y-m-d');

        if(!$material_proyeks->isEmpty()){
            return view('materials.rekapitulasi-material', compact('material_proyeks','tgl'));
        }
        else{
            return view('error.nodata');
        }
    }

    public function tampilrekap($tgl){
         $material_proyeks = MaterialProyek::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
         foreach($material_proyeks as $material_proyek){
            $jummasuk= $material_proyek->totkuantummasuk($material_proyek->kodeMaterial,$tgl);
            $jumkeluar=$material_proyek->totkuantumkeluar($material_proyek->kodeMaterial,$tgl);

            if($jumkeluar||$jummasuk){
                echo "   <tr>".
                        "<td>".$material_proyek->kodeMaterial."</td>".
                        "<td style='text-align: left;'>".$material_proyek->material->nama."</td>".

                        "<td>". $material_proyek->totkuantummasuk($material_proyek->kodeMaterial,$tgl) ."</td>".
                        "<td style='text-align: right;'>Rp " . number_format($material_proyek->tothargamasuk($material_proyek->kodeMaterial,$tgl),0,",",".") ."</td>".
                        "<td style='text-align: right;'>Rp " . number_format($material_proyek->hitungratarata($material_proyek->kodeMaterial,$tgl),0,",",".")  ."</td>".

                        "<td>". $material_proyek->totkuantumkeluar($material_proyek->kodeMaterial,$tgl) ."</td>".
                        "<td style='text-align: right;'>Rp ". number_format($material_proyek->tothargakeluar($material_proyek->kodeMaterial,$tgl),0,",",".") ."</td>".

                        "<td>". $material_proyek->hitungsaldokuantum($material_proyek->kodeMaterial,$tgl) ."</td>".
                        "<td style='text-align: right;'>Rp ". number_format($material_proyek->hitungsaldoharga($material_proyek->kodeMaterial,$tgl),0,",",".")."</td>".
                    "</tr>";
                }
            }
    }
    public function tampilrekapfoot($tgl){

        echo "<tr>
                <td colspan='3' style='border-top: 2px solid gray;'>JUMLAH</td>
                
                <td style='text-align: right; border-top: 2px solid gray;'>Rp ".number_format(MaterialProyek::grandtothargamasuk($tgl),0,",",".")."</td>
                <td colspan='2' style='border-top: 2px solid gray; '></td>
                
                <td style='text-align: right; border-top: 2px solid gray;'>Rp ".number_format(MaterialProyek::grandtothargakeluar($tgl),0,",",".")."</td>
                <td style='border-top: 2px solid gray;'></td>
                <td style='text-align: right; border-top: 2px solid gray;'>Rp ".number_format(MaterialProyek::grandtotsaldo($tgl),0,",",".")."</td>
            </tr>";
    }

    public function tampilrangkuman($tgl){
        $materials = JenisBiayaProyek::where('kodeJenisBiaya','LIKE','1%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        foreach($materials as $material){
    

        $jummasuk= $material->grandtothargamasuk($material->kodeJenisBiaya,$tgl);
        $jumkeluar=$material->grandtothargakeluar($material->kodeJenisBiaya,$tgl);

            if($jummasuk||$jumkeluar){
                echo '<tr>
                    <td style="vertical-align: middle; text-align: left;">'.$material->kodeJenisBiaya.' - '.$material->nama.'</td>
                    <td style="vertical-align: middle; text-align: right;">Rp '.number_format($material->grandtothargamasuk($material->kodeJenisBiaya,$tgl),0,",",".").'</td>
                    <td style="vertical-align: middle; text-align: right;">Rp '.number_format($material->grandtothargakeluar($material->kodeJenisBiaya,$tgl),0,",",".").'</td>
                    <td style="vertical-align: middle; text-align: right;">Rp '. number_format($material->grandtotsaldo($material->kodeJenisBiaya,$tgl),0,",",".").'</td>
                </tr>';
            }
        }
        
    }
    public function tampilrangkumanfoot($tgl){

        $materials = JenisBiayaProyek::where('kodeJenisBiaya','LIKE','1%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $totmasuk=0;
        $totkeluar=0;
        $totsaldo=0;
        foreach($materials as $material){
    

        $jummasuk= $material->grandtothargamasuk($material->kodeJenisBiaya,$tgl);
        $jumkeluar=$material->grandtothargakeluar($material->kodeJenisBiaya,$tgl);

            if($jummasuk||$jumkeluar){
                    $totmasuk+=$material->grandtothargamasuk($material->kodeJenisBiaya,$tgl);
                    $totkeluar+=$material->grandtothargakeluar($material->kodeJenisBiaya,$tgl);
                    $totsaldo+=$material->grandtotsaldo($material->kodeJenisBiaya,$tgl);
            }
        }
        echo "<tr>
                <td style='border-top: 2px solid gray;'>JUMLAH</td>
                <td style='vertical-align: middle; text-align: right; border-top: 2px solid gray;'>Rp ".number_format($totmasuk,0,",",".")."</td>
                <td style='vertical-align: middle; text-align: right; border-top: 2px solid gray;'>Rp ".number_format($totkeluar,0,",",".")."</td>
                <td style='vertical-align: middle; text-align: right; border-top: 2px solid gray;'>Rp ".number_format($totsaldo,0,",",".")."</td>
            </tr>";
    }


    public function rangkumanmaterial(){
        $materials = JenisBiayaProyek::where('kodeJenisBiaya','LIKE','1%')->whereRaw('LENGTH(kodeJenisBiaya) > 2')->get();
        $tgl=date('Y-m-d');

        return view('materials.rangkuman-material', compact('materials','tgl'));
    }

    public function kartustokmaterial(){
        $materials = MaterialProyek::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
    
        $mater=DetailPenggunaanMaterial::where('nonota','=','P001PM001')->where('kodeMaterial','=','141.01')->first();

        if(!$materials->isEmpty()){
            return view('materials.kartu-stok-material', compact('materials'));
        }
        else{
            return view('error.nodata');
        }
    }

    public function tampilstok($id){
        $materialss=MaterialProyek::kartuStok($id);
        $saldo=0;
        $findme="PM";
        $kode='';
        foreach ($materialss as $material) {
           $pos = strpos($material->nonota, $findme);
           $kode=$id;
            // if ($pos !== false) {
                // echo "string";
            $mater=DetailTerimaBarang::where('nonota','=',$material->nonota)->where('kode_material','=',$id)->first();
            if($mater){
                 // $mater=DetailTerimaBarang::where('nonota','=',$material->nonota)->where('kode_material','=',$id)->first();
                 // $kode=$mater->kode_material;
                 // print_r( $mater);exit();

                 echo '<tr>
                <td>'.$mater->tglNota.'</td>
                <td>'.$kode.'</td>
                <td>'.$mater->keterangan.'</td>';
               
                echo '<td>'.$mater->jumlah.' '.$mater->material->satuan.'</td>
                <td></td>';
                     $saldo=round($saldo,4)+round($mater->jumlah,4);
               
               echo '<td>'.$saldo.'</td>
            </tr>';
            } else {
                // echo "1";
                 $mater=DetailPenggunaanMaterial::where('nonota','=',$material->nonota)->where('kodeMaterial','=',$id)->first();
                 // $kode=$mater->kodeMaterial;
                 echo '<tr>
                <td>'.$mater->tglNota.'</td>
                <td>'.$kode.'</td>
                <td>'.$mater->keterangan.'</td>';
               
                echo '<td></td>
                <td>'.$mater->jumlah.' '.$mater->material->satuan.'</td>';
                
                    $saldo=round($saldo,4)-round($mater->jumlah,4);
               
                     // $saldo-=$mater->jumlah;
               
               echo '<td>'.$saldo.'</td>
            </tr>';
            }
            //print_r( $mater);exit();
            
        }
    }

    public function tampilstokfoot($id){
        $masuk=DetailTerimaBarang::where('kode_material','=',$id)->where('kodeProyek','=',session()->get('pilihanproyek'))->sum('jumlah');
        $keluar= DetailPenggunaanMaterial::join('nota_penggunaan_materials','detail_penggunaan_materials.nonota','=','nota_penggunaan_materials.nonota')->where('nota_penggunaan_materials.kodeProyek','=',session()->get('pilihanproyek'))->where('kodeMaterial', '=', $id)->sum('jumlah');
        $saldo=round($masuk,4)-round($keluar,4);
        echo "<tr>
                <td colspan='3' style='border-top: 2px solid gray;'>JUMLAH</td>
                <td style='border-top: 2px solid gray;'>".$masuk."</td>
                <td style='border-top: 2px solid gray;'>".$keluar."</td>
                <td style='border-top: 2px solid gray;'>".$saldo."</td>
            </tr>";
                    
     }

    public function rekapitulasipenggunaanmaterial(){
        $material_proyeks = MaterialProyek::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
       // $nota=NotaPenggunaanMaterial::orderBy('tanggalNota','desc')->first();
        // $tglaw=$nota->tanggalNota;
        // $tglakh=date('Y-m-d');

        if(!$material_proyeks->isEmpty()){
            if(date('N')!=1)
                $tglaw=date("Y-m-d",strtotime( "previous monday" ));
            else
                $tglaw=date('Y-m-d');

            if(date('N')!=5)
                $tglakh=date("Y-m-d",strtotime( "next friday" ));
            else
                $tglakh=date('Y-m-d');
            return view('materials.rekapitulasi-penggunaan-material',compact('material_proyeks','tglaw','tglakh'));
        }
        else{
            return view('error.nodata');
        }

        
    }

    public function tampilpenggunaan($tglaw,$tglakh){
        $material_proyeks = MaterialProyek::where('kodeProyek', '=', session()->get('pilihanproyek'))->get();
        foreach($material_proyeks as $material_proyek){
             $tgl=date('Y-m-d', strtotime($tglaw. ' -1 days'));

            $hargarata= $material_proyek->hitungratarata($material_proyek->kodeMaterial,$tglakh);
           

            if($hargarata){
               echo '<tr>
                    <td>'.$material_proyek->kodeMaterial.'</td>
                    <td style="text-align: left;">'.$material_proyek->material->nama.'</td>

                    <td style="text-align: right;">Rp '.number_format($hargarata,0,",",".").'</td>
                    <td>'. $material_proyek->totkuantumkeluar($material_proyek->kodeMaterial,$tgl) .'</td>
                    <td style="text-align: right;">Rp '. number_format($material_proyek->tothargakeluar($material_proyek->kodeMaterial,$tgl),0,",",".") .'</td>

                    <td>'. $material_proyek->kuantumperiode($material_proyek->kodeMaterial,$tglaw,$tglakh) .'</td>
                    <td style="text-align: right;">Rp '. number_format($material_proyek->tothargakeluarperiode($material_proyek->kodeMaterial,$tglaw,$tglakh),0,",",".") .'</td>

                    <td>'. $material_proyek->totkuantumkeluar($material_proyek->kodeMaterial,$tglakh) .'</td>
                    <td style="text-align: right;">Rp '. number_format($material_proyek->tothargakeluar($material_proyek->kodeMaterial,$tglakh),0,",",".").'</td>
                </tr>';
            }
        }
        
        

            
    }
    public function tampilpenggunaantfoot($tglaw,$tglakh){
         $tgl=date('Y-m-d', strtotime($tglaw. ' -1 days'));
        echo '<tr>
            <td colspan="3" style="border-top: 2px solid gray;">JUMLAH</td>
            <td style="border-top: 2px solid gray;"></td>
            <td style="vertical-align: middle; text-align: right; border-top: 2px solid gray;">Rp '.number_format(MaterialProyek::grandtothargakeluar($tgl),0,",",".").'</td>
            <td style="border-top: 2px solid gray;"></td>
            <td style="vertical-align: middle; text-align: right; border-top: 2px solid gray;">Rp '.number_format(MaterialProyek::grandtothargakeluarperiode($tglaw,$tglakh),0,",",".").'</td>
            <td style="border-top: 2px solid gray;"></td>
            <td style="vertical-align: middle; text-align: right; border-top: 2px solid gray;">Rp '.number_format(MaterialProyek::grandtothargakeluar($tglakh),0,",",".").'</td>
        </tr>';
    }

    public function transaksimaterial(){
        $terima=DB::table('detail_terima_barangs')->select(DB::raw("nota_terima_barangs.nonota as nonota, nota_terima_barangs.tglNota as tglNota, nota_terima_barangs.referensi as referensi, detail_terima_barangs.kode_material as kode, detail_terima_barangs.jumlah as kuantum,detail_terima_barangs.keterangan as uraian, 'Masuk' as status "))->join('nota_terima_barangs','nota_terima_barangs.nonota','=','detail_terima_barangs.nonota')->where('nota_terima_barangs.kodeProyek','=',session()->get('pilihanproyek'));
        $masuk=DB::table('detail_penggunaan_materials')->select(DB::raw("nota_penggunaan_materials.nonota as nonota, nota_penggunaan_materials.tanggalNota as tglNota, nota_penggunaan_materials.referensi as referensi, detail_penggunaan_materials.kodeMaterial as kode, detail_penggunaan_materials.jumlah as kuantum,detail_penggunaan_materials.keterangan as uraian, 'keluar' as status"))->join('nota_penggunaan_materials','nota_penggunaan_materials.nonota','=','detail_penggunaan_materials.nonota')->where('nota_penggunaan_materials.kodeProyek','=',session()->get('pilihanproyek'));
        $materials=$terima->union($masuk)->orderBy('tglNota','ASC')->get();

        if(!$materials->isEmpty()){
            $temp=material::orderBy('kodeMaterial')->first();
            $tglakh=date('Y-m-d');
            $tgl=$terima->union($masuk)->orderBy('tglNota','ASC')->first('tglNota'); 
            $tglaw=$tgl->tglNota;
     
            return view('materials.transaksi-material', compact('materials','tglaw','tglakh','temp'));
        }
        else{
            return view('error.nodata');
        }

        
    }

     public function tampiltransaksi($tglaw,$tglakh){
        $temp=material::orderBy('kodeMaterial')->first();
        $terima=DB::table('detail_terima_barangs')->select(DB::raw("nota_terima_barangs.nonota as nonota, nota_terima_barangs.tglNota as tglNota, nota_terima_barangs.referensi as referensi, detail_terima_barangs.kode_material as kode, detail_terima_barangs.jumlah as kuantum,detail_terima_barangs.keterangan as uraian, 'Masuk' as status "))->join('nota_terima_barangs','nota_terima_barangs.nonota','=','detail_terima_barangs.nonota')->where('nota_terima_barangs.kodeProyek','=',session()->get('pilihanproyek'))->where('nota_terima_barangs.tglNota','>=',$tglaw)->where('nota_terima_barangs.tglNota','<=',$tglakh);
        $masuk=DB::table('detail_penggunaan_materials')->select(DB::raw("nota_penggunaan_materials.nonota as nonota, nota_penggunaan_materials.tanggalNota as tglNota, nota_penggunaan_materials.referensi as referensi, detail_penggunaan_materials.kodeMaterial as kode, detail_penggunaan_materials.jumlah as kuantum,detail_penggunaan_materials.keterangan as uraian, 'keluar' as status"))->join('nota_penggunaan_materials','nota_penggunaan_materials.nonota','=','detail_penggunaan_materials.nonota')->where('nota_penggunaan_materials.kodeProyek','=',session()->get('pilihanproyek'))->where('nota_penggunaan_materials.tanggalNota','>=',$tglaw)->where('nota_penggunaan_materials.tanggalNota','<=',$tglakh);
        $materials=$terima->union($masuk)->orderBy('tglNota','ASC')->get();

        foreach($materials as $material){
               echo '<tr class="';echo  ($material->status=="Masuk")?'success':'danger';echo '">
                        <td style="text-align: left;">'.$material->tglNota.'</td>
                        <td style="text-align: left;">'.$material->nonota.'</td>
                        <td style="text-align: left;">'.$material->uraian.'</td>
                        <td style="text-align: left;">'.$material->referensi.'</td>
                        <td style="text-align: left;">'.$material->kode.' - '. $temp->getnama($material->kode).'</td>
                        <td style="text-align: left;">'.$material->status.'</td>
                        <td style="text-align: right;">'.$material->kuantum.$temp->getsatuan($material->kode).'</td>
                    </tr>';
            }
    }
}
