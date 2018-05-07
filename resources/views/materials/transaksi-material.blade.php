@extends('layouts.template')

@section('title','Data Transaksi Material')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading text-center">Data Transaksi Material <br> {{session()->get('namaproyek')}}
                    </div>
                    <div class="panel-body">
                    <a id="print" onclick="printpdf()" class="btn btn-primary btn-sm" title="CSV">
                            <i class="fa fa-print" aria-hidden="true"></i> Print
                    </a>
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => '/rekapitulasi-material', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}

                                <div class="row">
                                    <div class="col-md-offset-5 col-md-2 text-center">
                                        <p>Tanggal</p>        
                                        <input type="text" name="mulai" id="tglaw" onchange="setdata(this)" class="form-control date-picker birthday" value="{{date('m/d/Y',strtotime($tglaw))}}">
                                        
                                        s.d
                                        <input type="text" name="selesai" id="tglakh" onchange="setdata(this)" class="form-control date-picker birthday" value="{{date('m/d/Y',strtotime($tglakh))}}">
                                    </div>
                                </div>
                                
                                <br>
                                <div class="table table-responsive">
                                      <table id="datatable" class="table table-bordered text-center" style="width: 100%;">
                                        <thead align="center">
                                            <tr>
                                                <th style="vertical-align: middle; text-align: center; width: 15%;">Tanggal</th>
                                                <th style="vertical-align: middle; text-align: center; width: 10%;" >Nomor</th>
                                                <th style="vertical-align: middle; text-align: center; width: 30%;">Uraian</th>
                                                <th style="vertical-align: middle; text-align: center; width: 10%;">Referensi</th>
                                                <th style="vertical-align: middle; text-align: center; width: 15%;">Kode - Nama Material</th>
                                                <th style="vertical-align: middle; text-align: center; width: 10%;" >Masuk / Keluar</th>
                                                 <th style="vertical-align: middle; text-align: center; width: 10%;" >Kuantum</th>
                                            </tr>
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">                                   
                                        <tbody id="data">
                                            @foreach($materials as $material)
                                            <tr class="{{($material->status=='Masuk')?'success':'danger'}}">
                                                <td style="text-align: left;">{{$material->tglNota}}</td>
                                                <td style="text-align: left;">{{$material->nonota}}</td>
                                                <td style="text-align: left;">{{$material->uraian}}</td>
                                                <td style="text-align: left;">{{$material->referensi}}</td>
                                                <td style="text-align: left;">{{$material->kode}} - {{$temp->getnama($material->kode)}}</td>
                                                <td style="text-align: left;">{{$material->status}}</td>
                                                <td style="text-align: right;">{{$material->kuantum}} {{$temp->getsatuan($material->kode)}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                      
                                    </table>
                                </div>
                            {!! Form::close() !!}


<script type="text/javascript"> 

function setdata(param){
    var tglaw=$('#tglaw').val()
    var tglakh=$('#tglakh').val()

    valaw=tglaw.toString();
    var splaw=tglaw.split('/')
    valaw = splaw[2]+'-'+splaw[0]+'-'+splaw[1]

    valakh=tglakh.toString();
    var splakh=tglakh.split('/')
    valakh = splakh[2]+'-'+splakh[0]+'-'+splakh[1]
        
    var url="setdatamaterial/"+valaw+"/"+valakh
    $.get(url, function(data){
        $('#data').html(data)
    })
}

function printpdf(){
   var tglaw=$('#tglaw').val()
    var tglakh=$('#tglakh').val()

    valaw=tglaw.toString();
    var splaw=tglaw.split('/')
    valaw = splaw[2]+'-'+splaw[0]+'-'+splaw[1]

    valakh=tglakh.toString();
    var splakh=tglakh.split('/')
    valakh = splakh[2]+'-'+splakh[0]+'-'+splakh[1]
    var url="transaksimaterial/"+valaw+"/"+valakh
    window.open(url)
}
 </script>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection


