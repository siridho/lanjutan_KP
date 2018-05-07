@extends('layouts.template')

@section('title',' Laporan Buku Kas')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading text-center">Laporan Buku Kas <br> Proyek {{session()->get('namaproyek')}}
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
                                        <input type="text" name="mulai" id="tglaw" value="{{date('m/d/Y',strtotime($tglaw))}}" onchange="setdata(this)" class="form-control date-picker birthday">
                                        
                                        s.d
                                        <input type="text" name="selesai" id="tglakh" value="{{date('m/d/Y',strtotime($tglakh))}}" onchange="setdata(this)" class="form-control date-picker birthday">
                                    </div>
                                </div>
                                @php
                            setlocale(LC_ALL, 'IND');
                            
                            $tgl= strftime('%d %B %Y', strtotime($tglaw));
                            @endphp
                                <br>
                                <div class="table table-responsive">
                                      <table id="datatable" class="table table-bordered text-center" style="width: 100%;">
                                        <thead align="center">
                                            <tr>
                                                <th style="vertical-align: middle; text-align: center;width: 5%;">Tanggal</th>
                                                <th style="vertical-align: middle; text-align: center;">Nomor Transaksi</th>
                                                <th style="vertical-align: middle; text-align: center;">Uraian</th>
                                                <th style="vertical-align: middle; text-align: center;">Kode Biaya</th>
                                                <th style="vertical-align: middle; text-align: center;">Masuk</th>
                                                <th style="vertical-align: middle; text-align: center;">Keluar</th>
                                                <th style="vertical-align: middle; text-align: center;">Saldo</th>
                                            </tr>
                                        </thead>                                       
                                        <tbody id="data">
                                            <tr>
                                                <td style="width: 10%;">{{$tglaw}}</td>
                                                <td style="text-align: left;width: 10%;"></td>
                                                <td style="text-align: left; font-weight:bold;width: 20%;">SALDO AWAL</td>
                                                <td style="text-align: left;width: 5%;"></td>
                                                <td style="text-align: right;width: 15%;{{($saldo<=0)? 'color:red;':''}}">Rp {{number_format($temp->getsaldoawal($tglaw),0,",",".")}}</td>
                                                <td style="text-align: right;width: 15%;"></td>
                                                <td style="text-align: right;width: 15%;"></td>
                                            </tr>
                                            @foreach($kas as $ka)
                                            @php 
                                            if(!$ka->kode){
                                                $saldo+=$ka->saldo;
                                            }
                                            else{
                                                $saldo-=$temp->tothargasaat($ka->kode, $ka->tglNota,$ka->nonota, $ka->no_baris);
                                            }
                                            
                                            @endphp
                                            <tr>
                                                <td style="width: 10%;">{{$ka->tglNota}}</td>
                                                <td style="text-align: left;width: 10%;">{{$ka->nonota}}</td>
                                                <td style="text-align: left;width: 25%;">{{$ka->uraian}}</td>
                                                <td style="text-align: left;width: 5%;">{{$ka->kode}}</td>
                                                <td style="text-align: right;width: 15%;">{{(!$ka->kode)?'Rp '.number_format($ka->saldo,0,",","."):'-'}}</td>
                                                <td style="text-align: right;width: 15%;"> {{$ka->kode?'Rp '.number_format($temp->tothargasaat($ka->kode, $ka->tglNota, $ka->nonota , $ka->no_baris),0,",","."):'-'}}</td>
                                                <td style="text-align: right;width: 15%;{{($saldo<=0)? 'color:red;':''}}">Rp {{number_format($saldo,0,",",".")}}</td>
                                            </tr>
                                            @endforeach

                                        @php
                                            $saldo=$temp->getsaldoakhir($tglaw,$tglakh);
                                        @endphp

                                        </tbody>
                                        <tfoot id=tfoot>
                                            <tr>
                                                <td colspan="4" style="text-align: right;">JUMLAH</td>
                                                <td style="text-align: right;">Rp {{number_format($temp->grantotmasukkas($tglaw,$tglakh),0,",",".")}}</td>
                                                <td style="text-align: right;">Rp {{number_format($temp->grantotkeluarkas($tglaw,$tglakh),0,",",".")}}</td>
                                                <td style="text-align: right;{{($saldo<=0)? 'color:red;':''}}">Rp {{number_format($saldo,0,",",".")}}</td>
                                            </tr>
                                        </tfoot>
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
        
    var url="setbukukas/"+valaw+"/"+valakh
    $.get(url, function(data){
        $('#data').html(data)
    })

    url="setbukukasfoot/"+valaw+"/"+valakh
    $.get(url, function(data){
        $('#tfoot').html(data)
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
    
    var url="bukukaspdf/"+valaw+"/"+valakh
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


