@extends('layouts.template')

@section('title','Master Data Kategori')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div >
        @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading text-center"> Impor Data Acuan Lapangan </div>
                    <div class="panel-body">
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        
                        <form id="formReferensi" class="form-horizontal" action="{{url('/imporLapangancsv')}}" method="POST" enctype='multipart/form-data'>
                            {{csrf_field()}}
                                <!-- <div class="form-group">
                                  <label class="col-md-4 control-label" for="radios">File Import</label>
                                  <div class="col-md-4"> 
                                    <label class="radio-inline" for="radios-0">
                                      <input type="radio" name="radios" id="radios-0" value="referensi" onclick="pilihfile(this)">
                                      Data Referensi
                                    </label> 
                                    <label class="radio-inline" for="radios-1">
                                      <input type="radio" name="radios" id="radios-1" value="transaksi" onclick="pilihfile(this)">
                                      Data Transaksi
                                    </label>
                                  </div>
                                </div> -->
                            <fieldset id ='referensi'>
                                <legend> Data Referensi Proyek</legend>
                                 <div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Data Material</label>  
                                        <div class="col-md-6">
                                           <input id="material" name="material" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Data Alat</label>  
                                        <div class="col-md-6">
                                           <input id="alat" name="alat" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Data Proyek</label>  
                                        <div class="col-md-6">
                                           <input id="proyek" name="proyek" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Data User EDP</label>  
                                        <div class="col-md-6">
                                           <input id="user" name="user" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                  <!--   <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Data Manager Proyek</label>  
                                        <div class="col-md-6">
                                           <input id="manager" name="manager" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Data Customer</label>  
                                        <div class="col-md-6">
                                           <input id="pelanggan" name="pelanggan" type="file" class="form-control input-md"> 
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Data Mitra Kerja</label>  
                                        <div class="col-md-6">
                                           <input id="mitra" name="mitra" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Data Kelompok Kegiatan</label>  
                                        <div class="col-md-6">
                                           <input id="kelompokKegiatan" name="kelompokKegiatan" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                   <!--  <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Data Gudang</label>  
                                        <div class="col-md-6">
                                           <input id="gudang" name="gudang" type="file" class="form-control input-md"> 
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Data Biaya Kas</label>  
                                        <div class="col-md-6">
                                           <input id="biayaKas" name="biayaKas" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Data Jenis Biaya Proyek</label>  
                                        <div class="col-md-6">
                                           <input id="jenisBiayaProyek" name="jenisBiayaProyek" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            

                           
                            <!-- <fieldset id ='transaksi'>
                                <legend>Transaksi</legend>
                                <div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Pembelian Material</label>  
                                        <div class="col-md-6">
                                           <input name="beli" id="beli" type="file" class="form-control input-md isi" > 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Pembayaran Material</label>  
                                        <div class="col-md-6">
                                           <input name="bayar" id="bayar" type="file" class="form-control input-md isi"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Penerimaan Material</label>  
                                        <div class="col-md-6">
                                           <input name="terima" id="bayar" type="file" class="form-control input-md isi"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Pengeluaran Kas</label>  
                                        <div class="col-md-6">
                                           <input name="kasKeluar" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                </div>
                            </fieldset> -->

                            <div class="form-group"> 
                                <div class="col-md-2 pull-right" >
                                   <input name="btn-submit" type="submit" onclick="cekKosong(event)" class="form-control input-md btn btn-primary" id="impor" value="Impor"> 
                                </div>
                            </div>
                            
                        </form>


<script type="text/javascript"> 
// $(document).ready(function(){
//     $('#referensi').hide()
//     $('#transaksi').hide()
//     $('#impor').hide()


//     $('.isi').change(function(){ 
//         alert($(this).val())
//         if ($(this).val()) {
//             $('#beli').attr('required',true)
//             $('#bayar').attr('required',true)
//             $('#terima').attr('required',true)
//         }   
//         else{
//             if(!$('#beli').val()&&!$('#bayar').val()&&!$('#terima').val()){
//                 $('#beli').removeAttr('required')
//                 $('#bayar').removeAttr('required')
//                 $('#terima').removeAttr('required')
//             }
//         }
//     })
// });
// function pilihfile(param) {
//     $('#referensi').hide()
//     $('#transaksi').hide()
//     $('#impor').show()
//     $('#'+param.value).show()
// }

function cekKosong(e) {
    e.preventDefault()
    // if(document.getElementById("material").files.length == 0 && document.getElementById("alat").files.length == 0 && document.getElementById("proyek").files.length == 0 && document.getElementById("manager").files.length == 0 && document.getElementById("pelanggan").files.length == 0 && document.getElementById("mitra").files.length == 0 &&  document.getElementById("gudang").files.length == 0 && document.getElementById("biayaKas").files.length == 0 && document.getElementById("jenisBiayaProyek").files.length == 0)
    if(document.getElementById("material").files.length == 0 && document.getElementById("alat").files.length == 0 && document.getElementById("proyek").files.length == 0 && document.getElementById("user").files.length == 0  && document.getElementById("mitra").files.length == 0 &&  document.getElementById("kelompokKegiatan").files.length == 0 && document.getElementById("biayaKas").files.length == 0 && document.getElementById("jenisBiayaProyek").files.length == 0)
        alert("Masukkan Data File Terlebih Dahulu Jika Ingin Mengimpor")
    else
        document.getElementById("formReferensi").submit();
}
</script>

                    </div>
                </div>
            </div>
        </div>
 <!-- end of row -->

    </div>
</div>
@endsection