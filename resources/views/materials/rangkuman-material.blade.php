@extends('layouts.template')

@section('title','Rangkuman Material')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading text-center">Rangkuman Material <br> Proyek IGD RSUD Sidoarjo
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
                                    <div class="col-md-offset-5 col-md-2">
                                        <p>s.d tanggal 
                                            
                                            <input type="text" name="" id='tgl'  onchange="setdata(this)" class="form-control date-picker birthday">
                                        </p>        
                                    </div>
                                </div>
                                
                                <br>
                                <div class="table table-responsive">
                                    <table id="datatable" class="table table-bordered text-center">
                                        <thead align="center">
                                            <tr>
                                                <th style="vertical-align: middle; text-align: center;">Kelompok Material</th>
                                                <th style="vertical-align: middle; text-align: center;">Nilai Masuk</th>
                                                <th style="vertical-align: middle; text-align: center;">Nilai Keluar</th>
                                                <th style="vertical-align: middle; text-align: center;">Nilai Saldo</th>
                                            </tr>
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">                                   
                                        <tbody id="data">
                                                @php 

                                                $totmasuk=0;
                                                $totkeluar=0;
                                                $totsaldo=0;

                                                @endphp
                                                @foreach($materials as $material)
                                                @php

                                                $jummasuk= $material->grandtothargamasuk($material->kodeJenisBiaya,$tgl);
                                                $jumkeluar=$material->grandtothargakeluar($material->kodeJenisBiaya,$tgl);

                                                @endphp
                                                @if($jummasuk||$jumkeluar)
                                                <tr>
                                                    <td style="vertical-align: middle; text-align: left;">{{$material->kodeJenisBiaya}} - {{$material->nama}}</td>
                                                    <td style="vertical-align: middle; text-align: right;">Rp {{ number_format($material->grandtothargamasuk($material->kodeJenisBiaya,$tgl),0,",",".") }}</td>
                                                    <td style="vertical-align: middle; text-align: right;">Rp {{ number_format($material->grandtothargakeluar($material->kodeJenisBiaya,$tgl),0,",",".") }}</td>
                                                    <td style="vertical-align: middle; text-align: right;">Rp {{ number_format($material->grandtotsaldo($material->kodeJenisBiaya,$tgl),0,",",".") }}</td>
                                                </tr>

                                                @php
                                                $totmasuk+=$material->grandtothargamasuk($material->kodeJenisBiaya,$tgl);
                                                $totkeluar+=$material->grandtothargakeluar($material->kodeJenisBiaya,$tgl);
                                                $totsaldo+=$material->grandtotsaldo($material->kodeJenisBiaya,$tgl);
                                                @endphp

                                                @endif
                                                @endforeach
                                            
                                        </tbody>
                                        <tfoot id='tfoot'>
                                            <tr>
                                                <td>JUMLAH</td>
                                                <td style="vertical-align: middle; text-align: right;">Rp {{ number_format($totmasuk,0,",",".") }}</td>
                                                <td style="vertical-align: middle; text-align: right;">Rp {{ number_format($totkeluar,0,",",".") }}</td>
                                                <td style="vertical-align: middle; text-align: right;">Rp {{ number_format($totsaldo,0,",",".") }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            {!! Form::close() !!}


<script type="text/javascript"> 

function setdata(param){
    var val=param.value;
        
    val=val.toString();
    var spl=val.split('/')
    val = spl[2]+'-'+spl[0]+'-'+spl[1]

    var url="setrangkumanmaterial/"+val
    $.get(url, function(data){
        $('#data').html(data)
    })

    url="setrangkumanmaterialfoot/"+val
    $.get(url, function(data){
        $('#tfoot').html(data)
    })
}


function printpdf(){
    var val=$('#tgl').val();
    val=val.toString();
    var spl=val.split('/')
    val = spl[2]+'-'+spl[0]+'-'+spl[1]
    var url="rangkummaterial/"+val
    window.open(url)
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

