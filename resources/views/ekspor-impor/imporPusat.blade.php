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

                    <div class="panel-heading text-center"> Impor Data Pusat </div>
                    <div class="panel-body">
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        
                        <form id="formReferensi" class="form-horizontal" action="{{url('/imporPusatcsv')}}" method="POST" enctype='multipart/form-data'>
                            {{csrf_field()}}
                                
                           
                            <fieldset id ='transaksi'>
                                <legend>Data Transaksi Proyek</legend>
                                <div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Pembelian Material</label>  
                                        <div class="col-md-6">
                                           <input name="beli" id="beli" type="file" class="form-control input-md isi" > 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Penerimaan Material</label>  
                                        <div class="col-md-6">
                                           <input name="terima" id="terima" type="file" class="form-control input-md isi"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Penggunaan Material</label>  
                                        <div class="col-md-6">
                                           <input name="guna" id="guna" type="file" class="form-control input-md isi"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Pengeluaran Kas</label>  
                                        <div class="col-md-6">
                                           <input name="kasKeluar" id="kasKeluar" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Droping Kas</label>  
                                        <div class="col-md-6">
                                           <input name="kasMasuk" id="kasMasuk" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Memo Biaya Proyek</label>  
                                        <div class="col-md-6">
                                           <input name="memo" id="memo" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Opname Volume Pekerjaan Proyek</label>  
                                        <div class="col-md-6">
                                           <input name="opname" id="opname" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Penetralan Kasbon Proyek</label>  
                                        <div class="col-md-6">
                                           <input name="netral" id="netral" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="textinput">Rencana Anggaran Proyek</label>  
                                        <div class="col-md-6">
                                           <input name="rap" id="rap" type="file" class="form-control input-md"> 
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group"> 
                                <div class="col-md-2 pull-right" >
                                   <input name="btn-submit" type="submit" onclick="cekKosong(event)" class="form-control input-md btn btn-primary" id="impor" value="Impor"> 
                                </div>
                            </div>
                            
                        </form>


<script type="text/javascript"> 

function cekKosong(e) {
    e.preventDefault()
    if(document.getElementById("beli").files.length == 0 && document.getElementById("guna").files.length == 0 &&  document.getElementById("terima").files.length == 0 && document.getElementById("kasKeluar").files.length == 0 && document.getElementById("kasMasuk").files.length == 0 && document.getElementById("memo").files.length == 0 && document.getElementById("opname").files.length == 0 && document.getElementById("netral").files.length == 0 && document.getElementById("rap").files.length == 0)
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