@extends('layouts.template')

@section('title','Rekapitulasi Penggunaan Material')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading text-center">Rekapitulasi Penggunaan Material <br> Proyek IGD RSUD Sidoarjo
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
                                        <input type="text" name="mulai" id="tglaw" onchange="setdata(this)" class="form-control date-picker birthday">
                                        
                                        s.d
                                        <input type="text" name="selesai" id="tglakh" onchange="setdata(this)" class="form-control date-picker birthday">
                                    </div>
                                </div>
                                
                                <br>
                                <div class="table table-responsive">
                                      <table id="datatable" class="table table-bordered text-center" style="width: 100%;">
                                        <thead align="center">
                                            <tr>
                                                <th style="vertical-align: middle; text-align: center;" rowspan="2" style="width: 5%;">Kode</th>
                                                <th style="vertical-align: middle; text-align: center;" rowspan="2">Nama Material</th>
                                                <th style="vertical-align: middle; text-align: center;" rowspan="2">Harga @ Rata-Rata</th>

                                                <th style="vertical-align: middle; text-align: center;" colspan="2">s.d Periode Lalu</th>
                                                <th style="vertical-align: middle; text-align: center;" colspan="2">Periode Ini</th>
                                                <th style="vertical-align: middle; text-align: center;" colspan="2">s.d. Periode Ini</th>
                                            </tr>
                                            <tr>
                                                <th style="vertical-align: middle; text-align: center; width: 8%;">Kuantum</th>
                                                <th style="vertical-align: middle; text-align: center; width: 15%;" >Harga</th>
                                                <th style="vertical-align: middle; text-align: center; width: 8%;">Kuantum</th>
                                                <th style="vertical-align: middle; text-align: center; width: 15%;">Harga</th>
                                                <th style="vertical-align: middle; text-align: center; width: 8%;">Kuantum</th>
                                                <th style="vertical-align: middle; text-align: center; width: 15%;" >Harga</th>
                                            </tr>
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">                                   
                                        <tbody id="data">
                                            @foreach($material_proyeks as $material_proyek)
                                            @php 

                                            $hargarata= $material_proyek->hitungratarata($material_proyek->kodeMaterial,$tglakh);
                                            $tgl=date('Y-m-d', strtotime($tglaw. ' -1 days'));
                                            
                                            @endphp
                                            @if($hargarata)
                                            <tr>
                                                <td>{{$material_proyek->kodeMaterial}}</td>
                                                <td style="text-align: left;">{{$material_proyek->material->nama}}</td>

                                                <td style="text-align: right;">Rp {{$hargarata}}</td>
                                                <td>{{ $material_proyek->totkuantumkeluar($material_proyek->kodeMaterial,$tgl) }}</td>
                                                <td style="text-align: right;">Rp {{ number_format($material_proyek->tothargakeluar($material_proyek->kodeMaterial,$tgl),0,",",".") }}</td>

                                                <td>{{ $material_proyek->kuantumperiode($material_proyek->kodeMaterial,$tglaw,$tglakh) }}</td>
                                                <td style="text-align: right;">Rp {{ number_format($material_proyek->kuantumperiode($material_proyek->kodeMaterial,$tglaw,$tglakh)*$hargarata,0,",",".")}}</td>

                                                <td>{{ $material_proyek->totkuantumkeluar($material_proyek->kodeMaterial,$tglakh) }}</td>
                                                <td style="text-align: right;">Rp {{ number_format($material_proyek->tothargakeluar($material_proyek->kodeMaterial,$tglakh),0,",",".")}}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                        <tfoot id=tfoot>
                                            <tr>
                                                <td colspan="3">JUMLAH</td>
                                                <td></td>
                                                <td style="vertical-align: middle; text-align: right;">Rp {{$material_proyek->grandtothargakeluar($tgl)}}</td>
                                                <td></td>
                                                <td style="vertical-align: middle; text-align: right;">Rp {{$material_proyek->grandtothargakeluarperiode($tglaw,$tglakh)}}</td>
                                                <td></td>
                                                <td style="vertical-align: middle; text-align: right;">Rp {{$material_proyek->grandtothargakeluar($tglakh)}}</td>
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
        
    var url="setpenggunaanmaterial/"+valaw+"/"+valakh
    $.get(url, function(data){
        $('#data').html(data)
    })

    url="setpenggunaanmaterialtfoot/"+valaw+"/"+valakh
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
    var url="rekappenggunaanpdf/"+valaw+"/"+valakh
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


