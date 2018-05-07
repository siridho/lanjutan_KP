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

                    <div class="panel-heading text-center">Rekapitulasi Material <br> Proyek {{session()->get('namaproyek')}}
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
                                      <table id="datatable" class="table table-bordered text-center" style="width: 100%;">
                                        <thead align="center">
                                            <tr>
                                                <th rowspan="2" style="vertical-align: middle; text-align: center;">Kode</th>
                                                <th rowspan="2" style="vertical-align: middle; text-align: center; width: 15%;">Nama Material</th>
                                                <th colspan="3" style="vertical-align: middle; text-align: center;">Masuk</th>
                                                <th colspan="2" style="vertical-align: middle; text-align: center;">Keluar</th>
                                                <th colspan="2" style="vertical-align: middle; text-align: center;">Saldo</th>
                                            </tr>
                                            <tr>
                                                <th style="vertical-align: middle; text-align: center; width: 8%;">Kuantum</th>
                                                <th style="vertical-align: middle; text-align: center; width: 15%;">Harga</th>
                                                <th style="vertical-align: middle; text-align: center; width: 15%;">Harga @</th>
                                                <th style="vertical-align: middle; text-align: center; width: 8%;">Kuantum</th>
                                                <th style="vertical-align: middle; text-align: center; width: 15%;">Harga</th>
                                                <th style="vertical-align: middle; text-align: center; width: 8%;">Kuantum</th>
                                                <th style="vertical-align: middle; text-align: center; width: 15%;">Harga</th>
                                            </tr>
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">                                   
                                        <tbody id='data'>
                                            @foreach($material_proyeks as $material_proyek)
                                            @php 

                                            $jummasuk= $material_proyek->totkuantummasuk($material_proyek->kodeMaterial,$tgl);
                                            $jumkeluar=$material_proyek->totkuantumkeluar($material_proyek->kodeMaterial,$tgl);

                                            @endphp
                                            @if($jummasuk||$jumkeluar)
                                            <tr>
                                                <td>{{$material_proyek->kodeMaterial}}</td>
                                                <td style="text-align: left;">{{$material_proyek->material->nama}}</td>

                                                <td>{{  $material_proyek->totkuantummasuk($material_proyek->kodeMaterial,$tgl) }}</td>
                                                <td style="text-align: right;">Rp {{ number_format($material_proyek->tothargamasuk($material_proyek->kodeMaterial,$tgl),0,",",".") }}</td>
                                                <td style="text-align: right;">Rp {{ number_format($material_proyek->hitungratarata($material_proyek->kodeMaterial,$tgl),0,",",".")  }}</td>

                                                <td>{{ $material_proyek->totkuantumkeluar($material_proyek->kodeMaterial,$tgl) }}</td>
                                                <td style="text-align: right;">Rp {{ number_format($material_proyek->tothargakeluar($material_proyek->kodeMaterial,$tgl),0,",",".") }}</td>

                                                <td>{{ $material_proyek->hitungsaldokuantum($material_proyek->kodeMaterial,$tgl) }}</td>
                                                <td style="text-align: right;">Rp {{ number_format($material_proyek->hitungsaldoharga($material_proyek->kodeMaterial,$tgl),0,",",".") }}</td>
                                            </tr>
                                            @endif    
                                            @endforeach
                                        </tbody>
                                        <tfoot id='tfoot'>
                                            <tr>
                                                <td colspan="2">JUMLAH</td>
                                                <td></td>
                                                <td style="text-align: right;">Rp {{ number_format($material_proyek->grandtothargamasuk($tgl),0,",",".") }}</td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align: right;">Rp {{ number_format($material_proyek->grandtothargakeluar($tgl),0,",",".") }}</td>
                                                <td></td>
                                                <td style="text-align: right;">Rp {{ number_format($material_proyek->grandtotsaldo($tgl),0,",",".") }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            {!! Form::close() !!}

<script type="text/javascript"> 


function setdata(param){
    var val=param.value;
    // var spl=val.split('/')
    val=val.toString();
    var spl=val.split('/')
    val = spl[2]+'-'+spl[0]+'-'+spl[1]
    // alert(val)
    var url="setrekapmaterial/"+val
    $.get(url, function(data){
        $('#data').html(data)
    })

    url="setrekapmaterialfoot/"+val
    $.get(url, function(data){
        $('#tfoot').html(data)
    })

}

function printpdf(){
    var val=$('#tgl').val();
    val=val.toString();
    var spl=val.split('/')
    val = spl[2]+'-'+spl[0]+'-'+spl[1]
    var url="rekapmaterialpdf/"+val
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
