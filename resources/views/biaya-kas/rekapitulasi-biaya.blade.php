<?php use App\Http\Controllers\materialsController; ?>

@extends('layouts.template')

@section('title','Rekapitulasi Material')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading text-center">Rekapitulasi Kas <br> Proyek {{session()->get('namaproyek')}}
                    </div>
                    <div class="panel-body">
                    <a id="print" onclick="printpdf()" class="btn btn-primary btn-sm" title="CSV"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
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
                                    <label class="control-label col-md-2">
                                        s.d tanggal 
                                    </label>
                                    <div class="col-md-2">
                                        <input type="text" name="tgl" id='tgl' value=""  onchange="setdata(this)" class="form-control date-picker birthday">
                                    </div>
                                    <label class="control-label col-md-2">
                                        Pilih Jenis Biaya
                                    </label>
                                    <div class="col-md-3">
                                        <select name="jenis" id="jenis" class="form-control" onchange="setdata(this)">
                                            <option value="0">Semua</option>
                                            <option value="2">Alat</option>
                                            <option value=3>Upah</option>
                                            <option value=4>Biaya Operasinal lapangan</option>
                                            <option value="5">Biaya Umum Proyek</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <br>
                                <div class="table table-responsive">
                                      <table id="datatable" class="table table-bordered text-center" style="width: 100%;">
                                        <thead align="center">
                                            <tr>
                                                <th style="vertical-align: middle; text-align: center; width: 8%;">Kode</th>
                                                <th  style="vertical-align: middle; text-align: center; width: 25%;">Nama Material</th>
                                                <th style="vertical-align: middle; text-align: center; width: 8%;">Volume</th>
                                                <th style="vertical-align: middle; text-align: center; width: 15%;">Harga</th>
                                                <th style="vertical-align: middle; text-align: center; width: 15%;">Harga Satuan</th>
                                                
                                            </tr>
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">                                   
                                        <tbody id='data'>
                                          @foreach($biayas as $biaya)
                                          @if($temp->totkuantum($biaya->kode, $tgl))
                                            <tr>
                                                <td>{{$biaya->kode}}</td>
                                                <td style="vertical-align: middle; text-align: left; width: 25%;">{{$biaya->nama}}</td>
                                                <td style="vertical-align: middle; text-align: left; width: 15%;">{{$temp->totkuantum($biaya->kode, $tgl)}} {{$biaya->satuan}}</td>
                                                <td style="text-align: right;">Rp {{number_format($temp->totharga($biaya->kode, $tgl),0,",",".")}}</td>
                                                <td style="text-align: right;">Rp {{number_format($temp->hitungratarata($biaya->kode, $tgl),0,",",".")}}</td>
                                            </tr>
                                            @endif
                                          @endforeach
                                        </tbody>
                                        <tfoot id='tfoot'>
                                            <td colspan="3">JUMLAH</td>
                                                <td style="text-align: right; font-weight: bold;">Rp {{ number_format($temp->grandtotharga(0,$tgl),0,",",".") }}</td>
                                                <td></td>
                                        </tfoot>
                                    </table>
                                </div>
                            {!! Form::close() !!}

<script type="text/javascript"> 


function setdata(param){
    var val=$('#tgl').val()
    var jenis=$('#jenis').val()
    // var spl=val.split('/')
    val=val.toString();
    var spl=val.split('/')
    val = spl[2]+'-'+spl[0]+'-'+spl[1]
    // alert(val)
    var url="setrekapbiaya/"+jenis+'/'+val
    $.get(url, function(data){
        $('#data').html(data)
    })

    url="setrekapbiayafoot/"+jenis+'/'+val
    $.get(url, function(data){
        $('#tfoot').html(data)
    })
}

function printpdf(){
    var val=$('#tgl').val()
    val=val.toString();
    var spl=val.split('/')
    val = spl[2]+'-'+spl[0]+'-'+spl[1]

    var jenis=$('#jenis').val()
    var url="rekapkaspdf/"+val+"/"+jenis
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
